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
            'vendor_id'         =>  $request->client_id,
            'invoice_date'         =>  $request->invoice_date,
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
    // public function print(VInvoic $vinvoice){
    //     $client = new Party([
    //         'name'          => $vinvoice->client->name,
    //         'phone'         => $vinvoice->client->phone
    //     ]);

    //     $customer = new Party([
    //         'name'          => $vinvoice->company->name,
    //         'address'       => $vinvoice->company->address
    //     ]);

    //     $items = [];
    //     foreach($vinvoice->invoice_items as $item)
    //     {
    //         array_push($items ,(new PInvoiceItem())
    //         ->title($item->item->name)
    //         ->pricePerUnit($item->item->rate)
    //         ->quantity($item->quantity));
    //     }
    //     $notes = [
    //         'your multiline',
    //         'additional notes',
    //         'in regards of delivery or something else',
    //     ];
    //     $notes = implode("<br>", $notes);

    //     $pinvoice = PVInvoic::make('receipt')
    //         ->series('BIG')
    //         ->sequence(667)
    //         ->seller($client)
    //         ->buyer($customer)
    //         ->date(now()->subWeeks(3))
    //         ->dateFormat('m/d/Y')
    //         ->payUntilDays(14)
    //         ->currencySymbol('$')
    //         ->currencyCode('USD')
    //         ->currencyFormat(1.1)
    //         ->currencyThousandsSeparator('.')
    //         ->currencyDecimalPoint(',')
    //         ->filename($client->name . ' ' . $customer->name)
    //         ->addItems($items)
    //         ->notes($notes)
    //         ->logo(public_path('/imgs/logo1.png'))
    //         // You can additionally save generated invoice to configured disk
    //         ->save('public');

    //     $link = $pinvoice->url();
    //     // Then send email to party with link

    //     // And return invoice itself to browser or have a different view
    //     return $pinvoice->stream();

    // }
    /**
     * Display the specified resource.
     *
     * @param  \App\Sample_data  $vinvoice
     * @return \Illuminate\Http\Response
     */
    public function add_item(VInvoic $vinvoice,Request $request)
    {
        return view('vendor.invoice.add_items')
        ->with('vinvoice',$vinvoice)
        ->with('items',VItem::all())
        ->with('companies',Company::all())
        ->with('clients',Vendor::all());;
    }
    public function store_item(VInvoic $vinvoice,VItem $item,Request $request)
    {
        VInvoicItem::create([
            'v_invoic_id'=>$vinvoice->id,
            'quantity'=>$request->quantity,
            'price'=>$request->price,
            'v_item_id'=>$request->item_id
        ]);
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
        return redirect(route('vinvoices.add_items',$vinvoice));
    }
    public function update_item(VInvoic $vinvoice,VInvoicItem $item,Request $request)
    {
        $item->update([
            'v_invoic_id'=>$vinvoice->id,
            'quantity'=>$request->quantity,
            'price'=>$request->price,
            'v_item_id'=>$request->item_id
        ]);
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

