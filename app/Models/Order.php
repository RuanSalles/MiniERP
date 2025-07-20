<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'customer_id',
        'amount',
        'discount',
        'coupon_id',
        'status',
    ];
}
