@extends('layout.layout')
@section('container')

    <!-- Formulário de busca -->
    <form method="GET" action="{{ route('products.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar produto..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">Buscar</button>
        </div>
    </form>
    <a class="btn btn-primary" href="{{route('products.create')}}">Adicionar Produto</a>
    <!-- Tabela de produtos -->
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Código</th>
            <th>Valor</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->code }}</td>
                <td>R$ {{ number_format($product->amount, 2, ',', '.') }}</td>
                <td>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary">Editar</a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">Nenhum produto encontrado.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <!-- Paginação -->
    <div class="d-flex justify-content-center">
        {{ $products->appends(['search' => request('search')])->links() }}
    </div>

@endsection
