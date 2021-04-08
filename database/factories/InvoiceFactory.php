<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Client;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use DB;
class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $rec=['weekly','monthly','none'];
        $rec_index=array_rand($rec,1);
        $type=['week','month'];
        $t_index=array_rand($type,1);
        $client=Client::inRandomOrder()->first();
        $company=Company::inRandomOrder()->first();
        $date=Carbon::now()->subDays(7)->format('d-m-Y');
        $inv_number='Inv'.$date[8].$date[9].$date[3].$date[4].$date[0].$date[1];
        $vdd='01';
        $n=DB::table('invoices')->select(DB::raw('lpad(substring(inv_number,10,2)+1,2,"0") as vdd'))->where(DB::raw('substring(inv_number,1,9)'),'=',$inv_number)->get();
        $m=count($n)+1;
        if($m>0){
            if  ($m>=9)
            {
                $vdd=$m;
            }else{
                $vdd='0'.$m;
            }
        }
        
        $inv_number=$inv_number.$vdd;
        return [
            'client_id'=>$client->id,
            'model_id'=>0,
            'company_id'=>$company->id,
            'inv_number'=>$inv_number,
            'type'=>$type[$t_index],
            'invoice_date'=>Carbon::now()->subDays(7)->format('d-m-Y'),
            'from_date'=>Carbon::now()->subDays(7)->format('d-m-Y'),
            'to_date'=>Carbon::now()->format('d-m-Y'),
            'recurring'=>$rec[$rec_index],
        ];
    }
}
