<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    protected $fillable = [
        'customer_id',
        'order_id',
        'products',
        'status',
    ];

    protected $casts = [
        'products' => 'array', // converte JSON em array automaticamente
    ];

    // Um carrinho pertence a um cliente
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    // Um carrinho pertence a um pedido
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
