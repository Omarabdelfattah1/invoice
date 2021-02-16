<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VInvoic;
use App\Models\Company;
use App\Models\Vendor;
use App\Models\VItem;
use App\Models\VInvoicItem;
use DataTables;
use Validator;
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
            $data = VInvoic::latest()->get();
            return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<a type="button" target="_blank" name="print" href="'.route('vinvoices.print',$data->id).'" class="edit btn btn-success btn-xs"><i class="fas fa-file-pdf"></i></a>';
                        $button .= '<a type="button" name="edit" href="'.route('vinvoices.edit',$data->id).'" class="edit btn btn-primary btn-xs"><i class="fas fa-edit"></i></a>';
                        $button .= '<button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></button>';
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
        
        $form_data = array(
            'company_id'        =>  $request->company_id,
            'vendor_id'         =>  $request->client_id,
            'invoice_date'         =>  $request->invoice_date,
            'inv_number'         => 'Inv'.$request->invoice_date[8].$request->invoice_date[9].$request->invoice_date[3].$request->invoice_date[4].$request->invoice_date[0].$request->invoice_date[1] ,
            'from_date'         =>  $request->from_date,
            'to_date'         =>  $request->to_date,
            'v_model_id'         =>  0,
            'amount'         =>  0,
        );
        $vinvoice=VInvoic::create($form_data);
        return redirect(route('vinvoices.add_items',$vinvoice));

    }
    public function print(VInvoic $vinvoice){
        return view('vendor.invoice.print')->with('vinvoice',$vinvoice);
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $vinvoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VInvoic $vinvoice)
    {

        $form_data = array(
            'company_id'        =>  $request->company_id,
            'vendor_id'         =>  $request->client_id,
            'invoice_date'         =>  !is_null($request->invoice_date)?$request->invoice_date:$vinvoice->invoice_date,
            'from_date'         =>  !is_null($request->from_date)?$request->from_date:$vinvoice->from_date,
            'to_date'         =>  !is_null($request->to_date)?$request->to_date:$vinvoice->to_date,
        );

        $vinvoice->update($form_data);

        return redirect(route('vinvoices.add_items',$vinvoice));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sample_data  $vinvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $data = VInvoic::findOrFail($id);
        $data->invoice_items()->delete();
        $data->delete();
    }
}

