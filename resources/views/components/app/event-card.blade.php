@props(['event'])

<article class="pp-panel rounded-2xl p-4">
    <div class="mb-3 flex items-start justify-between gap-3">
        <div class="min-w-0">
            <h3 class="truncate text-lg font-black text-slate-950">{{ $event->name }}</h3>
            <p class="mt-1 text-sm font-semibold text-slate-500">{{ $event->event_date?->format('d/m') }} @if($event->event_time) - {{ $event->event_time->format('H:i') }} @endif</p>
            <p class="truncate text-sm text-slate-500">{{ $event->location }} {{ $event->city ? '- '.$event->city : '' }}</p>
        </div>
        <x-app.status-badge class="shrink-0" :status="$event->status" />
    </div>

    <x-app.progress-bar label="Checklist" :value="$event->progressFor('loaded_quantity')" />

    <div class="mt-4 flex items-center justify-between">
        <span class="text-sm font-bold text-slate-500">{{ $event->pendingRequiredItems()->count() }} itens pendentes</span>
        <a href="{{ route('events.show', $event) }}" class="pp-btn pp-btn-dark">Abrir</a>
    </div>
</article>
