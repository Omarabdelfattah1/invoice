<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReceiveItem;
use DataTables;
use Validator;


class ReceiveItemController extends Controller
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
            $data = ReceiveItem::latest()->get();
            return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<a type="button" name="edit" href="'.route('receive_items.edit',$data->id).'" class="edit btn btn-primary btn-xs"><i class="fas fa-edit"></i></a>';
                        $button .= '<button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('payment.ritem.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('payment.ritem.create');
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

        ReceiveItem::create($form_data);

        return redirect(route('receive_items.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sample_data  $ritem
     * @return \Illuminate\Http\Response
     */
    public function show(ReceiveItem $ritem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReceiveItem  $ritem
     * @return \Illuminate\Http\Response
     */
    public function edit(ReceiveItem $ritem)
    {

        return view('payment.ritem.edit')->with('ritem',$ritem);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReceiveItem  $ritem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReceiveItem $ritem)
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

        $ritem->update($form_data);

        return redirect(route('receive_items.edit',$ritem));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sample_data  $ritem
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = ReceiveItem::findOrFail($id);
        $data->delete();
    }
}

