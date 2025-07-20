@extends('layout.layout')
@section('container')
    <div class="container mt-5">
        <h2>{{ isset($coupon) ? 'Editar Cupom' : 'Cadastrar Cupom' }}</h2>

        <form method="POST" action="{{ isset($coupon) ? route('coupons.update', $coupon->id) : route('coupons.store') }}">
            @csrf
            @if(isset($coupon))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="name" class="form-label">Nome do Cupom</label>
                <input type="text" class="form-control" id="name" name="name"
                       value="{{ old('name', $coupon->name ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label for="code" class="form-label">Código</label>
                <input type="text" class="form-control" id="code" name="code"
                       value="{{ old('code', $coupon->code ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Tipo de Desconto</label>
                <select class="form-select" id="type" name="type" required>
                    <option value="">Selecione o tipo</option>
                    <option value="fixed" {{ old('type', $coupon->type ?? '') === 'fixed' ? 'selected' : '' }}>Valor fixo</option>
                    <option value="percentage" {{ old('type', $coupon->type ?? '') === 'percentage' ? 'selected' : '' }}>Porcentagem</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Limite de Uso</label>
                <input type="number"
                       id="quantity"
                       name="quantity"
                       class="form-control"
                       min="1"
                       step="1"
                       required
                       value="{{ old('quantity', $coupon->quantity ?? '') }}">
            </div>

            <div class="mb-3">
                <label for="value" class="form-label">Valor</label>
                <input type="number" class="form-control" id="value" name="value" step="0.01"
                       value="{{ old('value', $coupon->value ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label for="expires_at" class="form-label">Data de Validade</label>
                <input type="date" class="form-control" id="expires_at" name="expires_at"
                       value="{{ old('expires_at', isset($coupon->expires_at) ? $coupon->expires_at->format('Y-m-d') : '') }}">
            </div>

            <button type="submit" class="btn btn-primary">{{ isset($coupon) ? 'Atualizar' : 'Cadastrar' }}</button>
        </form>
    </div>

@endsection
