<x-role-dashboard-layout
    role="syarikat"
    title="LAPORAN CJ(P)"
    subtitle="Laporan Cukai Jualan untuk syarikat."
    :nav-items="[
        ['label' => 'UTAMA', 'url' => route('syarikat.utama'), 'route' => 'syarikat.utama', 'active' => '/syarikat/utama'],
        ['label' => 'PERMOHONAN', 'url' => route('syarikat.permohonan-58a'), 'route' => 'syarikat.permohonan-58a', 'active' => '/syarikat/permohonan-58a'],
        ['label' => 'SENARAI PERMOHONAN', 'url' => route('syarikat.senaraipermohonan'), 'route' => 'syarikat.senaraipermohonan', 'active' => '/syarikat/senaraipermohonan'],
        ['label' => 'LAPORAN CJ(P)', 'url' => route('syarikat.laporan-cj'), 'route' => 'syarikat.laporan-cj', 'active' => '/syarikat/laporan-cj'],
        ['label' => 'SENARAI LAPORAN CJ(P)', 'url' => route('syarikat.senarailaporan'), 'route' => 'syarikat.senarailaporan', 'active' => '/syarikat/senarailaporan'],
    ]"
>
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-lg shadow-slate-950/10">
            <!-- Tajuk Utama Borang -->
            <h2 class="mb-6 text-xl font-bold text-slate-900 border-b border-slate-100 pb-4">
                Laporan CJ(P)
            </h2>

            @if (session('success'))
                <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('syarikat.laporan-cj.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Grid untuk input berlabel bersebelahan -->
                <div class="grid gap-6 md:grid-cols-2">
                    
                    <!-- Ruangan Negeri -->
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <label class="w-full sm:w-1/3 text-sm font-semibold text-slate-700 bg-slate-100 px-3 py-2 rounded-lg border border-slate-200">
                            Negeri
                        </label>
                        <select name="negeri" class="w-full sm:w-2/3 rounded-lg border border-slate-300 px-3 py-2 focus:border-blue-500 focus:outline-none" required>
                            <option value="">Sila Pilih Negeri</option>
                            <option value="Melaka">Melaka</option>
                            <option value="Negeri Sembilan">Negeri Sembilan</option>
                            <option value="WPKL">WPKL</option>
                            <option value="Putrajaya">Putrajaya</option>
                            <option value="Semua Negeri">Semua Negeri</option>
                        </select>
                    </div>

                    <!-- Ruangan Nama Syarikat -->
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <label class="w-full sm:w-1/3 text-sm font-semibold text-slate-700 bg-slate-100 px-3 py-2 rounded-lg border border-slate-200">
                            Nama Syarikat
                        </label>
                        <input 
                            type="text" 
                            name="nama_syarikat"
                            value="" 
                            class="w-full sm:w-2/3 rounded-lg border border-slate-300 px-3 py-2 focus:border-blue-500 focus:outline-none" 
                            required
                        />
                    </div>

                    <!-- Ruangan Tahun -->
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <label class="w-full sm:w-1/3 text-sm font-semibold text-slate-700 bg-slate-100 px-3 py-2 rounded-lg border border-slate-200">
                            Tahun
                        </label>
                        <select name="tahun" class="w-full sm:w-2/3 rounded-lg border border-slate-300 px-3 py-2 focus:border-blue-500 focus:outline-none" required>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                        </select>
                    </div>

                    <!-- Ruangan Bulan -->
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <label class="w-full sm:w-1/3 text-sm font-semibold text-slate-700 bg-slate-100 px-3 py-2 rounded-lg border border-slate-200">
                            Bulan
                        </label>
                        <select name="bulan" class="w-full sm:w-2/3 rounded-lg border border-slate-300 px-3 py-2 focus:border-blue-500 focus:outline-none" required>
                            <option value="Januari">Januari</option>
                            <option value="Februari">Februari</option>
                            <option value="Mac">Mac</option>
                            <option value="April">April</option>
                            <option value="Mei">Mei</option>
                            <option value="Jun">Jun</option>
                            <option value="Julai">Julai</option>
                            <option value="Ogos">Ogos</option>
                            <option value="September">September</option>
                            <option value="Oktober">Oktober</option>
                            <option value="November">November</option>
                            <option value="Disember">Disember</option>
                        </select>
                    </div>

                </div>

                <!-- Bahagian Muat Naik Fail -->
                <div class="mt-6">
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Muat naik Fail Berkaitan (Laporan CJ(P))
                    </label>
                    <div class="rounded-lg border border-dashed border-slate-300 bg-slate-50 p-4">
                        <input type="file" name="fail" accept="application/pdf" class="block w-full text-sm text-slate-600 focus:outline-none" />
                        <p class="mt-2 text-xs text-slate-500">Pilih fail laporan yang berkaitan untuk dihantar.</p>
                        @error('fail')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-4 flex justify-start">
                    <button 
                        type="submit" 
                        class="rounded-lg bg-emerald-600 px-8 py-2.5 font-semibold text-white transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
                    >
                        Hantar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-role-dashboard-layout>
