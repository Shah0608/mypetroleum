<x-role-dashboard-layout
    role="jkdm"
    title="SENARAI LAPORAN"
    subtitle="Sistem Maklumat Bunker Petroleum"
    :nav-items="[
        ['label' => 'UTAMA', 'url' => route('jkdm.utama'), 'active' => '/jkdm/utama'],
        ['label' => 'SENARAI LAPORAN', 'url' => route('jkdm.senarailaporan'), 'active' => '/jkdm/senarailaporan'],
        ['label' => 'SENARAI PERMOHONAN', 'url' => route('jkdm.senaraipermohonan'), 'active' => '/jkdm/senaraipermohonan'],
    ]"
>
    <div class="rounded-2xl bg-white/95 p-6 shadow-lg shadow-slate-950/10">
        <div class="mb-5 flex flex-col gap-3 border-b border-slate-100 pb-4 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-xl font-bold text-slate-900">Senarai Laporan CJ(P) Jadual A-58A</h2>
            <a href="{{ route('jkdm.senarailaporan.export') }}" class="inline-flex items-center justify-center rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-green-700">
                Muat Turun Excel
            </a>
        </div>

        <form method="GET" action="{{ route('jkdm.senarailaporan') }}" class="mb-6 max-w-4xl">
            <div class="flex items-center overflow-hidden rounded-xl border border-slate-300 bg-white shadow-sm">
                <span class="whitespace-nowrap border-r border-slate-300 bg-slate-100 px-4 py-2.5 text-sm font-semibold text-slate-600">
                    Cari Nama Syarikat /
                </span>
                <input
                    type="text"
                    name="q"
                    value="{{ $query ?? request('q') }}"
                    placeholder="Negeri / Tahun / Bulan"
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
            <table class="w-full min-w-[800px] border-collapse text-sm text-slate-700">
                <thead class="bg-slate-100 text-left text-xs uppercase text-slate-700">
                    <tr>
                        <th class="border-r border-slate-200 p-3">Negeri</th>
                        <th class="border-r border-slate-200 p-3 text-center">Tahun</th>
                        <th class="border-r border-slate-200 p-3 text-center">Bulan</th>
                        <th class="border-r border-slate-200 p-3">No. Sijil Pengecualian</th>
                        <th class="border-r border-slate-200 p-3 text-right">Kuantiti Diluluskan</th>
                        <th class="border-r border-slate-200 p-3 text-right">Baki Kuantiti Diluluskan</th>
                        <th class="p-3 text-center">Laporan PDF</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($laporans as $laporan)
                        <tr class="hover:bg-slate-50">
                            <td class="border-r border-slate-200 p-3">{{ $laporan->negeri }}</td>
                            <td class="border-r border-slate-200 p-3 text-center">{{ $laporan->tahun }}</td>
                            <td class="border-r border-slate-200 p-3 text-center">{{ $laporan->bulan }}</td>
                            <td class="border-r border-slate-200 p-3">{{ $laporan->no_sijil_pengecualian ?? '-' }}</td>
                            <td class="border-r border-slate-200 p-3 text-right">{{ number_format((float) $laporan->kuantiti_diluluskan, 0, '.', ',') }}</td>
                            <td class="border-r border-slate-200 p-3 text-right">{{ number_format((float) $laporan->baki_kuantiti_diluluskan, 0, '.', ',') }}</td>
                            <td class="p-3 text-center"><button type="button" onclick="openLaporanCjpPreview(@js(route('jkdm.laporan.preview', $laporan)))" class="inline-flex rounded-md bg-red-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-500">pdf</button></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-400">Tiada rekod laporan dijumpai.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @include('partials.laporan-cjp-print-modal', ['modalId' => 'jkdm-laporan-preview-modal', 'frameId' => 'jkdm-laporan-preview-frame'])
</x-role-dashboard-layout>
