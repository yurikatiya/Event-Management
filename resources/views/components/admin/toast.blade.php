@props(['type' => 'success', 'message' => ''])

@php
    $isError = $type === 'error';
    $panelClasses = $isError
        ? 'border-red-200 bg-red-50 text-red-700 shadow-red-100/70'
        : 'border-emerald-200 bg-emerald-50 text-emerald-700 shadow-emerald-100/70';
    $iconClasses = $isError ? 'bi-exclamation-circle-fill' : 'bi-check-circle-fill';
@endphp

<div data-toast-item class="toast-item {{ $panelClasses }}" role="status" aria-live="polite">
    <div class="toast-icon"><i class="bi {{ $iconClasses }}"></i></div>
    <div class="toast-content">
        <strong class="toast-title">{{ $isError ? 'Perhatian' : 'Berhasil' }}</strong>
        <span>{{ $message }}</span>
    </div>
    <button type="button" data-toast-close class="toast-close" aria-label="Tutup notifikasi">
        <i class="bi bi-x-lg"></i>
    </button>
</div>
