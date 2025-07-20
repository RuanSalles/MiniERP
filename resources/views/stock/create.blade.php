@extends('layout.layout')
@section('container')
    <form method="POST" action="{{ isset($stock) ? route('stocks.update', $stock->id) : route('stocks.store') }}">
        @csrf
        @if(isset($stock))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="product_id" class="form-label">Produto</label>
            <select id="product_id" name="product_id" class="form-select" required>
                <option value="">Selecione um produto</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}"
                        {{ (old('product_id') == $product->id || (isset($stock) && $stock->product_id == $product->id)) ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Quantidade</label>
            <input
                type="number"
                id="quantity"
                name="quantity"
                class="form-control"
                min="0"
                step="1"
                value="{{ old('quantity', $stock->quantity ?? '') }}"
                required>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Estoque</button>
    </form>

@endsection
