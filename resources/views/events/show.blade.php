<x-app-layout>
    <x-slot name="header">
        <div>
            <a href="{{ route('events.index') }}" class="text-sm font-bold text-teal-200">Voltar</a>
            <h1 class="mt-1 text-3xl font-black">{{ $event->name }}</h1>
            <p class="mt-1 text-sm text-white/70">{{ $event->event_date?->format('d/m/Y') }} @if($event->event_time) - {{ $event->event_time->format('H:i') }} @endif - {{ $event->location }}</p>
        </div>
    </x-slot>

    <section class="pp-panel rounded-2xl p-4">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="min-w-0">
                <p class="text-xs font-black uppercase text-slate-500">Status</p>
                <x-app.status-badge class="mt-2" :status="$event->status" />
            </div>
            @can('update', $event)
                <a href="{{ route('events.edit', $event) }}" class="pp-btn pp-btn-muted">Editar</a>
            @endcan
        </div>
        <div class="mt-5 grid gap-4 md:grid-cols-2">
            <x-app.progress-bar label="Preparação" :value="$event->progressFor('separated_quantity')" />
            <x-app.progress-bar label="Carregamento" :value="$event->progressFor('loaded_quantity')" />
        </div>
    </section>

    @if ($errors->any())
        <div class="mt-4 rounded-xl bg-rose-50 p-4 text-sm font-semibold text-rose-700">{{ $errors->first() }}</div>
    @endif

    @can('update', $event)
        <form method="POST" action="{{ route('events.equipment.store', $event) }}" class="pp-panel mt-5 rounded-2xl p-4">
            @csrf
            <h2 class="mb-4 text-lg font-black text-slate-950">Adicionar equipamento</h2>
            <div class="grid gap-3 md:grid-cols-[1fr_140px_1fr_auto]">
                <select class="pp-input" name="equipment_id" required>
                    <option value="">Buscar equipamento</option>
                    @foreach ($equipment as $catalogItem)
                        <option value="{{ $catalogItem->id }}">{{ $catalogItem->name }} - {{ $catalogItem->category->name }}</option>
                    @endforeach
                </select>
                <input class="pp-input" type="number" min="1" name="required_quantity" placeholder="Qtd." required>
                <input class="pp-input" name="observation" placeholder="Observação">
                <button class="pp-btn pp-btn-primary">Adicionar</button>
            </div>
        </form>
    @endcan

    <section class="mt-5 space-y-4">
        @forelse ($event->equipmentItems->groupBy(fn ($item) => $item->equipment->category->name) as $category => $items)
            <div>
                <h2 class="mb-2 text-sm font-black uppercase text-slate-500">{{ $category }}</h2>
                <div class="space-y-3">
                    @foreach ($items as $item)
                        <form method="POST" action="{{ route('events.equipment.checklist.update', [$event, $item]) }}" class="pp-panel rounded-2xl p-4">
                            @csrf
                            @method('PATCH')
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <h3 class="truncate font-black text-slate-950">{{ $item->equipment->name }}</h3>
                                    <p class="text-sm text-slate-500">Necessário: {{ $item->required_quantity }} {{ $item->equipment->unit }}</p>
                                    @if ($item->observation)<p class="text-sm text-slate-500">{{ $item->observation }}</p>@endif
                                </div>
                                <span class="shrink-0 text-sm font-black text-teal-700">{{ $item->loaded_quantity }}/{{ $item->required_quantity }}</span>
                            </div>
                            <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-3">
                                <label><span class="pp-label">Separado</span><input class="pp-input" type="number" min="0" max="{{ $item->required_quantity }}" name="separated_quantity" value="{{ $item->separated_quantity }}"></label>
                                <label><span class="pp-label">Carregado</span><input class="pp-input" type="number" min="0" max="{{ $item->required_quantity }}" name="loaded_quantity" value="{{ $item->loaded_quantity }}"></label>
                                <label><span class="pp-label">Retorno</span><input class="pp-input" type="number" min="0" max="{{ $item->loaded_quantity }}" name="returned_quantity" value="{{ $item->returned_quantity }}"></label>
                            </div>
                            <button class="pp-btn pp-btn-dark mt-4 w-full">Atualizar</button>
                            @if ($item->lastUpdatedBy)
                                <p class="mt-3 text-xs font-semibold text-slate-500">Última atualização: {{ $item->lastUpdatedBy->name }}</p>
                            @endif
                        </form>
                    @endforeach
                </div>
            </div>
        @empty
            <x-app.empty-state title="Nenhum equipamento adicionado." />
        @endforelse
    </section>

    @can('update', $event)
        <form method="POST" action="{{ route('events.release', $event) }}" class="mt-5">
            @csrf
            <button class="pp-btn pp-btn-primary w-full">Liberar para saída</button>
        </form>
    @endcan
</x-app-layout>
