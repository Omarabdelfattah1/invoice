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
        'v_invoic_id',
        'bank_id',
    ];
}
