<x-app-layout>
    <x-slot name="header">
        <div>
            <a href="{{ route('equipment.index') }}" class="text-sm font-bold text-teal-200">Voltar</a>
            <h1 class="mt-1 text-3xl font-black">{{ $equipment->name }}</h1>
        </div>
    </x-slot>

    <section class="pp-panel rounded-2xl p-4">
        <div class="flex items-start justify-between gap-3">
            <div>
                <p class="text-sm font-bold text-slate-500">{{ $equipment->category->name }}</p>
                <p class="mt-2 text-4xl font-black text-slate-950">{{ $equipment->total_quantity }}</p>
                <p class="text-sm font-bold text-slate-500">{{ $equipment->unit }}</p>
            </div>
            @can('update', $equipment)
                <a href="{{ route('equipment.edit', $equipment) }}" class="pp-btn pp-btn-muted">Editar</a>
            @endcan
        </div>
        @if ($equipment->description)
            <p class="mt-5 text-slate-600">{{ $equipment->description }}</p>
        @endif
        @if ($equipment->notes)
            <p class="mt-3 rounded-xl bg-slate-100 p-3 text-sm font-semibold text-slate-600">{{ $equipment->notes }}</p>
        @endif
    </section>
</x-app-layout>
