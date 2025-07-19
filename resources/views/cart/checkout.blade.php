@extends('layout.layout')

@section('container')
    <div class="container my-5">
        <h1 class="mb-4">Finalizar Compra</h1>

        <div class="row">
            <!-- Formulário de dados do cliente -->
            <div class="col-md-7">
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Informações do Cliente</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nome Completo</label>
                                <input type="text" class="form-control" id="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Telefone</label>
                                <input type="tel" class="form-control" id="phone" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Endereço de Entrega</label>
                                <textarea class="form-control" id="address" rows="3" required></textarea>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Resumo do pedido -->
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Resumo do Pedido</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Produto 1</span>
                                <strong>R$ 99,90</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Produto 2</span>
                                <strong>R$ 79,90</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Frete</span>
                                <strong>R$ 15,00</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Total</strong>
                                <strong>R$ 194,80</strong>
                            </li>
                        </ul>

                        <button class="btn btn-success w-100">Finalizar Compra</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
