@extends('layout.layout')
@section('container')
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Erro(s) encontrados:</strong>
            <ul>
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}">
        @csrf

        @if(isset($product))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="name" class="form-label">Nome do Produto</label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ old('name', $product->name ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descrição</label>
            <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description', $product->description ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="code" class="form-label">Código</label>
            <input type="text" class="form-control" id="code" name="code"
                   value="{{ old('code', $product->code ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">Valor</label>
            <input type="number" class="form-control" id="amount" name="amount" step="0.01" inputmode="decimal"
                   value="{{ old('amount', $product->amount ?? '') }}" required>
        </div>

        <!-- Container das variações -->
        <div id="variations-container" class="mb-3">
            <label class="form-label">Variações do Produto</label>

            <div id="variation-list"></div>

            <button type="button" class="btn btn-outline-primary mt-2" id="add-variation">+ Adicionar Variação</button>
        </div>


        <button type="submit" class="btn btn-primary">Salvar Produto</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script type="text/template" id="variation-template">
        <div class="variation-item border rounded p-3 mb-2 position-relative">
            <button type="button" class="btn-close position-absolute top-0 end-0 remove-variation" aria-label="Remover"></button>

            <div class="mb-2">
                <label class="form-label">Cor</label>
                <input type="text" name="variations[__index__][color]" class="form-control" required>
            </div>

            <div class="mb-2">
                <label class="form-label">Tamanho</label>
                <input type="text" name="variations[__index__][size]" class="form-control" required>
            </div>

            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="variations[__index__][isPrinted]" value="1">
                <label class="form-check-label">Estampado</label>
            </div>
        </div>
    </script>


    <script>
        $(function () {
            let index = 0;

            // Se houver variações pré-existentes (Laravel blade irá renderizar isso)
            @isset($product)
            @if ($product->variances && $product->variances->count())
            @foreach ($product->variances as $i => $variance)
            const template_{{ $i }} = $('#variation-template').html()
                .replace(/__index__/g, {{ $i }});
            $('#variation-list').append(template_{{ $i }});

            $(`[name="variations[{{ $i }}][color]"]`).val("{{ $variance->color }}");
            $(`[name="variations[{{ $i }}][size]"]`).val("{{ $variance->size }}");
            @if ($variance->isPrinted)
            $(`[name="variations[{{ $i }}][isPrinted]"]`).prop('checked', true);
            @endif
                @endforeach
                index = {{ $product->variances->count() }};
            @endif
            @endisset


            $('#add-variation').on('click', function () {
                const template = $('#variation-template').html().replace(/__index__/g, index);
                $('#variation-list').append(template);
                index++;
            });

            $(document).on('click', '.remove-variation', function () {
                $(this).closest('.variation-item').remove();
            });
        });
    </script>

@endsection
