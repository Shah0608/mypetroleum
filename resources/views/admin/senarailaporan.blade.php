<x-role-dashboard-layout
    role="admin"
    title="SENARAI LAPORAN"
    subtitle="Sistem Maklumat Bunker Petroleum"
    :nav-items="[
        ['label' => 'UTAMA', 'url' => route('admin.utama'), 'active' => '/admin/utama'],
        ['label' => 'URUS PENGGUNA', 'url' => route('admin.uruspengguna'), 'active' => '/admin/uruspengguna'],
        ['label' => 'TAMBAH PENGGUNA', 'url' => route('admin.tambahpengguna'), 'active' => '/admin/tambahpengguna'],
        ['label' => 'SENARAI LAPORAN', 'url' => route('admin.senarailaporan'), 'active' => '/admin/senarailaporan'],
        ['label' => 'SENARAI PERMOHONAN', 'url' => route('admin.senaraipermohonan'), 'active' => '/admin/senaraipermohonan'],
    ]"
>
    <div class="rounded-2xl bg-white/95 p-6 shadow-lg shadow-slate-950/10">
        <div class="mb-5 flex flex-col gap-3 border-b border-slate-100 pb-4 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-xl font-bold text-slate-900">Senarai Laporan CJ(P) Jadual A-58A</h2>
            <a href="{{ route('admin.senarailaporan.export') }}" class="inline-flex items-center justify-center rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-green-700">
                Muat Turun Excel
            </a>
        </div>

        <form method="GET" action="{{ route('admin.senarailaporan') }}" class="mb-6 max-w-4xl">
            <div class="flex items-center overflow-hidden rounded-lg border border-slate-300 bg-white shadow-sm">
                <span class="whitespace-nowrap border-r border-slate-300 bg-slate-100 px-4 py-2.5 text-sm font-semibold text-slate-600">
                    Cari Nama Syarikat /
                </span>
                <input
                    type="text"
                    name="q"
                    value="{{ $query ?? request('q') }}"
                    placeholder="Negeri / Tahun / Bulan / ID Syarikat"
                    class="w-full px-4 py-2.5 text-sm focus:outline-none"
                />
                <button type="submit" class="flex items-center pr-3 text-slate-400" aria-label="Cari">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </div>
        </form>

        @if (session('success'))
            <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">{{ session('success') }}</div>
        @endif

        <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="min-w-full text-sm text-slate-700">
                <thead class="bg-slate-100 text-left text-xs uppercase text-slate-700">
                    <tr>
                        <th class="px-4 py-3">Negeri</th>
                        <th class="px-4 py-3">Tahun</th>
                        <th class="px-4 py-3">Bulan</th>
                        <th class="px-4 py-3">No. Sijil Pengecualian</th>
                        <th class="px-4 py-3 text-right">Kuantiti Diluluskan</th>
                        <th class="px-4 py-3 text-right">Baki Kuantiti Diluluskan</th>
                        <th class="px-4 py-3 text-center">Laporan PDF</th>
                        <th class="px-4 py-3 text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($laporans as $laporan)
                        <tr>
                            <td class="px-4 py-3">{{ $laporan->negeri }}</td>
                            <td class="px-4 py-3">{{ $laporan->tahun }}</td>
                            <td class="px-4 py-3">{{ $laporan->bulan }}</td>
                            <td class="px-4 py-3">{{ $laporan->no_sijil_pengecualian ?? '-' }}</td>
                            <td class="px-4 py-3 text-right">{{ number_format((float) $laporan->kuantiti_diluluskan, 0, '.', ',') }}</td>
                            <td class="px-4 py-3 text-right">{{ number_format((float) $laporan->baki_kuantiti_diluluskan, 0, '.', ',') }}</td>
                            <td class="px-4 py-3 text-center"><button type="button" onclick="openLaporanCjpPreview(@js(route('admin.laporan.preview', $laporan)))" class="rounded-md bg-red-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-500">pdf</button></td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.laporan.edit', $laporan) }}" class="rounded-md bg-blue-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-blue-700">Edit</a>
                                    <form action="{{ route('admin.laporan.destroy', $laporan) }}" method="POST" onsubmit="return confirm('Padam laporan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-md bg-red-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-700">Padam</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="px-4 py-8 text-center text-slate-400">Tiada laporan dijumpai.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @include('partials.laporan-cjp-print-modal', ['modalId' => 'admin-laporan-preview-modal', 'frameId' => 'admin-laporan-preview-frame'])
</x-role-dashboard-layout>
