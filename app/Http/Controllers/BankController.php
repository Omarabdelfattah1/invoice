<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\Currency;
use DataTables;
use Validator;


class BankController extends Controller
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
            $data = Bank::latest()->get();
            return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<a type="button" name="edit" href="'.route('banks.edit',$data->id).'" class="edit btn btn-primary btn-xs"><i class="fas fa-edit"></i></a>';
                        $button .= '<button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('bank.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bank.create')->with('currencies',Currency::all());
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Bank::create($request->except('_token'));

        return redirect(route('banks.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sample_data  $bank
     * @return \Illuminate\Http\Response
     */
    public function show(Bank $bank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {

        return view('bank.edit')
        ->with('currencies',Currency::all())
        ->with('bank',$bank);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bank $bank)
    {
       
        $bank->update($request->except('_token'));

        return redirect(route('banks.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sample_data  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Bank::findOrFail($id);
        $data->delete();
    }



#===============================================================
    public function index_currency()
    {
        return view('bank.curr')->with('currencies',Currency::all());
    }
    public function store_currency(Request $request)
    {
        Currency::create(['ref'=>$request->ref]);
        return redirect(route('currencies.index'));
    }
    public function edit_currency(Currency $currency)
    {
        return view('currencies.index')->with('currency',$currency);
    }
    public function update_currency(Request $reauest)
    {
        Currency::create(['ref'=>$request->ref]);
        return redirect(route('currencies.index'));
    }
    public function delete_currency(Currency $currency)
    {
        $currency->delete();
        return redirect(route('currencies.index'));
    }

}

