@extends('layout.layout')

@section('container')
    <div class="container mt-5">
        <h2>Finalização do Pedido</h2>

        @if(session('cart') && count(session('cart')) > 0)
            <form method="POST" action="{{ route('orders.store') }}">
                @csrf

                {{-- CEP --}}
                <div class="mb-3">
                    <label for="cep" class="form-label">CEP</label>
                    <input type="text" id="cep" name="cep" class="form-control" maxlength="9" required>
                </div>

                {{-- CUPOM --}}
                <div class="mb-3">
                    <label for="coupon_code" class="form-label">Cupom de Desconto</label>
                    <div class="input-group">
                        <input type="text" id="coupon_code" class="form-control" placeholder="Digite o código do cupom">
                        <button type="button" class="btn btn-outline-primary" id="apply_coupon">Aplicar</button>
                    </div>
                </div>

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
                            <td>Cor: {{ $item['variance']['color'] ?? '' }} <br> Tamanho: {{ $item['variance']['size'] ?? '' }}</td>
                            <td>R$ <span class="unit-amount" data-amount="{{ $item['amount'] }}">{{ number_format($item['amount'], 2, ',', '.') }}</span></td>
                            <td>
                                <select name="quantities[{{ $index }}]" class="form-select quantity-select" required>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}" {{ $item['quantity'] == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                                {{-- Quantidade oculta para envio --}}
                                <input type="hidden" name="quantities_hidden[]" class="qty-input-hidden" value="{{ $item['quantity'] }}">
                            </td>
                            <td>R$ <span class="subtotal">{{ number_format($subtotal, 2, ',', '.') }}</span></td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="4" class="text-end">Subtotal:</td>
                        <td>R$ <span id="subtotal-display">{{ number_format($total, 2, ',', '.') }}</span></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-end">Desconto:</td>
                        <td>R$ <span id="discount-display">0,00</span></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-end">Frete:</td>
                        <td>R$ <span id="freight-display">0,00</span></td>
                    </tr>
                    <tr class="table-secondary">
                        <td colspan="4" class="text-end fw-bold">Total:</td>
                        <td class="fw-bold">R$ <span id="total-amount">{{ number_format($total, 2, ',', '.') }}</span></td>
                    </tr>
                    </tfoot>
                </table>

                {{-- Campos ocultos --}}
                <input type="hidden" name="subtotal" id="subtotal_input" value="{{ number_format($total, 2, '.', '') }}">
                <input type="hidden" name="discount_value" id="discount_value" value="0">
                <input type="hidden" name="freight_value" id="freight_value" value="0">
                <input type="hidden" name="final_total" id="final_total_input" value="{{ number_format($total, 2, '.', '') }}">
                <input type="hidden" name="coupon_code" id="coupon_code_input" value="">
                <input type="hidden" name="cep_hidden" id="cep_hidden" value="">

                <button type="submit" class="btn btn-success">Finalizar Pedido</button>
            </form>
        @else
            <div class="alert alert-info">Seu carrinho está vazio.</div>
        @endif
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        function formatMoney(value) {
            return parseFloat(value).toFixed(2).replace('.', ',');
        }

        function updateHiddenFormFields() {
            let total = 0;
            $('.subtotal').each(function () {
                total += parseFloat($(this).text().replace(',', '.'));
            });

            let discount = parseFloat($('#discount_value').val()) || 0;
            let freight = parseFloat($('#freight_value').val()) || 0;
            let finalTotal = total - discount + freight;

            $('#subtotal_input').val(total.toFixed(2));
            $('#final_total_input').val(finalTotal.toFixed(2));
            $('#cep_hidden').val($('#cep').val());
            $('#coupon_code_input').val($('#coupon_code').val());

            $('.quantity-select').each(function (index) {
                let val = $(this).val();
                $('.qty-input-hidden').eq(index).val(val);
            });

            $('#subtotal-display').text(formatMoney(total));
            $('#total-amount').text(formatMoney(finalTotal));
        }

        function calculateFreightAndUpdate() {
            let subtotal = 0;
            $('.subtotal').each(function () {
                subtotal += parseFloat($(this).text().replace(',', '.'));
            });

            let freight = 20;
            if (subtotal >= 200) {
                freight = 0;
            } else if (subtotal >= 52 && subtotal <= 166.59) {
                freight = 15;
            }

            $('#freight-display').text(formatMoney(freight));
            $('#freight_value').val(freight);
            updateHiddenFormFields();
        }

        $(document).ready(function () {
            $('.quantity-select').on('change', function () {
                let $row = $(this).closest('tr');
                let unitAmount = parseFloat($row.find('.unit-amount').data('amount'));
                let quantity = parseInt($(this).val());
                let newSubtotal = unitAmount * quantity;

                $row.find('.subtotal').text(formatMoney(newSubtotal));
                calculateFreightAndUpdate();
            });

            $('#apply_coupon').on('click', function () {
                let code = $('#coupon_code').val().trim();

                if (!code) return alert('Digite o código do cupom.');

                fetch(`/getCoupon/${code}`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data || !data.value) {
                            alert('Cupom inválido.');
                            return;
                        }

                        let subtotal = 0;
                        $('.subtotal').each(function () {
                            subtotal += parseFloat($(this).text().replace(',', '.'));
                        });

                        let discount = data.type === 'percentage'
                            ? subtotal * (parseFloat(data.value) / 100)
                            : parseFloat(data.value);

                        $('#discount-display').text(formatMoney(discount));
                        $('#discount_value').val(discount.toFixed(2));
                        updateHiddenFormFields();
                    })
                    .catch(() => alert('Erro ao validar cupom.'));
            });

            $('#cep').on('blur', function () {
                let cep = $(this).val().replace(/\D/g, '');
                if (cep.length !== 8) return;

                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.erro) {
                            alert('CEP não encontrado.');
                        } else {
                            calculateFreightAndUpdate();
                        }
                    });
            });

            $('form').on('submit', function () {
                updateHiddenFormFields();
            });

            calculateFreightAndUpdate(); // inicializa
        });
    </script>
@endsection

