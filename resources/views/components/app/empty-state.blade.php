@props(['title', 'action' => null, 'href' => null])

<div class="pp-panel rounded-2xl p-6 text-center">
    <div class="mx-auto mb-3 grid h-12 w-12 place-items-center rounded-2xl bg-slate-100 text-slate-700">
        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 5v14M5 12h14" />
        </svg>
    </div>
    <p class="font-black text-slate-900">{{ $title }}</p>
    @if ($action && $href)
        <a href="{{ $href }}" class="pp-btn pp-btn-primary mt-4">{{ $action }}</a>
    @endif
</div>
