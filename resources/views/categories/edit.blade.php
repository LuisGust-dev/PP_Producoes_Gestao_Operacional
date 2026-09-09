<x-app-layout>
    <x-slot name="header"><h1 class="text-3xl font-black">Editar categoria</h1></x-slot>

    <form method="POST" action="{{ route('categories.update', $category) }}" class="pp-panel rounded-2xl p-4">
        @method('PUT')
        @include('categories._form')
    </form>
</x-app-layout>
