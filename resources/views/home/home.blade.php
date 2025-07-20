@extends('layout.layout')
@section('container')
        <h1 class="h2">Bem-vindo ao Painel</h1>
        <p>Este é o conteúdo principal do seu painel administrativo.</p>

        <div class="row">
            <div class="col-md-4">
                <div class="card text-bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Clientes</h5>
                        <p class="card-text">Total: {{ $data['customers'] }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Produtos</h5>
                        <p class="card-text">Total: {{ $data['products'] }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Pedidos Pendentes</h5>
                        <p class="card-text">Total: 17</p>
                    </div>
                </div>
            </div>
        </div>
@endsection
