<x-app-layout>
    <x-slot name="header">
        <div class="flex items-end justify-between gap-3">
            <div>
                <p class="text-sm font-bold text-teal-200">Administração</p>
                <h1 class="mt-1 text-3xl font-black">Equipe</h1>
            </div>
            <a href="{{ route('users.create') }}" class="pp-btn pp-btn-primary">Novo</a>
        </div>
    </x-slot>

    <div class="space-y-3">
        @foreach ($users as $user)
            <article class="pp-panel rounded-2xl p-4">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <h2 class="truncate font-black text-slate-950">{{ $user->name }}</h2>
                        <p class="truncate text-sm font-semibold text-slate-500">{{ $user->email }}</p>
                        <p class="mt-2 text-xs font-black uppercase text-slate-400">{{ $user->role->label() }}</p>
                    </div>
                    <span class="shrink-0 rounded-full px-3 py-1 text-xs font-black {{ $user->active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                        {{ $user->active ? 'Ativo' : 'Inativo' }}
                    </span>
                </div>

                <div class="mt-4 flex gap-2">
                    <a href="{{ route('users.edit', $user) }}" class="pp-btn pp-btn-muted flex-1">Editar</a>
                    @can('delete', $user)
                        <form method="POST" action="{{ route('users.destroy', $user) }}" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button class="pp-btn pp-btn-dark w-full">Desativar</button>
                        </form>
                    @endcan
                </div>
            </article>
        @endforeach
    </div>

    <div class="mt-5">{{ $users->links() }}</div>
</x-app-layout>
