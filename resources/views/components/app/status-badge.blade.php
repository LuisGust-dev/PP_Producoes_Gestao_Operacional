@props(['status'])

@php
    $tone = $status?->tone() ?? 'slate';
    $classes = [
        'slate' => 'bg-slate-100 text-slate-700',
        'amber' => 'bg-amber-100 text-amber-800',
        'sky' => 'bg-sky-100 text-sky-800',
        'emerald' => 'bg-emerald-100 text-emerald-800',
        'violet' => 'bg-violet-100 text-violet-800',
        'orange' => 'bg-orange-100 text-orange-800',
        'zinc' => 'bg-zinc-100 text-zinc-800',
        'rose' => 'bg-rose-100 text-rose-800',
    ][$tone] ?? 'bg-slate-100 text-slate-700';
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full px-3 py-1 text-xs font-black '.$classes]) }}>
    {{ $status?->label() ?? 'Pendente' }}
</span>
