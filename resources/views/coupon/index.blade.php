@extends('layout.layout')
@section('container')
    <div class="container py-4">

        <h2>Lista de Cupons</h2>

        <a href="{{ route('coupons.create') }}" class="btn btn-primary mb-3">Novo Cupom</a>

        @if($coupons->count())
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                <tr>
                    <th>Nome</th>
                    <th>Código</th>
                    <th>Tipo</th>
                    <th>Valor</th>
                    <th>Validade</th>
                    <th>Quantidade Restante</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($coupons as $coupon)
                    <tr>
                        <td>{{ $coupon->name }}</td>
                        <td>{{ $coupon->code }}</td>
                        <td>{{ $coupon->type === 'fixed' ? 'Valor Fixo' : 'Porcentagem' }}</td>
                        <td>
                            {{ $coupon->type === 'percentage' ? $coupon->value . '%' : 'R$ ' . number_format($coupon->value, 2, ',', '.') }}
                        </td>
                        <td>{{ $coupon->expires_at ? $coupon->expires_at->format('d/m/Y') : 'Não definido' }}</td>
                        <td>{{ $coupon->quantity }}</td>
                        <td>
                            <a href="{{ route('coupons.edit', $coupon->id) }}" class="btn btn-sm btn-primary">Editar</a>

                            <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Tem certeza que deseja excluir este cupom?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div>
                {{ $coupons->links() }}
            </div>
        @else
            <div class="alert alert-info">Nenhum cupom cadastrado ainda.</div>
        @endif
    </div>

@endsection
