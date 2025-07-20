@extends('layout.layout')

@section('container')


    <div class="container mt-5">
        <h2>Finalização do Pedido</h2>

        @if(session('cart') && count(session('cart')) > 0)
            <form method="POST" >
                @csrf

                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                    <tr>
                        <th>Produto</th>
                        <th>Variação</th>
                        <th>Valor Unitário</th>
                        <th>Quantidade</th>
                        <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $total = 0; @endphp

                    @foreach(session('cart') as $index => $item)
                        @php
                            $subtotal = $item['amount'] * $item['quantity'];
                            $total += $subtotal;
                        @endphp
                        <tr>
                            <td>{{ $item['product_name'] }}</td>
                            <td>
                                Cor: {{ $item['variance']['color'] ?? '' }} . <br>
                                Tamanho: {{ $item['variance']['size'] ?? '' }}
                            </td>
                            <td>R$ <span class="unit-amount" data-amount="{{ $item['amount'] }}">{{ number_format($item['amount'], 2, ',', '.') }}</span></td>
                            <td>
                                <select name="quantities[{{ $index }}]" class="form-select quantity-select" required>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}" {{ $item['quantity'] == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </td>
                            <td>R$ <span class="subtotal">{{ number_format($subtotal, 2, ',', '.') }}</span></td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr class="table-secondary">
                        <td colspan="4" class="text-end fw-bold">Total:</td>
                        <td class="fw-bold">R$ <span id="total-amount">{{ number_format($total, 2, ',', '.') }}</span></td>
                    </tr>
                    </tfoot>
                </table>

                <button type="submit" class="btn btn-success">Finalizar Pedido</button>
            </form>
        @else
            <div class="alert alert-info">Seu carrinho está vazio.</div>
        @endif
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
            $('.quantity-select').on('change', function() {
                var $row = $(this).closest('tr');
                var unitamount = parseFloat($row.find('.unit-amount').data('amount'));
                var quantity = parseInt($(this).val());

                var newSubtotal = unitamount * quantity;
                $row.find('.subtotal').text(newSubtotal.toFixed(2).replace('.', ','));

                var total = 0;
                $('.subtotal').each(function() {
                    total += parseFloat($(this).text().replace(',', '.'));
                });
                $('#total-amount').text(total.toFixed(2).replace('.', ','));
            });
        });
    </script>
@endsection

