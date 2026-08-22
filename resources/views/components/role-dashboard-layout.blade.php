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
    $roleValue = $currentUser?->role ?: $role;
    $displayName = $roleValue === 'syarikat'
        ? ($currentUser?->nama_syarikat ?: $currentUser?->name ?: $currentUser?->login_id ?: 'Pengguna')
        : ($currentUser?->name ?: $currentUser?->login_id ?: 'Pengguna');
    $roleLabel = $currentUser?->roleLabel() ?? match ($roleValue) {
        'syarikat' => 'Pemohon',
        'jkdm' => 'Pegawai Verifikasi',
        'ketua_unit_jkdm' => 'Pegawai Penyokong',
        'pelulus' => 'Pegawai Pelulus',
        'admin' => 'Admin',
        default => ucfirst(str_replace('_', ' ', $roleValue)),
    };
    $identityLabel = $role === 'syarikat' ? 'Pemohon:' : 'Pengguna:';
    $showBrandLabel = ! in_array($role, ['syarikat', 'admin', 'jkdm', 'pelulus', 'ketua'], true);
    $avatarUrl = $currentUser?->avatarUrl() ?? asset('images/default-user-avatar.png');
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        (() => {
            const storageKey = 'mypetroleum-theme';
            const storedTheme = localStorage.getItem(storageKey);
            const preferredTheme = storedTheme ?? (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');

            document.documentElement.classList.toggle('dark', preferredTheme === 'dark');
        })();
    </script>
    <title>{{ config('app.name', 'MyPetroleum') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-100 text-slate-900 dark:bg-slate-950 dark:text-slate-100">
<div class="min-h-screen bg-sky-700 text-slate-900 transition-colors duration-300 dark:bg-slate-950 dark:text-slate-100">
    <div class="border-b border-black bg-black text-white shadow-lg" style="background-color: #000000;">
            <div class="mx-auto flex max-w-[1200px] items-center justify-between gap-4 px-4 py-2 sm:px-6 lg:px-8">
                <div class="flex items-center gap-3">
                    @if ($showBrandLabel)
                        <div class="text-2xl font-semibold tracking-tight">{{ $brandLabel }}</div>
                    @endif
                    <button
                        type="button"
                        data-theme-toggle
                        class="inline-flex items-center gap-2 rounded-full bg-slate-700 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-white shadow-md transition hover:bg-slate-600"
                        aria-label="Tukar mod tema"
                    >
                        <span data-theme-icon>☀</span>
                        <span data-theme-label>Light</span>
                    </button>
                </div>

                <nav class="relative flex flex-1 min-w-0 items-center justify-center py-1">
                    <div class="flex min-w-0 items-center justify-center gap-2 overflow-x-auto whitespace-nowrap text-sm sm:gap-3 lg:gap-4">
                        @foreach ($navItems as $item)
                            @if (($item['type'] ?? 'link') === 'dropdown')
                                <div class="relative shrink-0" x-data="{ open: false }" @click.outside="open = false">
                                @php
                                    $isActive = collect($item['items'] ?? [])->contains(function (array $child): bool {
                                        return isset($child['route'])
                                            ? request()->routeIs($child['route'])
                                            : request()->is(ltrim($child['active'] ?? '', '/'));
                                    });
                                @endphp
                                <button
                                    type="button"
                                    @click="open = !open"
                                    class="{{ $isActive ? 'bg-sky-700 text-white shadow-md shadow-sky-900/20 ring-2 ring-white/70' : 'bg-sky-600 text-white shadow-md shadow-sky-900/20 hover:bg-sky-500' }} inline-flex items-center gap-2 rounded-full px-2 py-1.5 font-semibold uppercase tracking-wide transition sm:px-3 sm:py-2"
                                >
                                    {{ $item['label'] }}
                                    <svg class="h-4 w-4 transition" :class="open ? 'rotate-180' : ''" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.943l3.71-3.712a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0l-4.24-4.24a.75.75 0 01.02-1.06z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>

                                    <div
                                        x-show="open"
                                        x-transition
                                        class="absolute left-1/2 top-full z-50 mt-2 w-56 -translate-x-1/2 rounded-2xl border border-slate-200 bg-white p-2 shadow-xl shadow-slate-900/15"
                                    >
                                        @foreach ($item['items'] ?? [] as $child)
                                            @php
                                                $childActive = isset($child['route'])
                                                    ? request()->routeIs($child['route'])
                                                    : request()->is(ltrim($child['active'] ?? '', '/'));
                                            @endphp
                                            <a
                                                href="{{ $child['url'] }}"
                                                class="{{ $childActive ? 'bg-sky-700 text-white' : 'text-slate-700 hover:bg-slate-100' }} block rounded-xl px-4 py-2 text-sm font-semibold transition"
                                            >
                                                {{ $child['label'] }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
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
                            @endif
                        @endforeach
                    </div>
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
            <section class="rounded-3xl bg-sky-700 px-3 py-3 text-white transition-colors duration-300 dark:bg-slate-900">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:gap-6">
                    <div class="flex items-center">
                        <img
                            src="{{ asset('images/double_logo.png') }}"
                            alt="Logo Kastam Diraja Malaysia dan MyPetroleum"
                            class="h-32 w-auto shrink-0 object-contain sm:h-15 lg:h-15"
                        />
                    </div>

                    <div class="flex flex-1 flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div class="min-w-0">
                            <h1 class="text-3xl font-bold leading-tight text-white drop-shadow sm:text-5xl">Sistem MyPetroleum </h1>
                            <p class="mt-3 text-sm italic text-sky-100 sm:mt-4 sm:text-lg">{{ $subtitle ?: 'Sistem Maklumat Bunker Petroleum' }}</p>
                        </div>

                        <div class="w-full max-w-sm rounded-2xl border border-white/20 bg-white/15 px-4 py-3 text-white shadow-lg shadow-slate-950/15 backdrop-blur-sm sm:w-fit">
                            <form
                                method="POST"
                                action="{{ route('profile.update') }}"
                                enctype="multipart/form-data"
                                class="flex items-center gap-4"
                            >
                                @csrf
                                @method('PATCH')

                                <div class="relative group shrink-0">
                                    <label for="header-avatar" class="block cursor-pointer">
                                        <img
                                            id="header-avatar-preview"
                                            src="{{ $avatarUrl }}"
                                            alt="Avatar pengguna"
                                            class="h-20 w-20 rounded-full border-2 border-white/70 object-cover shadow-md transition duration-200 group-hover:scale-105"
                                        >
                                    </label>
                                    <label
                                        for="header-avatar"
                                        class="absolute inset-0 flex cursor-pointer items-center justify-center rounded-full bg-black/0 text-center text-[11px] font-semibold leading-tight text-white opacity-0 transition group-hover:bg-black/55 group-hover:opacity-100"
                                    >
                                        Hover untuk<br>tukar gambar
                                    </label>
                                    <input
                                        id="header-avatar"
                                        name="avatar"
                                        type="file"
                                        accept="image/*"
                                        class="hidden"
                                        onchange="
                                            (async () => {
                                                const input = this;
                                                const [file] = input.files || [];
                                                const preview = document.getElementById('header-avatar-preview');

                                                if (!file || !preview) {
                                                    return;
                                                }

                                                const objectUrl = URL.createObjectURL(file);
                                                preview.src = objectUrl;

                                                const formData = new FormData(input.form);

                                                try {
                                                    const response = await fetch(input.form.action, {
                                                        method: 'POST',
                                                        headers: {
                                                            'X-HTTP-Method-Override': 'PATCH',
                                                            'X-Requested-With': 'XMLHttpRequest',
                                                            'Accept': 'application/json',
                                                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content ?? '',
                                                        },
                                                        body: formData,
                                                    });

                                                    const data = await response.json();

                                                    if (!response.ok) {
                                                        throw data;
                                                    }

                                                    if (data.avatar_url) {
                                                        preview.src = data.avatar_url;
                                                    }
                                                } catch (error) {
                                                    preview.src = @js($avatarUrl);
                                                } finally {
                                                    URL.revokeObjectURL(objectUrl);
                                                    input.value = '';
                                                }
                                            })();
                                        "
                                    >
                                </div>

                                <div class="min-w-0 space-y-1 text-left sm:text-right">
                                    <div class="text-sm font-bold tracking-wide text-sky-50">
                                        {{ $identityLabel }}
                                    </div>
                                    <div class="text-base font-bold sm:text-lg">
                                        {{ $displayName }}
                                    </div>
                                    <div class="text-sm font-bold tracking-wide text-sky-50">
                                        Level:
                                    </div>
                                    <div class="text-sm font-bold tracking-wide text-sky-50">
                                        {{ $roleLabel }}
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

            <section class="mt-6 rounded-2xl border border-slate-300 bg-white px-5 py-8 shadow-lg shadow-slate-950/15 transition-colors duration-300 dark:border-slate-800 dark:bg-slate-900 sm:px-6 lg:px-8">
                <div class="space-y-6 text-[17px] leading-8 text-slate-900 dark:text-slate-100">
                    {{ $slot }}
                </div>
            </section>


            <footer class="mt-6 bg-slate-900 py-4 text-center text-sm text-white/90">
                Hakcipta Terpelihara © Jabatan Kastam Diraja Malaysia 2026
            </footer>
        </main>
    </div>
    <script>
        (() => {
            const storageKey = 'mypetroleum-theme';
            const toggle = document.querySelector('[data-theme-toggle]');
            const icon = document.querySelector('[data-theme-icon]');
            const label = document.querySelector('[data-theme-label]');

            if (!toggle || !icon || !label) {
                return;
            }

            const sync = () => {
                const isDark = document.documentElement.classList.contains('dark');
                icon.textContent = isDark ? '☾' : '☀';
                label.textContent = isDark ? 'Dark' : 'Light';
            };

            toggle.addEventListener('click', () => {
                const isDark = document.documentElement.classList.toggle('dark');
                localStorage.setItem(storageKey, isDark ? 'dark' : 'light');
                sync();
            });

            sync();
        })();
    </script>
</body>
</html>
