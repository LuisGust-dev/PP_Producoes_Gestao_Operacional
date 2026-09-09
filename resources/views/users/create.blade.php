<x-app-layout>
    <x-slot name="header"><h1 class="text-3xl font-black">Novo membro</h1></x-slot>

    <form method="POST" action="{{ route('users.store') }}" class="pp-panel rounded-2xl p-4">
        @include('users._form')
    </form>
</x-app-layout>
