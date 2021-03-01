<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonePayment extends Model
{
    use HasFactory;
    protected $fillable=[
        'notes',
        'payment_type',
        'payment_date',
        'amount_paid',
        'invoice_id',
        'bank_id',
        'paid_by',
        'shipping_address',
        'transction_id',
        'details',
        'rcpnt',
        'exchange_rate',
        'exchange_rate_file',
    ];
    public function invoice(){
        return $this->belongsTo(VInvoice::class);
    }
    public function bank(){
        return $this->belongsTo(Bank::class);
    }
}
