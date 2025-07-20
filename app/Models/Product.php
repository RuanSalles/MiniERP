<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

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

    public function stock()
    {
        return $this->hasOne(Stock::class);
    }


}
