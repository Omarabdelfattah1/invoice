<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CModel;
use App\Models\Invoice;
use DataTables;
use Validator;
use DB;

class CModelController extends Controller
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
            $data = CModel::latest()->get();
            return DataTables::of($data)
                    ->addColumn('default', function($data){
                        $button='';
                        if(!$data->default==1){
                            $button = '<a type="button" name="edit" href="'.route('cmodels.set_default',$data->id).'" class="edit btn btn-primary btn-xs">Make Default</a>';
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
        return view('client.models.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client.models.create');
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
        CModel::create($request->except("_token"));

        return redirect(route('cmodels.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sample_data  $cmodel
     * @return \Illuminate\Http\Response
     */
    public function show(CModel $cmodel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model  $cmodel
     * @return \Illuminate\Http\Response
     */
    public function edit(CModel $cmodel)
    {
        // dd($cmodel);
        return view('client.models.edit')->with('cmodel',$cmodel);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model  $cmodel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CModel $cmodel)
    {
        // dd($request->all());
        $cmodel->update($request->except("_token"));

        return redirect(route('cmodels.edit',$cmodel));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sample_data  $cmodel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoices=Invoice::where('model_id','=',$id)->get();
        foreach($invoices as $invoice){
            $invoice->model_id=0;
            $invoice->save();
        }
        $data = CModel::findOrFail($id);
        $data->delete();
    }
    public function set_default($id){
        // dd($id);
        DB::table('c_models')->where('default', '=', 1)->update(array('default' => 0));
        $model=CModel::findOrFail($id);
        $model->default=1;
        $model->save();
        return redirect(route('cmodels.index'));

    }
}

