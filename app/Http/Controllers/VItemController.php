<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VItem;
use DataTables;
use Validator;


class VItemController extends Controller
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
            $data = VItem::latest()->get();
            return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<a type="button" name="edit" href="'.route('vitems.edit',$data->id).'" class="edit btn btn-primary btn-xs"><i class="fas fa-edit"></i></a>';
                        $button .= '<button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('vendor.items.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vendor.items.create');
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
            'description'     =>  'required',
        );


        $form_data = array(
            'name'        =>  $request->name,
            'description'         =>  $request->description,
            'rate'         =>  $request->rate,
        );

        VItem::create($form_data);

        return redirect(route('vitems.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sample_data  $vitem
     * @return \Illuminate\Http\Response
     */
    public function show(VItem $vitem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VItem  $vitem
     * @return \Illuminate\Http\Response
     */
    public function edit(VItem $vitem)
    {

        return view('vendor.items.edit')->with('VItem',$vitem);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VItem  $vitem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VItem $vitem)
    {
        $rules = array(
            'name'    =>  'required',
            'description'     =>  'required'
        );


        $form_data = array(
            'name'        =>  $request->name,
            'description'         =>  $request->description,
            'rate'         =>  $request->rate,
        );

        $vitem->update($form_data);

        return redirect(route('vitems.edit',$vitem));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sample_data  $vitem
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = VItem::findOrFail($id);
        $data->delete();
    }
}

