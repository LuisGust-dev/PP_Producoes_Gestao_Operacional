@props(['value' => 0, 'label' => null])

@php($value = max(0, min(100, (int) $value)))

<div {{ $attributes }}>
    <div class="mb-2 flex items-center justify-between text-sm font-bold text-slate-700">
        <span>{{ $label }}</span>
        <span>{{ $value }}%</span>
    </div>
    <div class="h-3 overflow-hidden rounded-full bg-slate-200">
        <div class="h-full rounded-full bg-teal-500" style="width: {{ $value }}%"></div>
    </div>
</div>
