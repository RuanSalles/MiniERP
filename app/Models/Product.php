<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'amount',
        'code',
        'description',
    ];

    public function variances()
    {
        return $this->hasMany(ProductVariance::class);
    }

}
