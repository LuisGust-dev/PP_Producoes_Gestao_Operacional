<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-bold text-teal-200">Bom dia, {{ auth()->user()->name }}</p>
            <h1 class="mt-1 text-3xl font-black">Operação de hoje</h1>
        </div>
    </x-slot>

    <section class="grid grid-cols-2 gap-3 md:grid-cols-4">
        @foreach ([['Eventos hoje', $eventsToday], ['Próximos eventos', $upcomingEvents], ['Checklists pendentes', $pendingChecklists], ['Eventos prontos', $readyEvents]] as [$label, $value])
            <div class="pp-panel rounded-2xl p-4">
                <p class="text-xs font-black uppercase text-slate-500">{{ $label }}</p>
                <p class="mt-3 text-3xl font-black text-slate-950">{{ $value }}</p>
            </div>
        @endforeach
    </section>

    <section class="mt-7">
        <div class="mb-4 flex items-center justify-between gap-3">
            <h2 class="text-xl font-black text-slate-950">Próximos eventos</h2>
            @can('create', App\Models\Event::class)
                <a href="{{ route('events.create') }}" class="pp-btn pp-btn-primary">Novo</a>
            @endcan
        </div>

        <div class="space-y-4">
            @forelse ($events as $event)
                <x-app.event-card :event="$event" />
            @empty
                <x-app.empty-state title="Nenhum evento cadastrado." action="Criar primeiro evento" :href="route('events.create')" />
            @endforelse
        </div>
    </section>
</x-app-layout>
