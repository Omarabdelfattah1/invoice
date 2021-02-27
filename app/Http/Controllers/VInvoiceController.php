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
            $vinvoic = VInvoic::latest()->get();
            return DataTables::of($vinvoic)
                ->addColumn('model', function($vinvoic){
                    $model=VModel::first();
                    if($vinvoic->model_id){
                        $model=VModel::findOrFail($vinvoic->model_id);
                    }
                    $b= '<a type="button" title="Edit Model" target="_blank" name="print" href="'.route('vmodels.edit',$model->id).'">'.$model->name.'</a>';
                    return $b;
                })
                ->addColumn('action', function($vinvoic){
                    $button= '<a type="button" title="Download" name="download" href="'.route('invoices.download',$vinvoic->id).'" class="edit btn btn-warning btn-xs"><i class="fas fa-file-pdf"></i></a>';
                    if(!$vinvoic->locked){
                        $button .= '<a type="button" title="Edit invoice"  name="edit" href="'.route('invoices.edit',$vinvoic->id).'" class="edit btn btn-primary btn-xs"><i class="fas fa-pen"></i></a>';
                        $button .= '<a type="button" title="Edit Model" target="_blank" name="print" href="'.route('invoices.print',$vinvoic->id).'" class="edit btn btn-success btn-xs"><i class="fas fa-edit"></i></a>';
                    }
                    $button .= '<button title="Lock" id="delete'.$vinvoic->id.'" onclick="lock('.$vinvoic->id.')" type="button" name="edit"class="btn btn-dark btn-xs"><i class="fas fa-lock"></i></button>';
                    if(!$vinvoic->locked){
                        $button .= '<button  type="button" title="Delete" name="edit" id="'.$vinvoic->id.'" class="delete btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></button>';
                    }
                    return $button;
                })
                ->rawColumns(['model','action'])
                ->toJson();
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
            'vendor_id'         =>  $request->client_id,
            'invoice_date'         =>  $request->invoice_date,
            'inv_number'         => $inv_number,
            'from_date'         =>  $request->from_date,
            'to_date'         =>  $request->to_date,
            'type'         =>  $request->type,
            'model_id'         =>  0,
            'amount'         =>  0,
        );
        $vinvoic=VInvoic::create($form_data);
        return redirect(route('vinvoices.add_items',$vinvoic));

    }
    public function download(VInvoic $vinvoic){
        $model=VModel::first();
        if($vinvoic->model_id){
            $model=VModel::findOrFail($vinvoic->model_id);
        }
        $view=View::make('vendor.invoice.download',[
                                            'vinvoic' => $vinvoic,
                                            'model'=>$model
                                        ]);
        $html_content=$view->render();
        PDF::SetTitle('Invoice');
        PDF::AddPage();
        PDF::writeHTML($html_content,true,false,true,false,'');
        PDF::Output($vinvoic->company->name.$vinvoic->inv_number.'.pdf');
        return $html_content;
        
    }
    public function print(VInvoic $vinvoic){
        $model=VModel::first();
        if($vinvoic->model_id){
            $model=VModel::findOrFail($vinvoic->model_id);
        }
        return view('vendor.invoice.print')
            ->with('vinvoic',$vinvoic)
            ->with('models',VModel::all())
            ->with('model',$model);
    }
    
    public function add_item(VInvoic $vinvoic,Request $request)
    {
        return view('vendor.invoice.add_items')
        ->with('vinvoic',$vinvoic)
        ->with('items',VItem::all())
        ->with('companies',Company::all())
        ->with('clients',Vendor::all());;
    }
    public function store_item(VInvoic $vinvoic,Request $request)
    {
        VInvoicItem::create([
            'v_invoic_id'=>$vinvoic->id,
            'quantity'=>$request->quantity,
            'v_item_id'=>$request->item_id
        ]);
        $item=VItem::findOrFail($request->item_id);
        $vinvoic->amount=$vinvoic->amount+$request->quantity*$item->rate;
        $vinvoic->save();
        return redirect(route('vinvoices.add_items',$vinvoic));
    }
    
    public function edit_item(VInvoic $vinvoic,VInvoicItem $item,Request $request)
    {
        return view('vendor.invoice.edit_item')
        ->with('vinvoic',$vinvoic)
        ->with('item1',$item)
        ->with('clients',Vendor::all())
        ->with('items',VItem::all())
        ->with('companies',Company::all());
    }
    public function delete_item(VInvoic $vinvoic,VInvoicItem $item,Request $request)
    {
        $item->delete();
        $vinvoic->amount-=$item->quantity*$item->item->rate;
        $vinvoic->save();
        return redirect(route('vinvoices.add_items',$vinvoic));
    }
    public function update_item(VInvoic $vinvoic,VInvoicItem $item,Request $request)
    {
        $old_item=$item->item;
        $new_item=VItem::findOrFail($request->item_id);
        $vinvoic->amount-=$item->quantity*$item->item->rate;

        $item->update([
            'invoice_id'=>$vinvoic->id,
            'quantity'=>$request->quantity,
            'item_id'=>$request->item_id
        ]);
        $vinvoic->amount+=$item->quantity*$item->item->rate;
        $vinvoic->save();
        return redirect(route('vinvoices.add_items',$vinvoic));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $vinvoic
     * @return \Illuminate\Http\Response
     */
    public function edit(VInvoic $vinvoic)
    {

        return view('vendor.invoice.edit')->with('vinvoic',$vinvoic)
        ->with('items',VItem::all())
        ->with('companies',Company::all())
        ->with('clients',Vendor::all());
    }

    public function change_model(Request $request, VInvoice $vinvoic)
    {

        $form_data = array(
            'model_id'        =>  $request->model_id,
            );
        
        $vinvoic->update($form_data);

        return redirect(route('vinvoices.print',$vinvoic));

    }
    public function update(Request $request, VInvoic $vinvoic)
    {
        $vinvoic->update($request->except('_taken'));

        return redirect(route('vinvoices.add_items',$vinvoic));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sample_data  $vinvoic
     * @return \Illuminate\Http\Response
     */
    public function lock($id)
    {

        $vinvoic = VInvoic::findOrFail($id);
        $vinvoic->locked=1;
        $vinvoic->save();
    }
    public function destroy($id)
    {

        $vinvoic = VInvoic::findOrFail($id);
        $vinvoic->invoice_items()->delete();
        $vinvoic->delete();
    }
}

