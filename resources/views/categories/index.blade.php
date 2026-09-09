<x-app-layout>
    <x-slot name="header">
        <div class="flex items-end justify-between gap-3">
            <div>
                <p class="text-sm font-bold text-teal-200">Organizacao</p>
                <h1 class="mt-1 text-3xl font-black">Categorias</h1>
            </div>
            <a href="{{ route('categories.create') }}" class="pp-btn pp-btn-primary">Nova</a>
        </div>
    </x-slot>

    <div class="grid gap-3 md:grid-cols-2">
        @foreach ($categories as $category)
            <a href="{{ route('categories.edit', $category) }}" class="pp-panel rounded-2xl p-4">
                <div class="flex items-center justify-between gap-3">
                    <div class="min-w-0">
                        <h2 class="truncate font-black text-slate-950">{{ $category->name }}</h2>
                        <p class="text-sm font-semibold text-slate-500">{{ $category->equipment_count }} equipamentos</p>
                    </div>
                    <span class="shrink-0 rounded-full px-3 py-1 text-xs font-black {{ $category->active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">{{ $category->active ? 'Ativa' : 'Inativa' }}</span>
                </div>
            </a>
        @endforeach
    </div>
</x-app-layout>
