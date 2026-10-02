<x-role-dashboard-layout
    role="ketua"
    title="SENARAI LAPORAN"
    subtitle="Sistem Maklumat Bunker Petroleum"
    :nav-items="[
        ['label' => 'UTAMA', 'url' => route('ketua.utama'), 'active' => '/ketua/utama'],
        ['label' => 'SENARAI LAPORAN', 'url' => route('ketua.senarailaporan'), 'active' => '/ketua/senarailaporan'],
        ['label' => 'SENARAI PERMOHONAN', 'url' => route('ketua.senaraipermohonan'), 'active' => '/ketua/senaraipermohonan'],
    ]"
>
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-lg shadow-slate-950/10">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-b border-slate-100 pb-4 mb-6">
                <h2 class="text-xl font-bold text-slate-900">
                    Senarai Laporan CJ(P) Jadual A-58A</span>
                </h2>
                <span class="mt-2 rounded-lg bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 sm:mt-0">
                    {{ $laporans->count() }} rekod
                </span>
            </div>

            <form method="GET" action="{{ route('ketua.senarailaporan') }}" class="mb-6 max-w-5xl">
                <div class="flex items-center overflow-hidden rounded-xl border border-slate-300 bg-white shadow-sm">
                    <span class="whitespace-nowrap border-r border-slate-300 bg-slate-100 px-4 py-2.5 text-xs font-bold uppercase tracking-wider text-slate-600">
                        Cari Laporan /
                    </span>
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Negeri/Nama Syarikat/Bulan/Tahun"
                        class="w-full px-4 py-2.5 text-sm focus:outline-none"
                    />
                    <button type="submit" class="flex items-center pr-3 text-slate-400" aria-label="Cari">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </form>

            <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
                <table class="w-full min-w-[900px] border-collapse text-left text-sm text-slate-600">
                    <thead>
                        <tr class="bg-slate-100 font-semibold text-slate-700 uppercase text-xs border-b border-slate-200">
                            <th class="border-r border-slate-200 p-3">Negeri</th>
                            <th class="border-r border-slate-200 p-3">Tahun</th>
                            <th class="border-r border-slate-200 p-3">Bulan</th>
                            <th class="border-r border-slate-200 p-3">No. Sijil Pengecualian</th>
                            <th class="border-r border-slate-200 p-3 text-right">Kuantiti Diluluskan</th>
                            <th class="border-r border-slate-200 p-3 text-right">Baki Kuantiti Diluluskan</th>
                            <th class="p-3 text-center">Laporan PDF</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($laporans as $laporan)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="border-r border-slate-200 p-3">{{ $laporan->negeri ?? '-' }}</td>
                                <td class="border-r border-slate-200 p-3">{{ $laporan->tahun ?? '-' }}</td>
                                <td class="border-r border-slate-200 p-3">{{ $laporan->bulan ?? '-' }}</td>
                                <td class="border-r border-slate-200 p-3">{{ $laporan->no_sijil_pengecualian ?? '-' }}</td>
                                <td class="border-r border-slate-200 p-3 text-right">{{ number_format((float) $laporan->kuantiti_diluluskan, 0, '.', ',') }}</td>
                                <td class="border-r border-slate-200 p-3 text-right">{{ number_format((float) $laporan->baki_kuantiti_diluluskan, 0, '.', ',') }}</td>
                                <td class="p-3 text-center"><button type="button" onclick="openLaporanCjpPreview(@js(route('ketua.laporan.preview', $laporan)))" class="inline-flex rounded-md bg-red-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-500">pdf</button></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-sm text-slate-400 italic">
                                    Tiada rekod laporan buat masa ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('partials.laporan-cjp-print-modal', ['modalId' => 'ketua-laporan-preview-modal', 'frameId' => 'ketua-laporan-preview-frame'])
</x-role-dashboard-layout>
