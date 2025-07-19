@props(['type' => 'success'])

@php
    $alertClasses = [
        'success' => 'alert-success',
        'error' => 'alert-danger',
        'warning' => 'alert-warning',
        'info' => 'alert-info',
    ];
    $class = $alertClasses[$type] ?? 'alert-info';
@endphp

@if(session($type))
    <div {{ $attributes->merge(['class' => "alert $class alert-dismissible fade show"]) }} role="alert">
        {{ session($type) }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
@endif
