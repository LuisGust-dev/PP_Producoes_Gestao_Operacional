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
    <body class="font-sans text-gray-900 antialiased">
        <div class="flex min-h-screen flex-col items-center justify-center bg-slate-950 px-4 py-8">
            <div class="mb-6 text-center text-white">
                <a href="/" class="mx-auto grid h-16 w-16 place-items-center rounded-2xl border border-white/15 bg-white/10 text-xl font-black">
                    PP
                </a>
                <p class="mt-3 text-sm font-black">PP PRODUÇÕES</p>
                <p class="text-xs text-white/60">Gestão Operacional</p>
            </div>

            <div class="w-full max-w-md overflow-hidden rounded-2xl bg-white px-5 py-5 shadow-2xl sm:px-6">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
