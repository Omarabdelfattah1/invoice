<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VInvoic;
use App\Models\Company;
use App\Models\Vendor;
use App\Models\VItem;
use App\Models\VModel;
use App\Models\VInvoicItem;
use DataTables;
use Validator;
use View;
use PDF;
use LaravelDaily\Invoices\Invoice as PInvoice;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem as PInvoiceItem;

class VInvoiceController extends Controller
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
            $vinvoice = VInvoic::latest()->get();
            return DataTables::of($vinvoice)
                    ->addColumn('action', function($vinvoice){
                        $button='';
                        if(!$vinvoice->locked){
                            $button = '<a type="button" id="edit{{$vinvoice->id}}" name="edit" href="'.route('vinvoices.edit',$vinvoice->id).'" class="edit btn btn-primary btn-xs"><i class="fas fa-pen"></i></a>';
                            $button .= '<button id="delete{{$vinvoice->id}}" type="button" name="edit" id="'.$vinvoice->id.'" class="delete btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></button>';
                            $button .= '<a type="button" name="download" href="'.route('vinvoices.download',$vinvoice->id).'" class="edit btn btn-warning btn-xs"><i class="fas fa-file-pdf"></i></a>';
                        }
                        $button .= '<a type="button" id="download{{$vinvoice->id}}"  target="_blank" name="print" href="'.route('vinvoices.print',$vinvoice->id).'" class="edit btn btn-success btn-xs"><i class="fas fa-edit"></i></a>';
                        $button .= '<button id="delete'.$vinvoice->id.'" id="delete{{$vinvoice->id}}" type="button" name="edit" id="'.$vinvoice->id.'" class="delete btn btn-dark btn-xs"><i class="fas fa-lock"></i></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('vendor.invoice.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vendor.invoice.create')
        ->with('items',VItem::all())
        ->with('companies',Company::all())
        ->with('clients',Vendor::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inv_number='Inv'.$request->invoice_date[8].$request->invoice_date[9].$request->invoice_date[3].$request->invoice_date[4].$request->invoice_date[0].$request->invoice_date[1];
        $vdd='01';
        $n=DB::table('vinvoices')->select(DB::raw('lpad(substring(inv_number,10,2)+1,2,"0") as vdd'))->where(DB::raw('substring(inv_number,1,9)'),'=',$inv_number)->get();
        if  (count($n)>=10)
        {
			$vdd=count($n);
		}elseif(count($n)>=10 &&count($n)>0){
            $vdd='0'.count($n);
        }
        $inv_number=$inv_number.$vdd;
        $form_data = array(
            'company_id'        =>  $request->company_id,
            'vendor_id'         =>  $request->client_id,
            'invoice_date'         =>  $request->invoice_date,
            'inv_number'         => $inv_number,
            'from_date'         =>  $request->from_date,
            'to_date'         =>  $request->to_date,
            'type'         =>  $request->type,
            'model_id'         =>  0,
            'amount'         =>  0,
        );
        $vinvoice=VInvoic::create($form_data);
        return redirect(route('vinvoices.add_items',$vinvoice));

    }
    public function download(VInvoic $vinvoice){
        $model=VModel::first();
        if($vinvoice->model_id){
            $model=VModel::findOrFail($vinvoice->model_id);
        }
        $view=View::make('vendor.invoice.download',[
                                            'vinvoice' => $vinvoice,
                                            'model'=>$model
                                        ]);
        $html_content=$view->render();
        PDF::SetTitle('Invoice');
        PDF::AddPage();
        PDF::writeHTML($html_content,true,false,true,false,'');
        PDF::Output($vinvoice->company->name.$vinvoice->inv_number.'.pdf');
        return $html_content;
        
    }
    public function print(VInvoic $vinvoice){
        $model=VModel::first();
        if($vinvoice->model_id){
            $model=VModel::findOrFail($vinvoice->model_id);
        }
        return view('vendor.invoice.print')
            ->with('vinvoice',$vinvoice)
            ->with('models',VModel::all())
            ->with('model',$model);
    }
    
    public function add_item(VInvoic $vinvoice,Request $request)
    {
        return view('vendor.invoice.add_items')
        ->with('vinvoice',$vinvoice)
        ->with('items',VItem::all())
        ->with('companies',Company::all())
        ->with('clients',Vendor::all());;
    }
    public function store_item(VInvoic $vinvoice,Request $request)
    {
        VInvoicItem::create([
            'v_invoic_id'=>$vinvoice->id,
            'quantity'=>$request->quantity,
            'v_item_id'=>$request->item_id
        ]);
        $item=VItem::findOrFail($request->item_id);
        $vinvoice->amount=$vinvoice->amount+$request->quantity*$item->rate;
        $vinvoice->save();
        return redirect(route('vinvoices.add_items',$vinvoice));
    }
    
    public function edit_item(VInvoic $vinvoice,VInvoicItem $item,Request $request)
    {
        return view('vendor.invoice.edit_item')
        ->with('vinvoice',$vinvoice)
        ->with('item1',$item)
        ->with('clients',Vendor::all())
        ->with('items',VItem::all())
        ->with('companies',Company::all());
    }
    public function delete_item(VInvoic $vinvoice,VInvoicItem $item,Request $request)
    {
        $item->delete();
        $vinvoice->amount-=$item->quantity*$item->item->rate;
        $vinvoice->save();
        return redirect(route('vinvoices.add_items',$vinvoice));
    }
    public function update_item(VInvoic $vinvoice,VInvoicItem $item,Request $request)
    {
        $old_item=$item->item;
        $new_item=VItem::findOrFail($request->item_id);
        $vinvoice->amount-=$item->quantity*$item->item->rate;

        $item->update([
            'invoice_id'=>$vinvoice->id,
            'quantity'=>$request->quantity,
            'item_id'=>$request->item_id
        ]);
        $vinvoice->amount+=$item->quantity*$item->item->rate;
        $vinvoice->save();
        return redirect(route('vinvoices.add_items',$vinvoice));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $vinvoice
     * @return \Illuminate\Http\Response
     */
    public function edit(VInvoic $vinvoice)
    {

        return view('vendor.invoice.edit')->with('vinvoice',$vinvoice)
        ->with('items',VItem::all())
        ->with('companies',Company::all())
        ->with('clients',Vendor::all());
    }

    public function change_model(Request $request, VInvoice $vinvoice)
    {

        $form_data = array(
            'model_id'        =>  $request->model_id,
            );
        
        $vinvoice->update($form_data);

        return redirect(route('vinvoices.print',$vinvoice));

    }
    public function update(Request $request, VInvoic $vinvoice)
    {
        $vinvoice->update($request->except('_taken'));

        return redirect(route('vinvoices.add_items',$vinvoice));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sample_data  $vinvoice
     * @return \Illuminate\Http\Response
     */
    public function lock($id)
    {

        $vinvoice = VInvoic::findOrFail($id);
        $vinvoice->locked=1;
        $vinvoice->save();
    }
    public function destroy($id)
    {

        $vinvoice = VInvoic::findOrFail($id);
        $vinvoice->invoice_items()->delete();
        $vinvoice->delete();
    }
}

