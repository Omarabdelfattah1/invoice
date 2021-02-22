<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VInvoic extends Model
{
    use HasFactory;
    protected $fillable=[
        'amount',
        'inv_number',
        'v_model_id',
        'invoice_date',
        'from_date',
        'to_date',
        'vendor_id',
        'company_id',
        'type',
    ];
    
    public function invoice_items(){
        return $this->hasMany(VInvoicItem::class);
    }
    public function vendor(){
        return $this->belongsTo(Vendor::class,'vendor_id');
    }
    
    public function company(){
        return $this->belongsTo(Company::class,'company_id');
    }
}
