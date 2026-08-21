@props(['label', 'value', 'caption', 'icon', 'tone' => 'blue'])
@php
    $tones = ['blue' => 'border-blue-500 bg-blue-50 text-blue-600', 'green' => 'border-emerald-500 bg-emerald-50 text-emerald-600', 'amber' => 'border-amber-500 bg-amber-50 text-amber-600', 'navy' => 'border-slate-700 bg-slate-100 text-slate-700'];
@endphp
<div class="rounded-2xl border border-slate-200 border-l-4 {{ str($tones[$tone])->before(' ') }} bg-white p-5 shadow-sm">
    <div class="flex items-start justify-between"><p class="text-xs font-semibold text-slate-500">{{ $label }}</p><span class="flex h-8 w-8 items-center justify-center rounded-lg {{ $tones[$tone] }}"><i class="bi {{ $icon }}"></i></span></div>
    <p class="mt-5 text-3xl font-bold tracking-tight text-slate-900">{{ number_format($value) }}</p><p class="mt-1 text-xs text-slate-400">{{ $caption }}</p>
</div>