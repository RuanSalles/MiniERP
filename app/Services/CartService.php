<?php

namespace app\Services;

use App\Models\Cart;

class CartService
{
    /**
     * @throws \Throwable
     */
    public function vinculateCart($data): true|\Illuminate\Http\RedirectResponse
    {
        try {
            Cart::create([
                'customer_id' => session('selected_customer_id'),
                'order_id'   => $data['order_id'],
                'products'   => $data['products'],
                'status'     => 'pending',
            ]);

            return true;
        } catch (\Throwable $th) {
            return redirect()->route('orders.index')->with('error', 'Falha ao vincular carrinho!');
        }
    }
}
