<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use DataTables;
use Validator;


class CompanyController extends Controller
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
            $data = Company::latest()->get();
            return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<a type="button" name="edit" href="'.route('companies.edit',$data->id).'" class="edit btn btn-primary btn-xs"><i class="fas fa-edit"></i></a>';
                        $button .= '<button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('company.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company.create');
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
            'country'     =>  'required',
            'address'     =>  'required',
            'tel'     =>  'required',
            'email'     =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'name'        =>  $request->name,
            'country'         =>  $request->country,
            'address'         =>  $request->address,
            'email'         =>  $request->email,
            'tel'         =>  $request->tel,
        );

        Company::create($form_data);

        return redirect(route('Companys.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sample_data  $Company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $Company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $Company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $Company)
    {

        return view('company.edit')->with('Company',$Company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $Company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $Company)
    {
        $rules = array(
            'name'    =>  'required',
            'country'     =>  'required',
            'address'     =>  'required',
            'tel'     =>  'required',
            'email'     =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'name'        =>  $request->name,
            'country'         =>  $request->country,
            'address'         =>  $request->address,
            'email'         =>  $request->email,
            'tel'         =>  $request->tel,
        );

        $Company->update($form_data);

        return redirect(route('Companys.edit',$Company));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sample_data  $Company
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Company::findOrFail($id);
        $data->delete();
    }
}

