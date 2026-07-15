<x-role-dashboard-layout
    role="syarikat"
    title="SENARAI PERMOHONAN"
    subtitle="Senarai permohonan syarikat/pemilik."
    :nav-items="[
         ['label' => 'My Petroleum Syarikat', 'url' => route('syarikat.utama'), 'route' => 'syarikat.utama', 'active' => '/syarikat/utama'],
        ['label' => 'Permohonan', 'url' => route('syarikat.permohonan-58a'), 'route' => 'syarikat.permohonan-58a', 'active' => '/syarikat/permohonan-58a'],
        ['label' => 'Senarai Permohonan', 'url' => route('syarikat.senaraipermohonan'), 'route' => 'syarikat.senaraipermohonan', 'active' => '/syarikat/senaraipermohonan'],
        ['label' => 'Laporan CJ(P)', 'url' => route('syarikat.laporan-cj'), 'route' => 'syarikat.laporan-cj', 'active' => '/syarikat/laporan-cj'],
        ['label' => 'Senarai Laporan CJ(P)', 'url' => route('syarikat.senarailaporan'), 'route' => 'syarikat.senarailaporan', 'active' => '/syarikat/senarailaporan'],
    ]"
>
    <div class="space-y-6">
        <!-- Pengecualian Butiran 58A Header Seksyen -->
        <div class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-lg shadow-slate-950/10">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-b border-slate-100 pb-4 mb-6">
                <h2 class="text-xl font-bold text-slate-900">
                    Senarai Permohonan: <span class="text-blue-600">Pengecualian Butiran 58A</span>
                </h2>
                <!-- Butang Kembali di sebelah kanan atas -->
                <a href="{{ route('syarikat.permohonan-58a') }}" class="mt-2 sm:mt-0 inline-flex items-center rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-green-700">
                    Kembali
                </a>
            </div>

            <!-- Bar Carian / Filter -->
            <div class="mb-6 max-w-2xl">
                <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-slate-500">Cari Nama Syarikat / Negeri / Kawasan / Status / No Sijil / Tarikh</label>
                <div class="relative">
                    <input 
                        type="text" 
                        placeholder="Masukkan kata kunci carian..." 
                        class="w-full rounded-xl border border-slate-300 bg-slate-50/50 pl-4 pr-10 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:outline-none"
                    />
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Kontena Jadual Responsif Luas -->
            <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
                <table class="w-full min-w-[1200px] border-collapse text-left text-sm text-slate-600">
                    <thead>
                        <tr class="bg-slate-100 font-semibold text-slate-700 uppercase text-xs border-b border-slate-200">
                            <th class="border-r border-slate-200 p-3">Tarikh Permohonan</th>
                            <th class="border-r border-slate-200 p-3">Negeri</th>
                            <th class="border-r border-slate-200 p-3">Nama Syarikat</th>
                            <th class="border-r border-slate-200 p-3">Perihal Barangan</th>
                            <th class="border-r border-slate-200 p-3">Unit</th>
                            <th class="border-r border-slate-200 p-3">Kuantiti</th>
                            <th class="border-r border-slate-200 p-3">Kawasan</th>
                            
                            <th class="border-r border-slate-200 p-3 bg-blue-50 text-blue-900">Status</th>
                            <th class="border-r border-slate-200 p-3 bg-blue-50 text-blue-900">No. Sijil Pengecualian</th>
                            <th class="border-r border-slate-200 p-3 bg-blue-50 text-blue-900">Tarikh Diluluskan</th>
                            <th class="border-r border-slate-200 p-3 bg-blue-50 text-blue-900">Tarikh Tamat</th>
                            <th class="p-3 bg-blue-50 text-blue-900 text-center">Sijil Pengecualian</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @if(request('submitted') == 'true')
                            <!-- Baris Data Contoh yang hanya keluar SELEPAS klik Hantar -->
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="border-r border-slate-200 p-3">14/07/2026</td>
                                <td class="border-r border-slate-200 p-3">Melaka</td>
                                <td class="border-r border-slate-200 p-3 font-medium text-slate-900">Atifa Petroleum Sdn Bhd</td>
                                <td class="border-r border-slate-200 p-3">Minyak Diesel / Petroleum bersiap</td>
                                <td class="border-r border-slate-200 p-3">Litre</td>
                                <td class="border-r border-slate-200 p-3">50,000</td>
                                <td class="border-r border-slate-200 p-3">Tanjung Bruas</td>
                                
                                <td class="border-r border-slate-200 p-3 bg-blue-50/30">
                                    <span class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                        LULUS
                                    </span>
                                </td>
                                <td class="border-r border-slate-200 p-3 bg-blue-50/30 font-mono text-xs">CJP/58A/MEL/2026/0042</td>
                                <td class="border-r border-slate-200 p-3 bg-blue-50/30">14/07/2026</td>
                                <td class="border-r border-slate-200 p-3 bg-blue-50/30">13/07/2027</td>
                                <td class="p-3 bg-blue-50/30 text-center">
                                    <button type="button" class="inline-flex items-center rounded-md bg-red-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-red-500 transition">
                                        <svg class="mr-1 h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        pdf
                                    </button>
                                </td>
                            </tr>
                        @else
                            <!-- Jadual Kosong / Tiada Rekod jika user terus klik menu Senarai Permohonan -->
                            <tr>
                                <td colspan="12" class="p-8 text-center text-sm text-slate-400 italic">
                                    Tiada rekod permohonan dijumpai. Sila hantar borang permohonan terlebih dahulu.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-role-dashboard-layout>