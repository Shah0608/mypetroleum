<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased bg-slate-950">
        <div class="min-h-screen flex items-center justify-center px-4 py-10 sm:px-6">
            <div class="w-full max-w-lg">
                <div class="overflow-hidden rounded-[32px] border border-white/10 bg-white/95 shadow-2xl shadow-slate-950/20 backdrop-blur-xl">
                    <div class="px-6 py-8 sm:px-10 sm:py-10">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>