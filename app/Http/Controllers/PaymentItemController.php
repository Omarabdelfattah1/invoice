<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentItem;
use DataTables;
use Validator;


class PaymentItemController extends Controller
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
            $data = PaymentItem::latest()->get();
            return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<a type="button" name="edit" href="'.route('pitems.edit',$data->id).'" class="edit btn btn-primary btn-xs"><i class="fas fa-edit"></i></a>';
                        $button .= '<button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('payment.pitem.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('payment.pitem.create');
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

        PaymentItem::create($form_data);

        return redirect(route('pitems.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sample_data  $pitem
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentItem $pitem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PaymentItem  $pitem
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentItem $pitem)
    {

        return view('payment.pitem.edit')->with('pitem',$pitem);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaymentItem  $pitem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentItem $pitem)
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

        $pitem->update($form_data);

        return redirect(route('pitems.edit',$pitem));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sample_data  $pitem
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = PaymentItem::findOrFail($id);
        $data->delete();
    }
}

