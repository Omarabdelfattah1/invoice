<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VInvoicItem extends Model
{
    use HasFactory;
    protected $fillable=['v_invoic_id','v_item_id','quantity','price'];

    public function invoice(){
        return $this->belongsTo(VInvoic::class,'v_invoic_id');
    }
    public function item(){
        return $this->belongsTo(VItem::class,'v_item_id');
    }
}
