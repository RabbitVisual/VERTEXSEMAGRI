@props([
    'type' => 'info', // success, danger, warning, info
    'dismissible' => false,
    'icon' => null,
])

@php
    $icons = [
        'success' => 'bi-check-circle-fill',
        'danger' => 'bi-exclamation-triangle-fill',
        'warning' => 'bi-exclamation-circle-fill',
        'info' => 'bi-info-circle-fill',
    ];
    $iconClass = $icon ?? $icons[$type] ?? 'bi-info-circle-fill';
@endphp

<div class="alert alert-{{ $type }} {{ $dismissible ? 'alert-dismissible fade show' : '' }}" role="alert">
    @if($iconClass)
        <i class="{{ $iconClass }} me-2"></i>
    @endif
    {{ $slot }}
    @if($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    @endif
</div>

