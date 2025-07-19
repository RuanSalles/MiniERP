<?php

namespace app\Services;

use App\Models\Product;
use App\Models\ProductVariance;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function addProductVariance($payload, Product $product)
    {
        try {
            DB::beginTransaction();

            foreach ($payload['variations'] as $variation) {
                $product->variances()->create($variation);
            }

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();

            // Opcional: log do erro
            \Log::error('Erro ao vincular variação: ' . $e->getMessage());

            throw $e;
        }
    }
}
