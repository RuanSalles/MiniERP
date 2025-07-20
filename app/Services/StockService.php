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
                    Stock::where('id', $item['product_id'])->update([
                        'quantity' => $quantity,
                    ]);
                }
            }
            return true;
        } catch (\Throwable $th) {
            return redirect()->route('orders.index')->with('error', 'Falha ao debitar produtos no estoque!');
        }
    }
}
