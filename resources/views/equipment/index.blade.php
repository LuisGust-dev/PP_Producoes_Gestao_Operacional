<x-app-layout>
    <x-slot name="header">
        <div class="flex items-end justify-between gap-3">
            <div>
                <p class="text-sm font-bold text-teal-200">Estoque e catálogo</p>
                <h1 class="mt-1 text-3xl font-black">Equipamentos</h1>
            </div>
            @can('create', App\Models\Equipment::class)
                <a href="{{ route('equipment.create') }}" class="pp-btn pp-btn-primary">Novo</a>
            @endcan
        </div>
    </x-slot>

    <div class="mb-4 flex gap-2 overflow-x-auto pb-1">
        <a href="{{ route('equipment.index') }}" class="rounded-full px-4 py-2 text-sm font-black {{ request('category') ? 'bg-white text-slate-700' : 'bg-slate-950 text-white' }}">Todos</a>
        @foreach ($categories as $category)
            <a href="{{ route('equipment.index', ['category' => $category->id]) }}" class="rounded-full px-4 py-2 text-sm font-black {{ request('category') == $category->id ? 'bg-slate-950 text-white' : 'bg-white text-slate-700' }}">{{ $category->name }}</a>
        @endforeach
    </div>

    <div class="grid gap-3 md:grid-cols-2">
        @forelse ($equipment as $item)
            <a href="{{ route('equipment.show', $item) }}" class="pp-panel rounded-2xl p-4">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <h2 class="truncate font-black text-slate-950">{{ $item->name }}</h2>
                        <p class="truncate text-sm font-semibold text-slate-500">{{ $item->category->name }}</p>
                    </div>
                    <span class="shrink-0 rounded-full bg-slate-100 px-3 py-1 text-sm font-black text-slate-700">{{ $item->total_quantity }} {{ $item->unit }}</span>
                </div>
                @if ($item->code)
                    <p class="mt-3 text-xs font-bold text-slate-400">{{ $item->code }}</p>
                @endif
            </a>
        @empty
            <x-app.empty-state title="Nenhum equipamento cadastrado." action="Adicionar equipamento" :href="route('equipment.create')" />
        @endforelse
    </div>

    <div class="mt-5">{{ $equipment->links() }}</div>
</x-app-layout>
