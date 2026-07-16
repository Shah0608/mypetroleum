<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script src="https://cdn.tailwindcss.com"></script>
            <style>
                body {
                    font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
                }
            </style>
        @endif
    </head>
    <body class="bg-[#f4f4f3] min-h-screen p-6 flex flex-col justify-center items-center">
        
        <!-- Main Container -->
        <div class="bg-white shadow-lg border border-gray-200 max-w-5xl w-full">
            
            <!-- Main Content -->
            <div class="p-6 flex flex-col gap-6">
                
                <!-- Top Header Row & Navigation Container -->
                <div class="flex flex-col gap-4 border-b pb-4">
                    
                    <!-- Header Title + Logos Block (As requested from photo) -->
                    <div class="flex items-center gap-3 justify-center">
                        <img src="{{ asset('images/kastam-diraja-malaysia-seeklogo.png') }}" alt="Logo Kastam" class="h-14 w-auto object-contain">
                        
                        <div class="border border-sky-900 p-2 bg-white">
                            <div class="flex flex-col text-center">
                                <h1 class="text-md font-bold text-sky-900 leading-tight">MyPetroleum JKDM</h1>
                                <p class="text-xs font-semibold text-gray-600 leading-tight">Sistem Maklumat Bunker Petroleum</p>
                            </div>
                        </div>

                        <img src="{{ asset('images/logo_mypetroleum-removebg-preview.png') }}" alt="Logo MyPetroleum" class="h-14 w-auto object-contain">
                    </div>

                    <!-- Navigation Tabs (Blue buttons below logos) -->
                    <div class="flex flex-wrap gap-2 text-xs justify-center">
                        <a href="{{ url('/') }}" class="rounded-full bg-sky-400 px-4 py-2 font-semibold text-slate-950 shadow-sm shadow-sky-200/50 transition hover:bg-sky-300">Utama</a>
                        <a href="{{ url('/about') }}" class="rounded-full bg-sky-100 px-4 py-2 font-semibold text-sky-900 transition hover:bg-sky-300 hover:text-slate-950">Mengenal MyPetroleum</a>
                        <a href="{{ url('/panduan-58a') }}" class="rounded-full bg-sky-100 px-4 py-2 font-semibold text-sky-900 transition hover:bg-sky-300 hover:text-slate-950">Panduan Butiran 58 A</a>
                        <a href="{{ url('/contact') }}" class="rounded-full bg-sky-100 px-4 py-2 font-semibold text-sky-900 transition hover:bg-sky-300 hover:text-slate-950">Hubungi Kami</a>
                        <a href="{{ url('/manual') }}" class="rounded-full bg-sky-100 px-4 py-2 font-semibold text-sky-900 transition hover:bg-sky-300 hover:text-slate-950">Manual Pengguna</a>
                        <a href="{{ route('login') }}" class="rounded-full bg-sky-100 px-4 py-2 font-semibold text-sky-900 transition hover:bg-sky-300 hover:text-slate-950">Daftar Masuk MyPetroleum</a>
                    </div>
                </div>

                <!-- Middle Hero & Content Section -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <!-- Main Harbor Image Box (Spans 2 columns) -->
                    <div class="md:col-span-2 border border-gray-300 p-1 bg-white">
                        <!-- Using local image from images folder -->
                        <img src="{{ asset('images/gambar terminal.png') }}" alt="Bunker Petroleum Terminal" class="w-full h-64 object-cover">
                    </div>

                    <!-- Informational Paragraphs Column -->
                    <div class="text-xs text-gray-700 flex flex-col gap-4 text-justify leading-relaxed">
                        <p>
                            <strong>MyPetroleum JKDM</strong> - Sistem Maklumat Bunker Petroleum. Laman ini dibangunkan sebagai satu platform kepada mana-mana orang yang diluluskan untuk menjalankan perkhidmatan bunkering di bawah Akta Kemajuan Petroleum 1974 memohon kelulusan pengecualian cukai jualan di bawah Butiran 58 A Perintah Cukai Jualan (Orang Yang Dikecualikan Daripada Pembayaran Cukai) 2018.
                        </p>
                        <p class="border-t pt-2">
                            Bunkering adalah kegiatan menyalurkan apa-apa jenis bahan api (produk petroleum) untuk menggerakkan/ kegunaan enjin kapal di dalam had pelabuhan atau jeti yang diberi kebenaran oleh Jabatan Kastam Diraja Malaysia.
                        </p>
                    </div>
            </div>

            <!-- Pautan Agensi Section -->
            <div class="w-full p-6 text-gray-700 border-t border-gray-300">
                <h3 class="text-sm font-bold tracking-wider uppercase mb-4 text-center border-b border-gray-300 pb-2">Pautan Agensi</h3>
                
                <!-- Agency Links with Logos -->
                <div class="flex flex-wrap gap-6 items-center justify-center mt-4">
                    <a href="https://www.customs.gov.my" target="_blank" class="flex flex-col items-center gap-1 hover:opacity-60">
                        <img src="{{ asset('images/kastam-diraja-malaysia-seeklogo.png') }}" alt="JKDM" class="h-12 w-auto">
                        <span class="text-xs font-medium">Portal Rasmi JKDM</span>
                    </a>
                    
                    <a href="https://www.kpdn.gov.my" target="_blank" class="flex flex-col items-center gap-1 hover:opacity-60">
                        <img src="{{ asset('images/kpdn.png') }}" alt="KPDN" class="h-12 w-auto">
                        <span class="text-[11px] font-medium leading-tight">Kementerian Perdagangan Dalam Negeri<br>dan Kos Sara Hidup</span>
                    </a>
                </div>
            </div>

            <!-- Footer - Copyright -->
            <div class="w-full bg-[#748c41] p-6 text-white border-t border-gray-300">
                <!-- Footer Copyright & Guidelines Notes at bottom -->
                <div class="text-[10px] text-white/80 space-y-2 text-center">
                    <p>Sesuai dipapar menggunakan pelayar internet versi terkini dengan resolusi paparan 1280 x 800</p>
                </div>
            </div>
        </div>
    </body>
</html>