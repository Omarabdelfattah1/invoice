<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentR;
use App\Models\Client;
use App\Models\Bank;
use App\Models\ReceiveItem;
use DataTables;
use Validator;


class PaymentRItemController extends Controller
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
            $data = PaymentR::latest()->get();
            return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<a type="button" name="edit" href="'.route('payment_rs.edit',$data->id).'" class="edit btn btn-primary btn-xs"><i class="fas fa-edit"></i></a>';
                        $button .= '<button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('payment.receive.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('payment.receive.create')
        ->with('clients',Client::all())
        ->with('banks',Bank::all())
        ->with('items',ReceiveItem::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        PaymentR::create($request->except("_token"));

        return redirect(route('payment_rs.index'));

    }

   
    public function edit(PaymentR $payment_r)
    {

        return view('payment.receive.edit')
        ->with('clients',Client::all())
        ->with('banks',Bank::all())
        ->with('items',ReceiveItem::all())
                ->with('payment_r',$payment_r);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaymentR  $payment_r
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentR $payment_r)
    {

        $payment_r->update($request->except("_token"));

        return redirect(route('payment_rs.edit',$payment_r));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sample_data  $payment_r
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = PaymentR::findOrFail($id);
        $data->delete();
    }
}

