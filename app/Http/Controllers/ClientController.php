<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\CModel;
use App\Models\ReceivedPayment;
use App\Models\Invoice;
use DataTables;
use Validator;
use PDF;

class ClientController extends Controller
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
            $data = Client::latest()->get();
            return DataTables::of($data)
                    ->addColumn('soa', function($data){
                        $button = '<a type="button" name="edit" href="'.route('clients.soa',$data->id).'" class="edit btn btn-link btn-xs">SOA</a>';
                        return $button;
                    })
                    ->addColumn('action', function($data){
                        $button = '<a type="button" name="edit" href="'.route('clients.edit',$data->id).'" class="edit btn btn-primary btn-xs"><i class="fas fa-edit"></i></a>';
                        $button .= '<button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></button>';
                        return $button;
                    })
                    ->rawColumns(['action','soa'])
                    ->make(true);
        }
        return view('client.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client.create')->with('models',CModel::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'unique:App\Models\Client,name'
        ]);
        Client::create($request->except('_taken'));

        return redirect(route('clients.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sample_data  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $Client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $Client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {

        return view('client.edit')->with('client',$client)->with('models',CModel::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $Client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {

        if($request->name != $client->name){
            $validated = $request->validate([
                'name' => 'unique:App\Models\Client,name'
            ]);
        }

        $client->update($request->except('_taken'));

        return redirect(route('clients.edit',$client));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sample_data  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Client::findOrFail($id);
        $data->delete();
    }
    
    public function soa($id){
        $invoices=Invoice::where('client_id',$id)->orderBy('STR_TO_DATE(invoice_date,"%d-%m-%Y")','asc')->get();
        $client=Client::find($id);
        $invoice=Invoice::where('client_id',$id)->first();
        $payments=ReceivedPayment::where('client_id',$id)->orderBy('STR_TO_DATE(payment_date,"%d-%m-%Y")','asc')->get();
        return view('client.soa')
        ->with('invoices',$invoices)
        ->with('client',$client)
        ->with('payments',$payments)
        ->with('company',$invoice->company);
    }
    public function download(Request $request){
        PDF::AddPage('L','A4');
        PDF::writeHTML($request->html,true,false,true,false,'');
        PDF::Output('invoice.pdf');
        // return $html_content;
        
    }
    
}

