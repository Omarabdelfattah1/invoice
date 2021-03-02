<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\ReceivedPayment;
use PDF;
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
                    ->addColumn('soa', function($data){
                        $button = '<a type="button" name="edit" href="'.route('companies.soa',$data->id).'" class="edit btn btn-link btn-xs">SOA</a>';
                        return $button;
                    })
                    ->addColumn('action', function($data){
                        $button = '<a type="button" name="edit" href="'.route('companies.edit',$data->id).'" class="edit btn btn-primary btn-xs"><i class="fas fa-edit"></i></a>';
                        $button .= '<button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></button>';
                        return $button;
                    })
                    ->rawColumns(['action','soa'])
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
        $validated = $request->validate([
            'name' => 'unique:App\Models\Company,name'
        ]);
        Company::create($request->except('_taken'));

        return redirect(route('companies.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sample_data  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {

        return view('company.edit')->with('company',$company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
       
        $validated = $request->validate([
            'name' => 'unique:App\Models\Company,name'
        ]);
        $company->update($request->except('_taken'));

        return redirect(route('companies.edit',$company));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sample_data  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Company::findOrFail($id);
        $data->delete();
    }
    public function soa($id){
        $invoices=Invoice::where('company_id',$id)->get();
        $company=Company::find($id);
        $invs=Invoice::select('id')->where('company_id',$id)->get();
        $payments=ReceivedPayment::whereIn('invoice_id',$invs)->get();
        return view('company.soa')
        ->with('invoices',$invoices)
        ->with('company',$company)
        ->with('payments',$payments);
    }
    public function download(Request $request){
        PDF::AddPage('L','A4');
        PDF::writeHTML($request->html,true,false,true,false,'');
        PDF::Output('invoice.pdf');
        // return $html_content;
        
    }
}

