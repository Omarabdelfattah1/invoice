<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentType;
use DataTables;
use Validator;


class PaymentMethodController extends Controller
{
    
    public function index(Request $request)
    {
        
        return view('bank.payment_methods')
        ->with('paymenttypes',PaymentType::all());
    }

    public function create()
    {
        return view('bank.payment_methods')->with('paymenttypes',PaymentType::all());
    }

    public function store(Request $request)
    {
        
        PaymentType::create($request->except('_token'));

        return redirect(route('paymenttypes.index'));

    }

    public function edit(PaymentType $paymenttype)
    {

        return view('bank.payment_methods')
        ->with('paymenttypes',PaymentType::all())
        ->with('paymenttype',$paymenttype);
    }

    public function update(Request $request, PaymentType $paymenttype)
    {
        $paymenttype->update($request->except('_token'));

        return redirect(route('paymenttypes.edit',$paymenttype));

    }

    public function destroy($id)
    {
        $data = PaymentType::findOrFail($id);
        $data->delete();
    }
}

