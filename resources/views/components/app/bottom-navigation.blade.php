@php
    $items = [
        ['route' => 'dashboard', 'active' => ['dashboard'], 'label' => 'Início', 'path' => 'M3 11l9-8 9 8v9a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1z'],
        ['route' => 'events.index', 'active' => ['events.index', 'events.create', 'events.show', 'events.edit'], 'label' => 'Eventos', 'path' => 'M7 3v3M17 3v3M4 8h16M5 5h14a1 1 0 0 1 1 1v14H4V6a1 1 0 0 1 1-1z'],
        ['route' => 'equipment.index', 'active' => ['equipment.*'], 'label' => 'Equip.', 'path' => 'M4 7l8-4 8 4-8 4-8-4zM4 12l8 4 8-4M4 17l8 4 8-4'],
        ['route' => 'events.history', 'active' => ['events.history'], 'label' => 'Histórico', 'path' => 'M12 8v5l3 2M21 12a9 9 0 1 1-3-6.7'],
        ['route' => 'profile.edit', 'active' => ['profile.*'], 'label' => 'Perfil', 'path' => 'M20 21a8 8 0 0 0-16 0M12 13a5 5 0 1 0 0-10 5 5 0 0 0 0 10z'],
    ];

    if (auth()->user()?->isAdmin()) {
        $items[] = ['route' => 'users.index', 'active' => ['users.*', 'categories.*'], 'label' => 'Admin', 'path' => 'M16 21v-2a4 4 0 0 0-8 0v2M12 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM21 21v-2a3 3 0 0 0-2-2.83M3 21v-2a3 3 0 0 1 2-2.83'];
    }
@endphp

<nav class="fixed inset-x-0 bottom-0 z-40 border-t border-slate-200 bg-white/95 backdrop-blur">
    <div class="mx-auto grid max-w-xl gap-1 px-1 py-2 {{ count($items) === 6 ? 'grid-cols-6' : 'grid-cols-5' }}">
        @foreach ($items as $item)
            @php($active = request()->routeIs(...$item['active']))
            <a href="{{ route($item['route']) }}" class="flex min-h-14 min-w-0 flex-col items-center justify-center rounded-xl px-1 text-[11px] font-bold sm:text-xs {{ $active ? 'bg-slate-900 text-white' : 'text-slate-500' }}">
                <svg class="mb-1 h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="{{ $item['path'] }}" />
                </svg>
                <span class="max-w-full truncate">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </div>
</nav>
