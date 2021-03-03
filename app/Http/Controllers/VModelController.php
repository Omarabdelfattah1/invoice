<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VModel;
use App\Models\Invoice;
use DataTables;
use Validator;
use DB;

class VModelController extends Controller
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
            $data = VModel::latest()->get();
            return DataTables::of($data)
                    ->addColumn('default', function($data){
                        $button='';
                        if(!$data->default==1){
                            $button = '<a type="button" name="edit" href="'.route('vmodels.set_default').'" class="edit btn btn-primary btn-xs">Make Default</a>';
                        }
                        return $button;
                    })
                    ->addColumn('action', function($data){
                        $button = '<a type="button" name="edit" href="'.route('vmodels.edit',$data->id).'" class="edit btn btn-primary btn-xs"><i class="fas fa-edit"></i></a>';
                        $button .= '<button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></button>';
                        return $button;
                    })
                    ->rawColumns(['action','default'])
                    ->make(true);
        }
        return view('vendor.models.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vendor.models.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->except("_token"));
        VModel::create($request->except("_token"));

        return redirect(route('vmodels.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sample_data  $vmodel
     * @return \Illuminate\Http\Response
     */
    public function show(VModel $vmodel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model  $vmodel
     * @return \Illuminate\Http\Response
     */
    public function edit(VModel $vmodel)
    {
        // dd($vmodel);
        return view('vendor.models.edit')->with('vmodel',$vmodel);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model  $vmodel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VModel $vmodel)
    {
        // dd($request->all());
        $vmodel->update($request->except("_token"));

        return redirect(route('vmodels.edit',$vmodel));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sample_data  $vmodel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoices=VInvoice::where('model_id','=',$id)->get();
        foreach($invoices as $invoice){
            $invoice->model_id=0;
            $invoice->save();
        }
        $data = VModel::findOrFail($id);
        $data->delete();
    }
    public function set_default($id){
        DB::table('v_models')->where('default', '=', 1)->update(array('default' => 0));
        $model=VModel::findOrFail($id);
        $model->default=1;
        $model->save();
        return redirect(route('vmodels.index'));

    }
}

