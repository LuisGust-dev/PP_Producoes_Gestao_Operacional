<x-app-layout>
    <x-slot name="header"><h1 class="text-3xl font-black">Novo evento</h1></x-slot>

    <form method="POST" action="{{ route('events.store') }}" class="pp-panel rounded-2xl p-4">
        @include('events._form')
    </form>
</x-app-layout>
