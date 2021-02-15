<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'update_date',
        'amount',
        'exchange_rate',
        'exchange_amount',
        'local_amount',
        'currency_id',
        'comment',
        'image',
    ];
}
