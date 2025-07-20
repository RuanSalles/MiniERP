<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockRequest;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::with('product')->paginate(10);
        return view('stock.index', ['stocks' => $stocks]);

    }

    public function create()
    {
        $products = Product::all();
        return view('stock.create', ['products' => $products]);
    }

    public function store(StockRequest $request)
    {
        $validated = $request->validated();
        $stock = Stock::where('product_id', $validated['product_id'])->first();

        if ($stock) {
            // Atualiza a quantidade existente (por exemplo, soma a nova quantidade)
            $stock->quantity += $validated['quantity'];
            $stock->save();
        } else {
            // Cria novo registro de estoque
            Stock::create($validated);
        }

        return redirect()->route('stocks.index')->with('success', 'Estoque atualizado com sucesso!');
    }

    public function edit($id)
    {
        // Busca o estoque pelo ID ou falha com 404
        $stock = Stock::findOrFail($id);

        // Busca todos os produtos para popular o select no form
        $products = Product::all();

        // Retorna a view edit passando os dados
        return view('stock.create', ['products' => $products, 'stock' => $stock]);
    }

    public function update(StockRequest $request, $id)
    {
        $stock = Stock::findOrFail($id);
        $validated = $request->validated();
        $stock->update($validated);

        return redirect()->route('stocks.index')->with('success', 'Estoque atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();

        return redirect()->route('stocks.index')->with('success', 'Estoque excluído com sucesso!');
    }
}
