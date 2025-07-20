<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $table = 'coupons';
    protected $casts = [
        'expires_at' => 'datetime',
    ];

    protected $fillable = [
        'name',
        'code',
        'type',
        'value',
        'expires_at'
    ];


}
