<x-role-dashboard-layout
    role="jkdm"
    title="SENARAI PERMOHONAN"
    subtitle="Semakan permohonan oleh pegawai JKDM."
    :nav-items="[
        ['label' => 'UTAMA', 'url' => route('jkdm.utama'), 'active' => '/jkdm/utama'],
        ['label' => 'SENARAI LAPORAN', 'url' => route('jkdm.senarailaporan'), 'active' => '/jkdm/senarailaporan'],
        ['label' => 'SENARAI PERMOHONAN', 'url' => route('jkdm.senaraipermohonan'), 'active' => '/jkdm/senaraipermohonan'],
    ]"
>
    <div class="space-y-6">
        <!-- Pengecualian Butiran 58A Header Seksyen -->
        <div class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-lg shadow-slate-950/10">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-b border-slate-100 pb-4 mb-6">
                <h2 class="text-xl font-bold text-slate-900">
                    Senarai Permohonan: <span class="text-blue-600">Pengecualian Butiran 58A</span>
                </h2>
                <!-- Butang Muat Turun Excel di sebelah kanan atas seperti dalam gambar rajah -->
                <button type="button" class="mt-2 sm:mt-0 inline-flex items-center rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-green-700 shadow-sm">
                    <svg class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Muat Turun Excel
                </button>
            </div>

            <!-- Bar Carian Panjang (Format: Cari Nama Syarikat / Negeri/Kawasan/Status/No Sijil/Tarikh) -->
            <div class="mb-6 max-w-5xl">
                <div class="flex items-center rounded-xl border border-slate-300 bg-white shadow-sm overflow-hidden">
                    <span class="bg-slate-100 px-4 py-2.5 text-xs font-bold uppercase tracking-wider text-slate-600 border-r border-slate-300 whitespace-nowrap">
                        Cari Nama Syarikat /
                    </span>
                    <input 
                        type="text" 
                        placeholder="Negeri/Kawasan/Status/No Sijil/Tarikh" 
                        class="w-full pl-4 pr-10 py-2.5 text-sm focus:outline-none"
                    />
                    <div class="flex items-center pr-3 text-slate-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Kontena Jadual Responsif Luas (Min-width dipanjangkan untuk kolum tambahan) -->
            <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
                <table class="w-full min-w-[1400px] border-collapse text-left text-sm text-slate-600">
                    <thead>
                        <tr class="bg-slate-100 font-semibold text-slate-700 uppercase text-xs border-b border-slate-200">
                            <!-- Maklumat Asal dari Syarikat -->
                            <th class="border-r border-slate-200 p-3">Tarikh Permohonan</th>
                            <th class="border-r border-slate-200 p-3">Negeri</th>
                            <th class="border-r border-slate-200 p-3">Nama Syarikat</th>
                            <th class="border-r border-slate-200 p-3">Perihal Barangan</th>
                            <th class="border-r border-slate-200 p-3 text-center">Unit</th>
                            <th class="border-r border-slate-200 p-3 text-center">Kuantiti</th>
                            <th class="border-r border-slate-200 p-3">Kawasan</th>
                            
                            <!-- Seksyen: Diisi oleh Kastam (Diwarnakan Biru Lembut) -->
                            <th class="border-r border-slate-200 p-3 bg-blue-50 text-blue-900">Status</th>
                            <th class="border-r border-slate-200 p-3 bg-blue-50 text-blue-900">No. Sijil Pengecualian</th>
                            <th class="border-r border-slate-200 p-3 bg-blue-50 text-blue-900">Tarikh Diluluskan</th>
                            <th class="border-r border-slate-200 p-3 bg-blue-50 text-blue-900">Tarikh Tamat</th>
                            <th class="border-r border-slate-200 p-3 bg-blue-50 text-blue-900 text-center">Sijil Pengecualian</th>
                            
                            <!-- Tindakan Pegawai JKDM -->
                            <th class="p-3 text-center bg-slate-100 text-slate-700">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @if(request('submitted') == 'true')
                            <!-- Data dipaparkan selepas user Syarikat klik Hantar -->
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="border-r border-slate-200 p-3">15/07/2026</td>
                                <td class="border-r border-slate-200 p-3">Melaka</td>
                                <td class="border-r border-slate-200 p-3 font-semibold text-slate-900">Atifa Petroleum Sdn Bhd</td>
                                <td class="border-r border-slate-200 p-3">Minyak Diesel / Petroleum bersiap</td>
                                <td class="border-r border-slate-200 p-3 text-center">Litre</td>
                                <td class="border-r border-slate-200 p-3 text-center">50,000</td>
                                <td class="border-r border-slate-200 p-3">Tanjung Bruas</td>
                                
                                <!-- Status Lalai (Dalam Tindakan) seperti gambar rajah -->
                                <td class="border-r border-slate-200 p-3 bg-blue-50/30">
                                    <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-800 ring-1 ring-inset ring-amber-600/20">
                                        Dalam tindakan
                                    </span>
                                </td>
                                <!-- Ruangan kosong menunggu tindakan kelulusan pegawai Kastam -->
                                <td class="border-r border-slate-200 p-3 bg-blue-50/30 font-mono text-xs text-slate-400 italic">- Belum dijana -</td>
                                <td class="border-r border-slate-200 p-3 bg-blue-50/30 text-slate-400 italic">-</td>
                                <td class="border-r border-slate-200 p-3 bg-blue-50/30 text-slate-400 italic">-</td>
                                <td class="border-r border-slate-200 p-3 bg-blue-50/30 text-center">
                                    <button type="button" disabled class="inline-flex items-center rounded-md bg-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-500 cursor-not-allowed shadow-sm">
                                        pdf
                                    </button>
                                </td>
                                
                                <!-- Butang Semak Hijau di hujung untuk kegunaan JKDM -->
                                <td class="p-3 text-center">
                                    <button type="button" class="inline-flex items-center rounded-md bg-green-600 px-4 py-1.5 text-xs font-bold text-white shadow-md hover:bg-green-700 transition uppercase tracking-wider">
                                        semak
                                    </button>
                                </td>
                            </tr>
                        @else
                            <!-- Jadual Kosong sekiranya tiada permohonan baharu dihantar -->
                            <tr>
                                <td colspan="13" class="p-8 text-center text-sm text-slate-400 italic">
                                    Tiada rekod permohonan baharu untuk disemak buat masa ini.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-role-dashboard-layout>