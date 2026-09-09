<x-app-layout>
    <x-slot name="header"><h1 class="text-3xl font-black">Editar usuário</h1></x-slot>

    <form method="POST" action="{{ route('users.update', $user) }}" class="pp-panel rounded-2xl p-4">
        @method('PUT')
        @include('users._form')
    </form>
</x-app-layout>
