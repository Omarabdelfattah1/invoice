<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentType;
use DataTables;
use Validator;


class PaymentTypeController extends Controller
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
            $data = PaymentType::latest()->get();
            return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<a type="button" name="edit" href="'.route('paymenttypes.edit',$data->id).'" class="edit btn btn-primary btn-xs"><i class="fas fa-edit"></i></a>';
                        $button .= '<button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('bank.payment_methods');
    }

    public function store(Request $request)
    {

        PaymentType::create($request->name);

        return redirect(route('paymenttypes.index'));

    }

    public function edit(PaymentType $paymenttype)
    {

        return view('bank.payment_methods')->with('paymenttype',$paymenttype);
    }

    public function update(Request $request, PaymentType $paymenttype)
    {
        $paymenttype->update($request->name);

        return redirect(route('paymenttypes.edit',$paymenttype));

    }

    public function destroy($id)
    {
        $data = PaymentType::findOrFail($id);
        $data->delete();
    }
}

