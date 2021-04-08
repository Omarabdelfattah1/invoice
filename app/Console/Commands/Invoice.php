<?php

namespace App\Console\Commands;
use App\Models\Invoice as InvoiceModel;
use App\Models\InvoiceItem;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use DB;
class Invoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:invoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Invoice recurring';

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
        $invoices=InvoiceModel::where('recurring', '<>', 'none')->where('to_date',date('d-m-Y'))->get();
        // return count($invoices);
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
        foreach($invoices as $invoice){
            if($invoice->recurring == 'monthly')
            {
                $r_invoice=InvoiceModel::create([
                    'model_id'=>$invoice->model_id,
                    'client_id'=>$invoice->client_id,
                    'company_id'=>$invoice->company_id,
                    'inv_number'=>$inv_number,
                    'invoice_date'=>$date,
                    'from_date'=>$date,
                    'to_date'=>Carbon::now()->addDays(29)->format('d-m-Y'),
                    'type'=>$invoice->type,
                    'recurring'=>'monthly',
                    'howmany'=>$hwmny,
                ]);
                foreach($invoice->invoice_items as $item){
                    if($invoice->amount == 0 || $invoice->received < $invoice->amount){
                        $r_inv_item=InvoiceItem::create([
                            'invoice_id'=>$invoice->id,
                            'quantity'=>$item->quantity,
                            'item_id'=>$item->item_id
                        ]);
                        $item=Item::findOrFail($item->item_id);
                        $r_invoice->amount=$r_invoice->amount+$item->quantity*$item->rate;
                        $r_invoice->save();
                    }
                }
                

            }
            if($invoice->recurring == 'weekly')
            {
                $r_invoice=InvoiceModel::create([
                    'model_id'=>$invoice->model_id,
                    'client_id'=>$invoice->client_id,
                    'inv_number'=>$inv_number,
                    'company_id'=>$invoice->company_id,
                    'invoice_date'=>$date,
                    'from_date'=>$date,
                    'to_date'=>Carbon::now()->addDays(6)->format('d-m-Y'),
                    'type'=>$invoice->type,
                    'recurring'=>'weekly',
                    'howmany'=> $hwmny,
                ]);
                foreach($invoice->invoice_items as $item){
                    if($invoice->amount == 0 || $invoice->received < $invoice->amount){
                        $r_inv_item=InvoiceItem::create([
                            'invoice_id'=>$invoice->id,
                            'quantity'=>$item->quantity,
                            'item_id'=>$item->item_id
                        ]);
                        $item=Item::findOrFail($item->item_id);
                        $r_invoice->amount=$r_invoice->amount+$item->quantity*$item->rate;
                        $r_invoice->save();
                    }
                }
            }

            $invoice->recurring='none';
            $invoice->save();
        }
        $this->info(count($invoices));
    }
}
