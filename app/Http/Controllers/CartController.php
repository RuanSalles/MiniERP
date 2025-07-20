<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariance;
use App\Models\Stock;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $products = Product::with(['variances', 'stock'])->paginate(9);

        return view('cart.index', compact('products'));
    }


    public function checkout()
    {
        return view('cart.checkout');
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variance_id' => 'required|exists:product_variances,id',
        ]);

        $stock = Stock::where('product_id', $request->product_id)->first();

        if (!$stock || $stock->quantity < $request->quantity) {
            return back()->withErrors('Quantidade solicitada não disponível em estoque.');
        }

        $product = Product::find($request->product_id);
        $variance = ProductVariance::find($request->variance_id);

        $cart = session()->get('cart', []);
        $cartItemKey = $product->id . '-' . $variance->id;

        if (!isset($cart[$cartItemKey])) {
            $cart[$cartItemKey] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'amount' => $product->amount,
                'variance' => [
                    'id' => $variance->id,
                    'color' => $variance->color,
                    'size' => $variance->size,
                    'isPrinted' => $variance->isPrinted,
                ],
                'quantity' => (int) $request->quantity
            ];
        } else {
            $cart[$cartItemKey]['quantity'] += $request->quantity;
            // opcional: limite máximo do estoque
            if ($cart[$cartItemKey]['quantity'] > $stock->quantity) {
                $cart[$cartItemKey]['quantity'] = $stock->quantity;
            }
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Produto adicionado ao carrinho!');
    }

    public function remove($index)
    {
        $cart = session('cart', []);

        if (isset($cart[$index])) {
            unset($cart[$index]);
            session(['cart' => array_values($cart)]); // reindexa o array
        }

        return redirect()->back()->with('success', 'Produto removido do carrinho.');
    }

}
