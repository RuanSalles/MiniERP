<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address_id',
    ];

    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }
}
