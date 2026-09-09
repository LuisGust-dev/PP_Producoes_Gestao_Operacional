<x-app-layout>
    <x-slot name="header"><h1 class="text-3xl font-black">Nova categoria</h1></x-slot>

    <form method="POST" action="{{ route('categories.store') }}" class="pp-panel rounded-2xl p-4">
        @include('categories._form')
    </form>
</x-app-layout>
