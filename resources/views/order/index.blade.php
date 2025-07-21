@extends('layout.layout')
@section('container')
    <div class="container mt-5">
        <h2>Lista de Pedidos</h2>

        @if($orders->count() > 0)
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Desconto</th>
                    <th>Cupom</th>
                    <th>Frete</th>
                    <th>Status</th>
                    <th>Data do Pedido</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->customer->name ?? 'N/A' }}</td>
                        <td>R$ {{ number_format($order->amount, 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($order->discount, 2, ',', '.') }}</td>
                        <td>{{ $order->coupon ? $order->coupon->code : '-' }}</td>
                        <td>R$ {{ number_format($order->shipping ?? 0, 2, ',', '.') }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{-- Paginação --}}
            {{ $orders->links() }}
        @else
            <div class="alert alert-info">Nenhum pedido encontrado.</div>
        @endif
    </div>

@endsection
