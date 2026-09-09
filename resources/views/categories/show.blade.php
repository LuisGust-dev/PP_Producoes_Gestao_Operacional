<x-app-layout>
    <x-slot name="header"><h1 class="text-3xl font-black">{{ $category->name }}</h1></x-slot>
    <section class="pp-panel rounded-2xl p-4">
        <p class="font-semibold text-slate-600">Categoria {{ $category->active ? 'ativa' : 'inativa' }}.</p>
    </section>
</x-app-layout>
