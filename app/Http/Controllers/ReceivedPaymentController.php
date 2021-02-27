<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReceivedPayment;
use App\Models\PaymentType;
use App\Models\Invoice;
use App\Models\Bank;
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
                        $invoice=Invoice::find($data->invoice_id);
                        return $invoice->client->name.'<br>'.$invoice->inv_number;
                    })
                    ->addColumn('action', function($data){
                        $button = '<a type="button" name="edit" href="'.route('receivedpayments.edit',$data->id).'" class="edit btn btn-primary btn-xs"><i class="fas fa-edit"></i></a>';
                        $button .= '<button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></button>';
                        return $button;
                    })
                    ->rawColumns(['invoice','action'])
                    ->make(true);
        }
        return view('receivedpayments.index')->with('invoices',Invoice::all());
    }

    
    public function create(Invoice $invoice)
    {
        return view('receivedpayments.create')
        ->with('invoice',$invoice)
        ->with('paymenttypes',PaymentType::all())
        ->with('banks',Bank::all());;
    }

    
    public function store(Request $request)
    {
        
        ReceivedPayment::create($request->except('_token'));
        $invoice=Invoice::find($request->invoice_id);
        $invoice->received=$request->amount_paid;
        $invoice->save();
        return redirect(route('receivedpayments.index'));

    }

    public function edit(ReceivedPayment $receivedpayment)
    {

        return view('receivedpayments.edit')
        ->with('receivedpayment',$receivedpayment)
        ->with('paymenttypes',PaymentType::all())
        ->with('banks',Bank::all());
    }

    public function update(Request $request, ReceivedPayment $receivedpayment)
    {
        $invoice=Invoice::findOrFail($request->invoice_id);
        $invoice->received-=$receivedpayment->amount_paid;
        $receivedpayment->update($request->except('_token'));

        $invoice->received+=$receivedpayment->amount_paid;
        $invoice->save();
        return redirect(route('receivedpayments.edit',$receivedpayment));

    }

    public function destroy($id)
    {
        $data = ReceivedPayment::findOrFail($id);
        $data->delete();
    }
}

