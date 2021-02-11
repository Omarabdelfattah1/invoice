<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable=['amount','model_id','invoice_date','from_date','to_date','client_id','company_id'];
    protected $dates = ['invoice_date','from_date','to_date'];
    public function invoice_items(){
        return $this->hasMany(InvoiceItem::class);
    }
    public function client(){
        return $this->belongsTo(Client::class);
    }
    
    public function company(){
        return $this->belongsTo(Company::class);
    }
}
