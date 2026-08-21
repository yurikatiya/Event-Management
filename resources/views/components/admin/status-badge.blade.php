@props(['status'])
@php
    $classes = match ($status) {
        'cancelled' => 'bg-red-50 text-red-600',
        'completed' => 'bg-slate-100 text-slate-600',
        'ongoing' => 'bg-emerald-50 text-emerald-600',
        default => 'bg-blue-50 text-blue-600',
    };
@endphp
<span {{ $attributes->merge(['class' => "rounded-full px-2.5 py-1 text-[10px] font-bold {$classes}"]) }}>{{ ucfirst($status) }}</span>