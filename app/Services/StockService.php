<?php

namespace app\Services;

use App\Models\Stock;

class StockService
{
    public function debitStock($data): true|\Illuminate\Http\RedirectResponse
    {
        try {
            foreach ($data['products'] as $item) {
                foreach ($data['order']['quantities'] as $quantity) {
                    $stock = Stock::where('product_id', $item['product_id'])->first();
                    if($stock['quantity'] >= $quantity) {
                        $stock->decrement('quantity', $quantity);
                    } else {
                        return redirect()->route('orders.index')->with('error', 'Não temos produtos suficiente no sistema');
                    }
                }
            }
            return true;
        } catch (\Throwable $th) {
            return redirect()->route('orders.index')->with('error', 'Falha ao debitar produtos no estoque!');
        }
    }
}
