<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\DonePayment;
use App\Models\VInvoic;
use App\Models\VModel;
use DataTables;
use Validator;
use DB;


class VendorController extends Controller
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
            $data = Vendor::latest()->get();
            return DataTables::of($data)
                    ->addColumn('soa', function($data){
                        $button = '<a type="button" name="edit" href="'.route('vendors.soa',$data->id).'" class="btn btn-link btn-xs">SOA</a>';
                        return $button;
                    })
                    ->addColumn('action', function($data){
                        $button = '<a type="button" name="edit" href="'.route('vendors.edit',$data->id).'" class="edit btn btn-primary btn-xs"><i class="fas fa-edit"></i></a>';
                        $button .= '<button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></button>';
                        return $button;
                    })
                    ->rawColumns(['action','soa'])
                    ->make(true);
        }
        return view('vendor.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vendor.create')->with('models',VModel::all());
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
            'name' => 'unique:App\Models\Vendor,name'
        ]);
        Vendor::create($request->except('_taken'));

        return redirect(route('vendors.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sample_data  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendor $vendor)
    {

        return view('vendor.edit')->with('Vendor',$vendor)->with('models',VModel::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendor $vendor)
    {
        if($request->name != $vendor->name){
            $validated = $request->validate([
                'name' => 'unique:App\Models\Vendor,name'
            ]);
        }
        $vendor->update($request->except('_taken'));

        return redirect(route('vendors.edit',$vendor));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sample_data  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Vendor::findOrFail($id);
        $data->delete();
    }
    public function soa($id){
        $invoices=VInvoic::where('vendor_id',$id)->orderBy(DB::raw('STR_TO_DATE(invoice_date,"%d-%m-%Y")'),'asc')->get();
        $vendor=Vendor::find($id);
        $invs=VInvoic::select('id')->where('vendor_id',$id)->get();
        $payments=DonePayment::whereIn('v_invoic_id',$invs)->orderBy(DB::raw('STR_TO_DATE(payment_date,"%d-%m-%Y")'),'asc')->get();
        return view('vendor.soa')
        ->with('invoices',$invoices)
        ->with('vendor',$vendor)
        ->with('payments',$payments);
    }
    public function download(Request $request){
        PDF::AddPage('L','A4');
        PDF::writeHTML($request->html,true,false,true,false,'');
        PDF::Output('invoice.pdf');
        // return $html_content;
        
    }
    
}

