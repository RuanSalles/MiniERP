@extends('layout.layout')
@section('container')
    <a class="btn btn-primary" href="{{route('stocks.create')}}">Cadastrar Estoque</a>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        @foreach($stocks as $stock)
            <tr>
                <td>{{ $stock->product->name }}</td>
                <td>{{ $stock->quantity }}</td>
                <td>
                    <!-- Botão Editar -->
                    <a href="{{ route('stocks.edit', $stock->id) }}" class="btn btn-sm btn-primary">Editar</a>

                    <!-- Botão Excluir -->
                    <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este estoque?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $stocks->links() }}

@endsection
