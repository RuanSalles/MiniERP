@extends('layout.layout')

@section('container')
    <div class="container py-4">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($products as $product)
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->description }}</p>
                            <p><strong>Código:</strong> {{ $product->code }}</p>
                            <p><strong>Preço:</strong> R$ {{ number_format($product->amount, 2, ',', '.') }}</p>
                            <p><strong>Estoque disponível:</strong> {{ $product->stock->quantity ?? 0 }}</p>

                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <select name="variance_id" class="form-select mb-2" required>
                                    <option value="" disabled selected>Selecione a variação</option>
                                    @foreach($product->variances as $variance)
                                        <option value="{{ $variance->id }}">
                                            {{ $variance->color }} - {{ $variance->size }}
                                            @if($variance->isPrinted) (Estampado) @endif
                                        </option>
                                    @endforeach
                                </select>

                                <button type="submit" class="btn btn-success w-100">Adicionar ao Carrinho</button>
                            </form>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>


@endsection
