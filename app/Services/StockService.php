<?php

namespace app\Services;

use App\Models\Stock;

class StockService
{
    public function debitStock($data): true|\Illuminate\Http\RedirectResponse
    {
        try {
            foreach ($data['products'] as $item) {
                $stock = Stock::where('product_id', $item['product_id'])->first();
                if ($stock['quantity'] >= $item['quantity']) {
                    $stock->decrement('quantity', $item['quantity']);
                } else {
                    return redirect()->route('orders.index')->with('error', 'Não temos produtos suficiente no sistema');
                }
            }
            return true;
        } catch (\Throwable $th) {
            return redirect()->route('orders.index')->with('error', 'Falha ao debitar produtos no estoque!');
        }
    }
}
