<x-app-layout>
    <x-slot name="header">
        <div class="flex items-end justify-between gap-3">
            <div>
                <p class="text-sm font-bold text-teal-200">{{ $pageSubtitle ?? 'Agenda operacional' }}</p>
                <h1 class="mt-1 text-3xl font-black">{{ $pageTitle ?? 'Eventos' }}</h1>
            </div>
            @if ($showCreateButton ?? true)
                @can('create', App\Models\Event::class)
                <a href="{{ route('events.create') }}" class="pp-btn pp-btn-primary">Novo</a>
                @endcan
            @endif
        </div>
    </x-slot>

    <div class="space-y-4">
        @forelse ($events as $event)
            <x-app.event-card :event="$event" />
        @empty
            <x-app.empty-state :title="$emptyTitle ?? 'Nenhum evento cadastrado.'" :action="($showCreateButton ?? true) ? 'Criar primeiro evento' : null" :href="($showCreateButton ?? true) ? route('events.create') : null" />
        @endforelse
    </div>

    <div class="mt-5">{{ $events->links() }}</div>
</x-app-layout>
