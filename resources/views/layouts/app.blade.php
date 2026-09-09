<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PP Check') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="pp-shell pb-24">
            <header class="pp-container pt-5 text-white">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <a href="{{ route('dashboard') }}" class="flex min-w-0 items-center gap-3">
                        <div class="grid h-11 w-11 shrink-0 place-items-center rounded-2xl border border-white/15 bg-white/10 font-black">PP</div>
                        <div class="min-w-0">
                            <p class="truncate text-sm font-black leading-none">PP PRODUÇÕES</p>
                            <p class="truncate text-xs text-white/65">Gestão Operacional</p>
                        </div>
                    </a>
                    <div class="flex min-w-0 items-center gap-2">
                        <a href="{{ route('profile.edit') }}" class="max-w-32 truncate rounded-full bg-white/10 px-3 py-2 text-sm font-bold text-white sm:max-w-none">{{ auth()->user()->name }}</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="inline-flex min-h-10 items-center justify-center rounded-full border border-white/15 bg-white px-4 text-sm font-black text-slate-950 shadow-sm">
                                Sair
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            @isset($header)
                <section class="pp-container pt-7 text-white">
                    {{ $header }}
                </section>
            @endisset

            @if (session('status'))
                <div class="pp-container pt-4">
                    <div class="rounded-xl border border-teal-200 bg-teal-50 px-4 py-3 text-sm font-semibold text-teal-800">{{ session('status') }}</div>
                </div>
            @endif

            <main class="pp-container py-6">
                {{ $slot }}
            </main>

            <x-app.bottom-navigation />
        </div>
    </body>
</html>
