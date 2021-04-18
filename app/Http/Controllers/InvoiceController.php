<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Company;
use App\Models\ReceivedPayment;
use App\Models\CModel;
use App\Models\Client;
use App\Models\Item;
use App\Models\InvoiceItem;
use DataTables;
use Validator;
use View;
use DB;
use PDF;
use LaravelDaily\Invoices\Invoice as PInvoice;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem as PInvoiceItem;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if($request->ajax())
        {
            $invoice = Invoice::with('client');
            return DataTables::of($invoice)
                    ->addColumn('model', function($invoice){
                        $model=CModel::where('default',1)->first();
                        if($invoice->client->model_id){
                            $model=CModel::findOrFail($invoice->client->model_id);
                        }
                        if($invoice->model_id){
                            $model=CModel::findOrFail($invoice->model_id);
                        }
                        $b= '<a type="button" title="Edit Model" target="_blank" name="print" href="'.route('cmodels.edit',$model->id).'">'.$model->name.'</a>';
                        return $b;
                    })
                    ->addColumn('payment', function($invoice){
                        $b='<a type="button"
                         title="Enter payment"
                          href="'.route('receivedpayments.create',['invoice_id'=>$invoice->id]).'"
                           class="btn btn-danger btn-sm">Draft</a><a type="button"
                           title="Change as paid"
                            href="'.route('invoice.paid',['invoice'=>$invoice]).'"
                             class="btn btn-success btn-sm">Paid?</a>';
                        if($invoice->received==$invoice->amount){
                            $b= '<h3 class="text-success">Paid</h3>';

                        }
                        if($invoice->received>0 && $invoice->received<$invoice->amount){
                            $b= '<a type="button" title="Enter payment" href="'.route('receivedpayments.create',['invoice_id'=>$invoice->id]).'" class="btn btn-warning">Partial</a><a type="button"
                            title="Change as paid"
                             href="'.route('invoice.paid',['invoice'=>$invoice]).'"
                              class="btn btn-success btn-sm">Paid?</a>';
                            
                        }
                        return $b;
                    })
                    ->addColumn('action', function($invoice){
                        $button= '<a type="button" title="Download" name="download" href="'.route('invoices.download',$invoice->id).'" class="edit btn btn-warning btn-xs"><i class="fas fa-file-pdf"></i></a>';
                        if(!$invoice->locked){
                            $button .= '<a type="button" title="Edit invoice"  name="edit" href="'.route('invoices.edit',$invoice->id).'" class="edit btn btn-primary btn-xs"><i class="fas fa-pen"></i></a>';
                            $button .= '<a type="button" title="Edit Model" target="_blank" name="print" href="'.route('invoices.print',$invoice->id).'" class="edit btn btn-success btn-xs"><i class="fas fa-edit"></i></a>';
                        }
                        $button .= '<button title="Lock" id="delete'.$invoice->id.'" onclick="lock('.$invoice->id.')" type="button" name="edit"class="btn btn-dark btn-xs"><i class="fas fa-lock"></i></button>';
                        if(!$invoice->locked){
                            $button .= '<button  type="button" title="Delete" name="edit" id="'.$invoice->id.'" class="delete btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></button>';
                        }
                        return $button;
                    })
                    ->rawColumns(['model','action','payment'])
                    ->toJson();
        }
        return view('client.invoice.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('client.invoice.create')
        ->with('items',Item::all())
        ->with('companies',Company::all())
        ->with('clients',Client::all());
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $from_date='';
        $to_date='';
        if($request->type=='month'){
            $from_date=$request->from_date_m;
            $to_date=$request->to_date_m;
        }
        if($request->type=='week'){
            $from_date=$request->from_date_w;
            $to_date=$request->to_date_w;
        }
        $inv_number='Inv'.$request->invoice_date[8].$request->invoice_date[9].$request->invoice_date[3].$request->invoice_date[4].$request->invoice_date[0].$request->invoice_date[1];
        $vdd='01';
        $n=DB::table('invoices')->select(DB::raw('lpad(substring(inv_number,10,2)+1,2,"0") as vdd'))->where(DB::raw('substring(inv_number,1,9)'),'=',$inv_number)->get();
        $m=count($n)+1;
        if  ($m>=9)
        {
			$vdd=$m;
		}elseif($m<9 &&$m>0){
            $vdd='0'.$m;
        }
        $inv_number=$inv_number.$vdd;	
        $form_data = array(
            'company_id'        =>  $request->company_id,
            'client_id'         =>  $request->client_id,
            'invoice_date'         =>  $request->invoice_date,
            'inv_number'         => $inv_number,
            'from_date'         =>  $from_date,
            'to_date'         =>  $to_date,
            'type'         =>  $request->type,
            'recurring'         =>  $request->recurring,
            'model_id'         =>  0,
            'amount'         =>  0,
        );
        // dd($form_data);
        $invoice=Invoice::create($form_data);
        // dd($invoice);
        return redirect(route('invoices.add_items' ,$invoice));

    }

    public function paid(Invoice $invoice){
        $invoice->received=$invoice->amount;
        $invoice->save();
        return redirect()->back();
    }
    public function print(Invoice $invoice){
        $model=CModel::where('default',1)->first();
        if($invoice->model_id){
            $model=CModel::findOrFail($invoice->model_id);
        }
        return view('client.invoice.print')
            ->with('invoice',$invoice)
            ->with('models',CModel::all())
            ->with('model',$model);
    }
    public function download(Invoice $invoice){
        $paydate_raw = DB::raw("STR_TO_DATE(`payment_date`, '%d-%m-%Y')");

        $start_raw = DB::raw("STR_TO_DATE(?, '%d-%m-%Y')");
        $end_raw = DB::raw("STR_TO_DATE(?, '%d-%m-%Y')");
        
        $inv_date=date('d-m-Y',strtotime($invoice->invoice_date));
        $time = strtotime($invoice->invoice_date);
        $to_date = $invoice->type == 'month' ? date('d-m-Y', strtotime("+1 months", $time)): date('d-m-Y', strtotime("+1 week", $time));
        
        $model=CModel::where('default',1)->first();
        // dd($to_date);
        $payments = ReceivedPayment::where('client_id',$invoice->client_id)
                    ->where($paydate_raw, '>', $start_raw)
                    ->where($paydate_raw, '>', $start_raw)
                    ->setBindings([$invoice->client_id,$inv_date, $to_date,'cancelled'])
                    ->get();

        if($invoice->client->model_id){
            $model=CModel::findOrFail($invoice->client->model_id);
        }
        if($invoice->model_id){
            $model=CModel::findOrFail($invoice->model_id);
        }
        $previous=Invoice::where('client_id',$invoice->client_id)
        ->where('background', '<>', 'cancelled')
        ->where('id', '<>',$invoice->id)
        ->whereraw('(invoices.received is NULL AND invoices.amount is NOT NULL) OR invoices.received < invoices.amount')
        ->whereraw('STR_TO_DATE(invoice_date,"%d-%m-%Y") < '.$inv_date)
        ->get();
        // dd($previous);
        $view=View::make('client.invoice.download',[
                                            'invoice' => $invoice,
                                            'previous'=>$previous,
                                            'payments'=>$payments,
                                            'model'=>$model
                                        ]);
        $html_content=$view->render();
        // dd($html_content);
        PDF::SetTitle('Invoice');
        PDF::AddPage();
        if($model->pdf_ml && $model->pdf_mt && $model->pdf_mr){
            PDF::SetMargins($model->pdf_ml,$model->pdf_mt,$model->pdf_mr);
        }
        $bg=asset('imgs/'.$invoice->background.'.jpg');

        PDF::Image($bg, 40,1, 105, 130, '', '', '', false, 300, '', false, false, 0);
        PDF::setPageMark();
        PDF::writeHTML($html_content,true,false,true,false,'');
        PDF::Output($invoice->client->name.$invoice->inv_number.'.pdf');
        // return $html_content;
        
    }
    
    public function add_item(Invoice $invoice,Request $request)
    {
        return view('client.invoice.add_items')
        ->with('invoice',$invoice)
        ->with('clients',Client::all())
        ->with('items',Item::all())
        ->with('companies',Company::all());
    }
    public function store_item(Invoice $invoice,Request $request)
    {
        if($invoice->amount == 0 || $invoice->received < $invoice->amount){
            InvoiceItem::create([
                'invoice_id'=>$invoice->id,
                'quantity'=>$request->quantity,
                'item_id'=>$request->item_id
            ]);
            $item=Item::findOrFail($request->item_id);
            $invoice->amount=$invoice->amount+$request->quantity*$item->rate;
            $invoice->save();
        }
        return redirect(route('invoices.add_items' ,$invoice));
    }
    
    public function edit_item(Invoice $invoice,InvoiceItem $item,Request $request)
    {
        return view('client.invoice.edit_item')
        ->with('invoice',$invoice)
        ->with('item1',$item)
        ->with('clients',Client::all())
        ->with('items',Item::all())
        ->with('companies',Company::all());
    }
    public function delete_item(Invoice $invoice,InvoiceItem $item,Request $request)
    {
        $item->delete();
        if($invoice->amount>0){
            $invoice->amount-=$item->quantity*$item->item->rate;
        }
        $invoice->save();
        return redirect(route('invoices.add_items',$invoice));
    }
    public function update_item(Invoice $invoice,InvoiceItem $item,Request $request)
    {
        $old_item=$item->item;
        $new_item=Item::findOrFail($request->item_id);
        $invoice->amount-=$item->quantity*$item->item->rate;

        $item->update([
            'invoice_id'=>$invoice->id,
            'quantity'=>$request->quantity,
            'item_id'=>$request->item_id
        ]);
        $invoice->amount+=$item->quantity*$item->item->rate;
        $invoice->save();
        return redirect(route('invoices.add_items',$invoice));
    }

    public function edit(Invoice $invoice)
    {
        // dd($invoice);
        return view('client.invoice.edit')->with('invoice',$invoice)
        ->with('items',Item::all())
        ->with('companies',Company::all())
        ->with('clients',Client::all());
    }

    
    public function change_model(Request $request, Invoice $invoice)
    {

        $form_data = array(
            'model_id'        =>  $request->model_id,
            );
        
        $invoice->update($form_data);

        return redirect(route('invoices.print',$invoice));

    }
    public function update(Request $request, Invoice $invoice)
    {
        // dd($request->all());
        $from_date='';
        $to_date='';
        if($request->type=='month'){
            $from_date=$request->from_date_m;
            $to_date=$request->to_date_m;
        }
        if($request->type=='week'){
            $from_date=$request->from_date_w;
            $to_date=$request->to_date_w;
        }
        $form_data = array(
            'company_id'        =>  $request->company_id,
            'client_id'         =>  $request->client_id,
            'invoice_date'         =>  $request->invoice_date,
            'from_date'         =>  $from_date,
            'to_date'         =>  $to_date,
            'type'         =>  $request->type,
            'recurring'         =>  $request->recurring,
            'background'         =>  $request->background,
            'received'         =>  $request->received,
        );
        $invoice->update($form_data);

        return redirect(route('invoices.add_items',$invoice));

    }

    public function lock($id)
    {

        $invoice = Invoice::findOrFail($id);
        if($invoice->locked==1){
            $invoice->locked=0;
        }else{
            $invoice->locked=1;
        }
        $invoice->save();
    }
    public function destroy($id)
    {

        $invoice = Invoice::findOrFail($id);
        $invoice->invoice_items()->delete();
        $invoice->delete();
    }
}

