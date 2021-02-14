<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Company;
use App\Models\Client;
use App\Models\Item;
use App\Models\InvoiceItem;
use DataTables;
use Validator;
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
            $data = Invoice::latest()->get();
            return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<a type="button" target="_blank" name="print" href="'.route('invoices.print',$data->id).'" class="edit btn btn-success btn-xs"><i class="fas fa-file-pdf"></i></a>';
                        $button .= '<a type="button" name="edit" href="'.route('invoices.edit',$data->id).'" class="edit btn btn-primary btn-xs"><i class="fas fa-edit"></i></a>';
                        $button .= '<button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'company_id'    =>  'required',
            'client_id'     =>  'required',
            'invoice_date'     =>  'required',
            'from_date'     =>  'required',
            'to_date'     =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'company_id'        =>  $request->company_id,
            'client_id'         =>  $request->client_id,
            'invoice_date'         =>  $request->invoice_date,
            'from_date'         =>  $request->from_date,
            'to_date'         =>  $request->to_date,
            'model_id'         =>  0,
            'amount'         =>  0,
        );
        $invoice=Invoice::create($form_data);
        return redirect(route('invoices.add_items' ,$invoice));

    }
    public function print(Invoice $invoice){
        return view('client.invoice.print')->with('invoice',$invoice);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Sample_data  $invoice
     * @return \Illuminate\Http\Response
     */
    public function add_item(Invoice $invoice,Request $request)
    {
        return view('client.invoice.add_items')
        ->with('invoice',$invoice)
        ->with('clients',Client::all())
        ->with('items',Item::all())
        ->with('companies',Company::all());
    }
    public function store_item(Invoice $invoice,Item $item,Request $request)
    {
        InvoiceItem::create([
            'invoice_id'=>$invoice->id,
            'quantity'=>$request->quantity,
            'item_id'=>$request->item_id
        ]);
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
        return redirect(route('invoices.add_items',$invoice));
    }
    public function update_item(Invoice $invoice,InvoiceItem $item,Request $request)
    {
        $item->update([
            'invoice_id'=>$invoice->id,
            'quantity'=>$request->quantity,
            'item_id'=>$request->item_id
        ]);
        return redirect(route('invoices.add_items',$invoice));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {

        return view('client.invoice.edit')->with('invoice',$invoice)
        ->with('items',Item::all())
        ->with('companies',Company::all())
        ->with('clients',Client::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        // dd($request);
        $rules = array(
            'company_id'    =>  'required',
            'client_id'     =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'company_id'        =>  $request->company_id,
            'client_id'         =>  $request->client_id,
            'invoice_date'         =>  !is_null($request->invoice_date)?$request->invoice_date:$invoice->invoice_date,
            'from_date'         =>  !is_null($request->from_date)?$request->from_date:$invoice->from_date,
            'to_date'         =>  !is_null($request->to_date)?$request->to_date:$invoice->to_date,
        );

        $invoice->update($form_data);

        return redirect(route('invoices.add_items',$invoice));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sample_data  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $data = Invoice::findOrFail($id);
        $data->invoice_items()->delete();
        $data->delete();
    }
}

