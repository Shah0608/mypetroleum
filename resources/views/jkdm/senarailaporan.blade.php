<x-role-dashboard-layout
    role="jkdm"
    title="SENARAI LAPORAN"
    subtitle="Semakan semua laporan untuk pegawai JKDM."
    :nav-items="[
        ['label' => 'UTAMA', 'url' => route('jkdm.utama'), 'active' => '/jkdm/utama'],
        ['label' => 'SENARAI LAPORAN', 'url' => route('jkdm.senarailaporan'), 'active' => '/jkdm/senarailaporan'],
        ['label' => 'SENARAI PERMOHONAN', 'url' => route('jkdm.senaraipermohonan'), 'active' => '/jkdm/senaraipermohonan'],
    ]"
>
    <div class="rounded-2xl bg-white/95 p-6 shadow-lg shadow-slate-950/10">
        <div class="mb-5 flex flex-col gap-3 border-b border-slate-100 pb-4 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-xl font-bold text-slate-900">Senarai Laporan CJ(P)</h2>
            <a href="{{ route('jkdm.senarailaporan.export') }}" class="inline-flex items-center justify-center rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-green-700">
                Muat Turun Excel
            </a>
        </div>

        <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
            <table class="w-full min-w-[900px] border-collapse text-sm text-slate-700">
                <thead class="bg-slate-100 text-left text-xs uppercase text-slate-700">
                    <tr>
                        <th class="border-r border-slate-200 p-3">Negeri</th>
                        <th class="border-r border-slate-200 p-3">Nama Syarikat</th>
                        <th class="border-r border-slate-200 p-3 text-center">Tahun</th>
                        <th class="border-r border-slate-200 p-3 text-center">Bulan</th>
                        <th class="border-r border-slate-200 p-3">ID Syarikat</th>
                        <th class="p-3 text-center">Laporan CJ(P)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($laporans as $laporan)
                        <tr class="hover:bg-slate-50">
                            <td class="border-r border-slate-200 p-3">{{ $laporan->negeri }}</td>
                            <td class="border-r border-slate-200 p-3 font-semibold text-slate-900">{{ $laporan->nama_syarikat }}</td>
                            <td class="border-r border-slate-200 p-3 text-center">{{ $laporan->tahun }}</td>
                            <td class="border-r border-slate-200 p-3 text-center">{{ $laporan->bulan }}</td>
                            <td class="border-r border-slate-200 p-3">{{ $laporan->user?->login_id ?? '-' }}</td>
                            <td class="p-3 text-center">
                                @if($laporan->fail_path)
                                    <a href="{{ asset('storage/'.$laporan->fail_path) }}" target="_blank" class="inline-flex rounded-md bg-red-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-500">pdf</a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400">Tiada rekod laporan dijumpai.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-role-dashboard-layout>
