<?php

namespace App\Console\Commands;

use App\Models\VInvoic as VInvoicModel;
use App\Models\VInvoicItem;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use DB;
class VInvoic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:vinvoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $vinvoics=VInvoicModel::where('recurring', '<>', 'none')->where('to_date',date('d-m-Y'))->get();
        // return count($vinvoics);
        $date=Carbon::now()->subDays(7)->format('d-m-Y');
        $inv_number='Inv'.$date[8].$date[9].$date[3].$date[4].$date[0].$date[1];
        $vdd='01';
        $n=DB::table('v_invoics')->select(DB::raw('lpad(substring(inv_number,10,2)+1,2,"0") as vdd'))->where(DB::raw('substring(inv_number,1,9)'),'=',$inv_number)->get();
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
        foreach($vinvoics as $vinvoic){
            if($vinvoic->recurring == 'monthly')
            {
                $r_vinvoic=VInvoicModel::create([
                    'model_id'=>$vinvoic->model_id,
                    'vendor_id'=>$vinvoic->vendor_id,
                    'company_id'=>$vinvoic->company_id,
                    'inv_number'=>$inv_number,
                    'Vinvoic_date'=>$date,
                    'from_date'=>$date,
                    'to_date'=>Carbon::now()->addDays(29)->format('d-m-Y'),
                    'type'=>$vinvoic->type,
                    'recurring'=>'monthly',
                    'howmany'=>$hwmny,
                ]);
                foreach($vinvoic->Vinvoic_items as $item){
                    if($vinvoic->amount == 0 || $vinvoic->received < $vinvoic->amount){
                        $r_inv_item=VInvoicItem::create([
                            'Vinvoic_id'=>$vinvoic->id,
                            'quantity'=>$item->quantity,
                            'item_id'=>$item->item_id
                        ]);
                        $item=Item::findOrFail($item->item_id);
                        $r_vinvoic->amount=$r_vinvoic->amount+$item->quantity*$item->rate;
                        $r_vinvoic->save();
                    }
                }
                

            }
            if($vinvoic->recurring == 'weekly')
            {
                $r_vinvoic=VInvoicModel::create([
                    'model_id'=>$vinvoic->model_id,
                    'vendor_id'=>$vinvoic->vendor_id,
                    'inv_number'=>$inv_number,
                    'company_id'=>$vinvoic->company_id,
                    'Vinvoic_date'=>$date,
                    'from_date'=>$date,
                    'to_date'=>Carbon::now()->addDays(6)->format('d-m-Y'),
                    'type'=>$vinvoic->type,
                    'recurring'=>'weekly',
                    'howmany'=> $hwmny,
                ]);
                foreach($vinvoic->Vinvoic_items as $item){
                    if($vinvoic->amount == 0 || $vinvoic->received < $vinvoic->amount){
                        $r_inv_item=VInvoicItem::create([
                            'Vinvoic_id'=>$vinvoic->id,
                            'quantity'=>$item->quantity,
                            'item_id'=>$item->item_id
                        ]);
                        $item=Item::findOrFail($item->item_id);
                        $r_vinvoic->amount=$r_vinvoic->amount+$item->quantity*$item->rate;
                        $r_vinvoic->save();
                    }
                }
            }

            $vinvoic->recurring='none';
            $vinvoic->save();
        }
        $this->info(count($vinvoics));
    }
}
