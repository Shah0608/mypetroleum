<x-role-dashboard-layout
    role="syarikat"
    title="SENARAI LAPORAN"
    subtitle="Senarai laporan yang dihantar oleh syarikat."
    :nav-items="[
        ['label' => 'My Petroleum Syarikat', 'url' => route('syarikat.utama'), 'route' => 'syarikat.utama', 'active' => '/syarikat/utama'],
        ['label' => 'Permohonan', 'url' => route('syarikat.permohonan-58a'), 'route' => 'syarikat.permohonan-58a', 'active' => '/syarikat/permohonan-58a'],
        ['label' => 'Senarai Permohonan', 'url' => route('syarikat.senaraipermohonan'), 'route' => 'syarikat.senaraipermohonan', 'active' => '/syarikat/senaraipermohonan'],
        ['label' => 'Laporan CJ(P)', 'url' => route('syarikat.laporan-cj'), 'route' => 'syarikat.laporan-cj', 'active' => '/syarikat/laporan-cj'],
        ['label' => 'Senarai Laporan CJ(P)', 'url' => route('syarikat.senarailaporan'), 'route' => 'syarikat.senarailaporan', 'active' => '/syarikat/senarailaporan'],
    ]"
>
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-lg shadow-slate-950/10">
            <!-- Tajuk Bahagian (Sama seperti paparan visual) -->
            <div class="border-b border-slate-100 pb-4 mb-6">
                <h2 class="text-xl font-bold text-slate-900">
                    Senarai Laporan CJ(P)
                </h2>
            </div>

            <!-- Bar Carian / Filter (Format: Cari Nama Syarikat / Negeri / Tahun / Bulan) -->
            <div class="mb-6 max-w-4xl">
                <div class="flex items-center rounded-lg border border-slate-300 bg-white shadow-sm overflow-hidden">
                    <span class="bg-slate-100 px-4 py-2.5 text-sm font-semibold text-slate-600 border-r border-slate-300 whitespace-nowrap">
                        Cari Nama Syarikat /
                    </span>
                    <input 
                        type="text" 
                        placeholder="Negeri / Tahun / Bulan" 
                        class="w-full pl-4 pr-10 py-2.5 text-sm focus:outline-none"
                    />
                    <div class="flex items-center pr-3 text-slate-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Kontena Jadual Mengikut Struktur Gambar Rajah -->
            <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
                <table class="w-full min-w-[800px] border-collapse text-left text-sm text-slate-600">
                    <thead>
                        <tr class="bg-slate-100 font-semibold text-slate-700 uppercase text-xs border-b border-slate-200">
                            <th class="border-r border-slate-200 p-3 w-1/5 text-center">Negeri</th>
                            <th class="border-r border-slate-200 p-3 w-2/5">Nama Syarikat</th>
                            <th class="border-r border-slate-200 p-3 w-1/5 text-center">Tahun</th>
                            <th class="border-r border-slate-200 p-3 w-1/5 text-center">Bulan</th>
                            <th class="p-3 text-center w-1/5">
                                <div>Laporan CJ(P)</div>
                                <div class="text-[10px] text-slate-500 lowercase font-normal">Link pdf</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @if(request('submitted') == 'true')
                            <!-- Data yang diisi dinamik dari permohonan dipaparkan di sini -->
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="border-r border-slate-200 p-3 text-center font-medium">
                                    {{ request('negeri', 'Melaka') }}
                                </td>
                                <td class="border-r border-slate-200 p-3 font-semibold text-slate-900">
                                    {{ request('nama_syarikat', 'Atifa') }}
                                </td>
                                <td class="border-r border-slate-200 p-3 text-center">
                                    {{ request('tahun', '2026') }}
                                </td>
                                <td class="border-r border-slate-200 p-3 text-center">
                                    {{ request('bulan', 'Julai') }}
                                </td>
                                <td class="p-3 text-center">
                                    <!-- Butang Muat Turun Sijil PDF Merah -->
                                    <button type="button" class="inline-flex items-center rounded-md bg-red-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-red-500 transition">
                                        <svg class="mr-1 h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        pdf
                                    </button>
                                </td>
                            </tr>
                        @else
                            <!-- Paparan Jadual Kosong Sekiranya Belum Ada Penghantaran Borang -->
                            <tr>
                                <td colspan="5" class="p-8 text-center text-sm text-slate-400 italic">
                                    Tiada rekod laporan dijumpai. Sila hantar laporan CJ(P) terlebih dahulu.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-role-dashboard-layout>