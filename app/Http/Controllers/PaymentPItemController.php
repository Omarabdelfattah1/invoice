<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentP;
use App\Models\Client;
use App\Models\Bank;
use App\Models\Item;
use DataTables;
use Validator;


class PaymentPItemController extends Controller
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
            $data = PaymentP::latest()->get();
            return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<a type="button" name="edit" href="'.route('payment_p.edit',$data->id).'" class="edit btn btn-primary btn-xs"><i class="fas fa-edit"></i></a>';
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
        ->with('items',Item::all());
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
            'name'    =>  'required',
            'description'     =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'name'        =>  $request->name,
            'description'         =>  $request->description
        );

        PaymentP::create($form_data);

        return redirect(route('payment_p.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sample_data  $payment_p
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentP $payment_p)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PaymentP  $payment_p
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentP $payment_p)
    {

        return view('payment.receive.edit')->with('payment_p',$payment_p);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaymentP  $payment_p
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentP $payment_p)
    {
        $rules = array(
            'name'    =>  'required',
            'description'     =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'name'        =>  $request->name,
            'description'         =>  $request->description
        );

        $payment_p->update($form_data);

        return redirect(route('payment_p.edit',$payment_p));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sample_data  $payment_p
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = PaymentP::findOrFail($id);
        $data->delete();
    }
}

