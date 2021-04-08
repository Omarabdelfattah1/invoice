<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Item;
use App\Models\InvoiceItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceItemsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Model::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $invoice= Invoice::inRandomOrder()->first();
        $item=Item::inRandomOrder()->first();
        $q=rand(1,500);
        if($invoice->amount == 0 || $invoice->received < $invoice->amount){
            InvoiceItem::create([
                'invoice_id'=>$invoice->id,
                'quantity'=>$q,
                'item_id'=>$item->id
            ]);
            $invoice->amount=$invoice->amount+$q*$item->rate;
            $invoice->save();
        }
        return [
            
        ];
    }
}
