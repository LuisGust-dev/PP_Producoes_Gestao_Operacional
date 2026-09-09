<x-app-layout>
    <x-slot name="header"><h1 class="text-3xl font-black">Editar evento</h1></x-slot>

    <form method="POST" action="{{ route('events.update', $event) }}" class="pp-panel rounded-2xl p-4">
        @method('PUT')
        @include('events._form')
    </form>
</x-app-layout>
