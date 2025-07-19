<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address_id',
    ];

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

}
