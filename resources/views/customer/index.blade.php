@extends('layout.layout')
@section('container')
    <a class="btn btn-primary" href="{{route('customer.create')}}">Novo Usuário</a>
    <table class="table table-bordered table-striped align-middle mt-4">
        <thead class="table-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">E-mail</th>
            <th scope="col">Telefone</th>
        </tr>
        </thead>
        <tbody>
        @foreach($customers as $customer)
        <tr>
            <th scope="row">{{$customer->id}}</th>
            <td>{{$customer->name}}</td>
            <td>{{$customer->email}}</td>
            <td>{{$customer->phone}}</td>
        </tr>
        @endforeach

        <!-- Outras linhas podem ser geradas dinamicamente via Blade ou JavaScript -->
        </tbody>
    </table>

@endsection
