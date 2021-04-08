<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReceivedPayment;
use App\Models\PaymentType;
use App\Models\Invoice;
use App\Models\Bank;
use App\Models\Client;
use DataTables;
use Validator;


class ReceivedPaymentController extends Controller
{
    
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = ReceivedPayment::latest()->get();
            return DataTables::of($data)
                    ->addColumn('invoice', function($data){
                        $i='';
                        $c='';
                        if($data->invoice_id){
                            $invoice=Invoice::find($data->invoice_id);
                            $i=$invoice->inv_number;
                        }
                        if($data->client_id){
                            $client=Client::find($data->client_id);
                            $c=$client->name;
                        }
                        return $i.'<br>'.$c;
                    })
                    ->addColumn('remains', function($data){
                        if($data->invoice_id){
                            $invoice=Invoice::find($data->invoice_id);
                            $a=$invoice->amount-$invoice->received;
                            return number_format($a,2);
                        }else{
                            return '';
                        }
                        
                    })
                    ->addColumn('action', function($data){
                        $button = '<a type="button" name="edit" title="edit" href="'.route('receivedpayments.edit',$data->id).'" class="edit btn btn-primary btn-xs"><i class="fas fa-edit"></i></a>';
                        $button .= '<button type="button" title="delete" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></button>';
                        if($data->rcpnt){
                            $button .= '<a type="button" title="receipt" href='.route('receivedpayments.receipt',$data->id).' class="btn btn-warning btn-xs"><i class="fas fa-file-pdf"></i></a>';
                        }
                        if($data->exchange_rate_file){
                            $button .= '<a type="button" title="exchange rate" href='.route('receivedpayments.exchange_rate',$data->id).' class="btn btn-success btn-xs"><i class="fas fa-file-pdf"></i></a>';
                        }
                        return $button;
                    })
                    ->rawColumns(['invoice','action','remains'])
                    ->make(true);
        }
        return view('receivedpayments.index')->with('invoices',Invoice::all());
    }

    public function create()
    {
        return view('receivedpayments.create')
        ->with('paymenttypes',PaymentType::all())
        ->with('clients',Client::all())
        ->with('banks',Bank::all());;
    }
    
    public function store(Request $request)
    {
        // dd($request->all());
        $name='';
        $ext='';
        $receivedpayment=ReceivedPayment::create($request->except('_token','exchange_rate_file','rcpt_name','rcpnt'));
        
        if($request->invoice_id){
            $invoice=Invoice::find($request->invoice_id);
            $invoice->received+=$request->amount_paid/$request->exchange_rate;

            $invoice->save();
        }
        if($request->file('rcpnt'))
        {
            $name = $request->file('rcpnt')->getClientOriginalName();
            $name=str_replace(' ', '-', $name);
            if($request->invoice_id){
                $name=$receivedpayment->bank->name.'-'.$invoice->client->name;
            }
            $ext=$request->file('rcpnt')->extension();
            $rcpnt=$request->file('rcpnt')->storeAs('public/receipt',$name);
            $receivedpayment->rcpnt='receipt/'.$name;
            $receivedpayment->save();

        }
        if($request->file('exchange_rate_file'))
        {
            $name = $request->file('exchange_rate_file')->getClientOriginalName();
            $name=str_replace(' ', '-', $name);
            if($request->invoice_id){
                $name='exrate_'.$receivedpayment->bank->name.'-'.$invoice->client->name;
            }
            $ext=$request->file('exchange_rate_file')->extension();
            $rcpnt=$request->file('exchange_rate_file')->storeAs('public/exchange_rates',$name);
            $receivedpayment->exchange_rate_file='exchange_rates/'.$name;
            $receivedpayment->save();

        }
        return redirect(route('receivedpayments.index'));

    }

    public function edit(ReceivedPayment $receivedpayment)
    {

        return view('receivedpayments.edit')
        ->with('receivedpayment',$receivedpayment)
        ->with('paymenttypes',PaymentType::all())
        ->with('clients',Client::all())
        ->with('banks',Bank::all());
    }

    public function update(Request $request, ReceivedPayment $receivedpayment)
    {
        $invoice;
        if($request->invoice_id){
            $invoice=Invoice::findOrFail($receivedpayment->invoice_id);
            $invoice->received-=($receivedpayment->amount_paid/$receivedpayment->exchange_rate);
            $invoice->received+=($request->amount_paid/$request->exchange_rate);
            $invoice->save();
        }
        
        $receivedpayment->update($request->except('_token','rcpt_name','rcpnt'));
        if($request->file('rcpnt'))
        {
            $name = $request->file('rcpnt')->getClientOriginalName();
            $name=str_replace(' ', '-', $name);
            if($request->invoice_id){
                $name=$receivedpayment->bank->name.'-'.$invoice->client->name;
            }
            $ext=$request->file('rcpnt')->extension();
            $rcpnt=$request->file('rcpnt')->storeAs('public/receipt',$name);
            $r_p->rcpnt='receipt/'.$name;
            $r_p->save();

        }
        
        if($request->file('exchange_rate_file'))
        {
            $name = $request->file('exchange_rate_file')->getClientOriginalName();
            $name=str_replace(' ', '-', $name);
            if($receivedpayment->bank->name.'-'.$invoice->client->name){
                $name='exrate_'.$receivedpayment->bank->name.'-'.$invoice->client->name;
            }
            $ext=$request->file('exchange_rate_file')->extension();
            $rcpnt=$request->file('exchange_rate_file')->storeAs('public/exchange_rates',$name);
            $receivedpayment->exchange_rate_file='exchange_rates/'.$name;
            $receivedpayment->save();

        }
        return redirect(route('receivedpayments.index'));

    }

    public function destroy($id)
    {
        $data = ReceivedPayment::findOrFail($id);
        $data->delete();
    }

    public function receipt( $id){
        $receivedpayment=ReceivedPayment::find($id);
        return response()->file('storage/'.$receivedpayment->rcpnt);
    }
    public function exchange_rate( $id){
        $receivedpayment=ReceivedPayment::find($id);
        return response()->file('storage/'.$receivedpayment->exchange_rate_file);
    }
}

