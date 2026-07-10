@props([
    'role' => '',
    'brand' => 'MyPetroleum',
    'title' => '',
    'subtitle' => '',
    'navItems' => [],
])

@php
    $brandLabel = trim($brand . ' ' . strtoupper($role));
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MyPetroleum') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-sky-700 text-slate-900">
        <div class="border-b border-slate-800 bg-slate-900 text-white shadow-lg">
            <div class="mx-auto flex max-w-[1200px] items-center justify-between gap-6 px-4 py-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-4">
                    <div class="text-2xl font-semibold tracking-tight">{{ $brandLabel }}</div>

                    <nav class="hidden items-center gap-6 lg:flex">
                        @foreach ($navItems as $item)
                            <a
                                href="{{ $item['url'] }}"
                                class="{{ request()->is(ltrim($item['active'], '/')) ? 'text-white' : 'text-white/70 hover:text-white' }} text-sm font-semibold uppercase tracking-wide transition"
                            >
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    </nav>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-md border border-white/70 px-4 py-2 text-sm font-medium text-white transition hover:bg-white hover:text-slate-900">
                        Log Keluar
                    </button>
                </form>
            </div>
        </div>

        <main class="mx-auto max-w-[1200px] px-4 py-5 sm:px-6 lg:px-8">
            <section class="rounded-3xl bg-sky-700 px-3 py-3 text-white">
                <div class="flex items-start gap-4 sm:gap-6">
                    <img src="{{ asset('images/kastam-diraja-malaysia-seeklogo.png') }}" alt="Logo Kastam Diraja Malaysia" class="h-16 w-16 shrink-0 object-contain sm:h-20 sm:w-20" />
                    <img src="{{ asset('images/logo_mypetroleum-removebg-preview.png') }}" alt="Logo MyPetroleum" class="h-20 w-20 shrink-0 object-contain sm:h-24 sm:w-24" />

                    <div class="pt-2">
                        <h1 class="text-2xl font-bold leading-tight text-white drop-shadow sm:text-3xl">Sistem MyPetroleum {{ strtoupper($role) }}</h1>
                        <p class="mt-1 text-lg italic text-sky-100">{{ $subtitle ?: 'Sistem Maklumat Bunker Petroleum' }}</p>
                    </div>
                </div>
            </section>

            <section class="mt-6 rounded-2xl border border-slate-300 bg-white px-5 py-8 shadow-lg shadow-slate-950/15 sm:px-6 lg:px-8">
                <div class="space-y-6 text-[17px] leading-8 text-slate-900">
                    {{ $slot }}
                </div>
            </section>

            <section class="mt-4 grid gap-4 md:grid-cols-2">
                @foreach ($navItems as $item)
                    <a href="{{ $item['url'] }}" class="rounded-xl border border-slate-300 bg-sky-100 px-5 py-4 text-center text-[16px] font-medium text-sky-900 shadow-sm transition hover:bg-sky-200">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </section>

            <footer class="mt-6 bg-slate-900 py-4 text-center text-sm text-white/90">
                Hakcipta Terpelihara © Jabatan Kastam Diraja Malaysia 2025
            </footer>
        </main>
    </div>
</body>
</html>
