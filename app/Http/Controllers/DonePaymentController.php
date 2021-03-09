<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DonePayment;
use App\Models\PaymentType;
use App\Models\VInvoic;
use App\Models\Bank;
use DataTables;
use Validator;


class DonePaymentController extends Controller
{
    
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = DonePayment::latest()->get();
            return DataTables::of($data)
                    ->addColumn('invoice', function($data){
                        $vinvoic=VInvoic::find($data->invoice_id);
                        return $vinvoic->vendor->name.'<br>'.$vinvoic->inv_number;
                    })
                    ->addColumn('remains', function($data){
                        $vinvoic=VInvoic::find($data->invoice_id);
                        $a=$vinvoic->amount;
                        $b=($data->amount_paid/$data->exchange_rate);
                        return $a-$b;
                    })
                    ->addColumn('action', function($data){
                        $button = '<a type="button" name="edit" title="edit" href="'.route('donepayments.edit',$data->id).'" class="edit btn btn-primary btn-xs"><i class="fas fa-edit"></i></a>';
                        $button .= '<button type="button" title="delete" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></button>';
                        if($data->rcpnt){
                            $button .= '<a type="button" title="receipt" href='.route('donepayments.receipt',$data->id).' class="btn btn-warning btn-xs"><i class="fas fa-file-pdf"></i></a>';
                        }
                        if($data->exchange_rate_file){
                            $button .= '<a type="button" title="exchange rate" href='.route('donepayments.exchange_rate',$data->id).' class="btn btn-success btn-xs"><i class="fas fa-file-pdf"></i></a>';
                        }
                        return $button;
                    })
                    ->rawColumns(['invoice','action','remains'])
                    ->make(true);
        }
        return view('donepayments.index')->with('invoices',VInvoic::all());
    }

    
    public function create(VInvoic $vinvoic)
    {
        return view('donepayments.create')
        ->with('vinvoic',$vinvoic)
        ->with('paymenttypes',PaymentType::all())
        ->with('banks',Bank::all());;
    }

    
    public function store(Request $request)
    {
        
        DonePayment::create($request->except('_token','rcpt_name','rcpnt'));

        $vinvoic=VInvoic::find($request->invoice_id);
        $vinvoic->received=$request->amount_paid;
        $vinvoic->save();
        if($request->file('rcpnt'))
        {
            $name = $request->file('rcpnt')->getClientOriginalName();
            $name=str_replace(' ', '-', $name);
            if($donepayment->bank->name.'-'.$vinvoice->company->name){
                $name=$donepayment->bank->name.'-'.$vinvoice->company->name;
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
        return redirect(route('donepayments.index'));

    }

    public function edit(DonePayment $donepayment)
    {
        return view('donepayments.edit')
        ->with('Donepayment',$donepayment)
        ->with('paymenttypes',PaymentType::all())
        ->with('banks',Bank::all());
    }

    public function update(Request $request, DonePayment $donepayment)
    {
        if($request->invoice_id){
            $invoice=VInvoic::findOrFail($request->invoice_id);
            $invoice->received-=($receivedpayment->amount_paid/$receivedpayment->exchange_rate);
            $invoice->received+=($request->amount_paid/$request->exchange_rate);
            $invoice->save();
        }
        
        $donepayment->update($request->except('_token','rcpt_name','rcpnt'));
        if($request->file('rcpnt'))
        {
            $name = $request->file('rcpnt')->getClientOriginalName();
            $name=str_replace(' ', '-', $name);
            if($donepayment->bank->name.'-'.$vinvoice->company->name){
                $name=$donepayment->bank->name.'-'.$vinvoice->company->name;
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
        return redirect(route('donepayments.edit',$donepayment));

    }

    public function destroy($id)
    {
        $data = DonePayment::findOrFail($id);
        $data->delete();
    }
    public function receipt($id){
        $donepayment=DonePayment::find($id);
        return response()->file('storage/'.$donepayment->rcpnt);
    }
    public function exchange_rate($id){
        $donepayment=DonePayment::find($id);
        return response()->file('storage/'.$donepayment->exchange_rate_file);
    }
}

