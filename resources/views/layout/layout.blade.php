<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Ícones (opcional) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            overflow-x: hidden;
        }

        .sidebar {
            min-height: 100vh;
            background-color: black;
        }

        .sidebar a {
            color: black;
            padding: 12px 16px;
            display: block;
            text-decoration: none;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: whitesmoke;
        }

        .content {
            padding: 24px;
        }
    </style>
</head>
<body>


<!-- Navbar -->
<nav class="navbar navbar-dark bg-dark sticky-top shadow">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Admin Panel</a>
        <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar offcanvas-md offcanvas-start">
            <div class="offcanvas-body p-0">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="/"><i class="bi bi-speedometer2"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('customers.index')}}"><i class="bi bi-people"></i>
                            Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('products.index')}}"><i class="bi bi-box"></i> Produtos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('stocks.index')}}"><i class="bi bi-receipt"></i> Estoque</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('coupons.index')}}"><i class="bi bi-bookmark-plus"></i> Cupons</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('carts.index')}}"><i class="bi bi-shop"></i> Loja</a>
                    </li>
                    @if(session('cart'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('checkout')}}"><i class="bi bi-cart-check-fill"></i> Finalizar Compra</a>
                    </li>
                    @endif
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 content">
            <x-flash-message type="success"/>
            <x-flash-message type="error"/>
            <x-flash-message type="warning"/>
            <x-flash-message type="info"/>
            @yield('container')
        </main>


    </div>
</div>


<!-- Bootstrap 5 JS CDN (com Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</body>
</html>
