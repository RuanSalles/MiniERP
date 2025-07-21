<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%");
        }

        $products = $query->paginate(10);

        return view('product.index', compact('products'));
    }

    public function create()
    {
        return view('product.create');
    }

    public function store(ProductRequest $request)
    {
        try {
            $validated = $request->validated();
            $product = Product::create($validated);

            if ($request->post(
                'variances',
            )) {
                $this->productService->addProductVariance($request->all(), $product);
            }

            return redirect()->route('products.index')->with('success', 'Produto Criado com Sucesso!.');
        } catch (\Throwable $e) {
            \Log::error('Erro ao cadastrar cliente: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Ocorreu um erro ao salvar o produto.');
        }
    }

    public function edit(Product $product)
    {
        $product->load('variances');
        return view('product.create', compact('product'));
    }

    public function update(ProductRequest $request, Product $product)
    {

        $validated = $request->validated();
        $product->update($validated);

        // Limpa variações existentes
        $product->variances()->delete();
        if ($request->post(
            'variances',
        )) {
            $this->productService->addProductVariance($request->all(), $product);
        }

        return redirect()->route('products.index')->with('success', 'Produto Atualizado com Sucesso!.');
    }

    public function destroy(Product $product)
    {
        $product->variances()->delete(); // deleta as variações primeiro
        $product->stock()->delete();
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produto excluído com sucesso!');
    }

}
