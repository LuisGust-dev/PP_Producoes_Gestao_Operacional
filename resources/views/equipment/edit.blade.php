<x-app-layout>
    <x-slot name="header"><h1 class="text-3xl font-black">Editar equipamento</h1></x-slot>

    <form method="POST" action="{{ route('equipment.update', $equipment) }}" class="pp-panel rounded-2xl p-4">
        @method('PUT')
        @include('equipment._form')
    </form>
</x-app-layout>
