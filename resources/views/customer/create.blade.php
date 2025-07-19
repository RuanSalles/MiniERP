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

    <!-- Formulário de Cadastro de Cliente -->
    <form id="customerForm" method="POST" action="{{route('customers.store')}}">
        @csrf
        <!-- Sessão: Informações Pessoais -->
        <h4 class="mt-4 mb-3">Informações Pessoais</h4>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="name" class="form-label">Nome</label>
                <input type="text" class="form-control" id="name" name="name" value="{{@old('name')}}" required>
            </div>
            <div class="col-md-4">
                <label for="email" class="form-label">E-Mail</label>
                <input type="email" class="form-control" id="email" name="email" required value="{{old('email')}}">
            </div>
            <div class="col-md-4">
                <label for="phone" class="form-label">Telefone</label>
                <input type="text" class="form-control" id="phone" name="phone" required value="{{old('phone')}}">
            </div>
        </div>

        <!-- Sessão: Endereço -->
        <h4 class="mt-4 mb-3">Endereço</h4>
        <div class="row mb-3">
            <div class="col-md-2">
                <label for="zip" class="form-label">CEP</label>
                <input type="text" class="form-control" id="zip" name="zip" >
            </div>
            <div class="col-md-6">
                <label for="street" class="form-label">Logradouro</label>
                <input type="text" class="form-control" id="street" name="street" >
            </div>
            <div class="col-md-2">
                <label for="number" class="form-label">Número</label>
                <input type="text" class="form-control" id="number" name="number">
            </div>
            <div class="col-md-2">
                <label for="neighborhood" class="form-label">Bairro</label>
                <input type="text" class="form-control" id="neighborhood" name="neighborhood">
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <label for="city" class="form-label">Cidade</label>
                <input type="text" class="form-control" id="city" name="city">
            </div>
            <div class="col-md-4">
                <label for="state" class="form-label">Estado</label>
                <input type="text" class="form-control" id="state" name="state">
            </div>
            <div class="col-md-4">
                <label for="country" class="form-label">País</label>
                <input type="text" class="form-control" id="country" name="country" value="Brasil">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>

    <!-- jQuery + jQuery Mask Plugin -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <!-- JS: Máscara + ViaCEP -->
    <script>
        $(document).ready(function () {
            $('#phone').mask('(00) 00000-0000');
            $('#zip').mask('00000-000');

            $('#zip').on('blur', function () {
                const zip = $(this).val().replace(/\D/g, '');

                if (zip.length === 8) {
                    fetch(`https://viacep.com.br/ws/${zip}/json/`)
                        .then(response => response.json())
                        .then(data => {
                            if (!data.erro) {
                                $('#street').val(data.logradouro);
                                $('#neighborhood').val(data.bairro);
                                $('#city').val(data.localidade);
                                $('#state').val(data.uf);
                            } else {
                                alert('CEP não encontrado.');
                            }
                        })
                        .catch(() => alert('Erro ao buscar o CEP.'));
                }
            });
        });
    </script>

@endsection
