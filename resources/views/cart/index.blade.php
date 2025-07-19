@extends('layout.layout')
@section('container')
    <div class="container my-5">
        <h1 class="mb-4">Loja de Produtos</h1>
        <div class="row row-cols-1 row-cols-md-3 g-4">

            <!-- Produto -->
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Produto 1</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Código: 12345</h6>
                        <p class="card-text">Descrição breve do produto número 1.</p>
                        <p class="fw-bold">R$ 99,99</p>
                        <a href="#" class="btn btn-primary w-100">Comprar</a>
                    </div>
                </div>
            </div>

            <!-- Produto -->
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Produto 2</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Código: 54321</h6>
                        <p class="card-text">Outro produto com uma descrição detalhada.</p>
                        <p class="fw-bold">R$ 149,90</p>
                        <a href="#" class="btn btn-primary w-100">Comprar</a>
                    </div>
                </div>
            </div>

            <!-- Produto -->
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Produto 3</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Código: 67890</h6>
                        <p class="card-text">Produto de alta qualidade com ótimo custo-benefício.</p>
                        <p class="fw-bold">R$ 79,50</p>
                        <a href="#" class="btn btn-primary w-100">Comprar</a>
                    </div>
                </div>
            </div>

            <!-- Adicione mais produtos seguindo esse padrão -->

        </div>
    </div>
@endsection
