@props([
    'role' => '',
    'brand' => 'MyPetroleum',
    'title' => '',
    'subtitle' => '',
    'navItems' => [],
])

@php
    $brandLabel = trim($brand . ' ' . strtoupper($role));
    $currentUser = auth()->user();
    $displayName = $currentUser?->name ?: $currentUser?->login_id ?: 'Pengguna';
    $roleLabel = strtoupper($currentUser?->role ?: $role);
    $showBrandLabel = ! in_array($role, ['syarikat', 'admin', 'jkdm'], true);
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
        <div class="border-b border-black bg-black text-white shadow-lg" style="background-color: #000000;">
            <div class="mx-auto flex max-w-[1200px] items-center justify-between gap-4 px-4 py-2 sm:px-6 lg:px-8">
                <div class="flex items-center gap-4">
                    @if ($showBrandLabel)
                        <div class="text-2xl font-semibold tracking-tight">{{ $brandLabel }}</div>
                    @endif
                </div>

                <nav class="flex flex-1 min-w-0 items-center justify-center gap-2 overflow-x-auto whitespace-nowrap py-1 text-sm sm:gap-3 lg:gap-4">
                    @foreach ($navItems as $item)
                        @php
                            $isActive = isset($item['route'])
                                ? request()->routeIs($item['route'])
                                : request()->is(ltrim($item['active'], '/'));
                        @endphp
                        <a
                            href="{{ $item['url'] }}"
                            class="{{ $isActive ? 'bg-sky-700 text-white shadow-md shadow-sky-900/20 ring-2 ring-white/70' : 'bg-sky-600 text-white shadow-md shadow-sky-900/20 hover:bg-sky-500' }} rounded-full px-2 py-1.5 font-semibold uppercase tracking-wide transition sm:px-3 sm:py-2"
                        >
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-lg bg-rose-500 px-3 py-2 text-sm font-semibold uppercase tracking-wide text-white shadow-lg shadow-rose-950/30 transition hover:bg-rose-400 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-rose-300 focus:ring-offset-2 focus:ring-offset-slate-900">
                        Log Keluar
                    </button>
                </form>
            </div>
        </div>

        <main class="mx-auto max-w-[1200px] px-4 py-5 sm:px-6 lg:px-8">
            <section class="rounded-3xl bg-sky-700 px-3 py-3 text-white">
                <div class="flex items-start gap-4 sm:gap-6">
                    <img src="{{ asset('images/kastam-diraja-malaysia-seeklogo.png') }}" alt="Logo Kastam Diraja Malaysia" class="h-16 w-16 shrink-0 object-contain sm:h-20 sm:w-20" />
                    <img src="{{ asset('images/logo_mypetroleum-removebg-preview.png') }}" alt="Logo MyPetroleum" class="h-16 w-16 shrink-0 object-contain sm:h-20 sm:w-40" />

                    <div class="flex flex-1 items-start justify-between gap-6 pt-2">
                        <div>
                            <h1 class="text-5xl font-bold leading-tight text-white drop-shadow sm:text-6xl">Sistem MyPetroleum </h1>
                            <p class="mt-1 text-lg italic text-sky-100">{{ $subtitle ?: 'Sistem Maklumat Bunker Petroleum' }}</p>
                        </div>

                        <div class="w-full max-w-sm rounded-2xl border border-white/20 bg-white/15 px-4 py-3 text-white shadow-lg shadow-slate-950/15 backdrop-blur-sm sm:w-fit">
                            <div class="space-y-1 text-right">
                                <div class="text-sm font-semibold tracking-wide text-sky-50">
                                    Pengguna:
                                </div>
                                <div class="text-base font-semibold sm:text-lg">
                                    {{ $displayName }}
                                </div>
                                <div class="text-sm font-semibold  tracking-wide text-sky-50">
                                    Level:
                                </div>
                                <div class="text-sm font-semibold  tracking-wide text-sky-50">
                                    {{ $roleLabel }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="mt-6 rounded-2xl border border-slate-300 bg-white px-5 py-8 shadow-lg shadow-slate-950/15 sm:px-6 lg:px-8">
                <div class="space-y-6 text-[17px] leading-8 text-slate-900">
                    {{ $slot }}
                </div>
            </section>


            <footer class="mt-6 bg-slate-900 py-4 text-center text-sm text-white/90">
                Hakcipta Terpelihara © Jabatan Kastam Diraja Malaysia 2025
            </footer>
        </main>
    </div>
</body>
</html>
