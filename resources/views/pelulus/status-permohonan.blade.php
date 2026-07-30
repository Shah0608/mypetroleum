<x-role-dashboard-layout
    role="pelulus"
    title="STATUS PERMOHONAN"
    subtitle="Sistem Maklumat Bunker Petroleum"
    :nav-items="[
        ['label' => 'UTAMA', 'url' => route('pelulus.utama'), 'active' => '/pelulus/utama'],
        ['label' => 'SENARAI SYARIKAT', 'url' => route('pelulus.senarai-pengguna'), 'active' => '/pelulus/senarai-pengguna'],
        ['label' => 'SENARAI PERMOHONAN', 'url' => route('pelulus.senaraipermohonan'), 'active' => '/pelulus/senaraipermohonan'],
        ['label' => 'STATUS', 'url' => route('pelulus.status-permohonan'), 'active' => '/pelulus/status-permohonan'],
    ]"
>
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-lg shadow-slate-950/10">
            <div class="grid gap-4 border-b border-slate-100 pb-4 mb-6 sm:grid-cols-[1fr_auto_1fr] sm:items-center">
                <h2 class="text-xl font-bold text-slate-900 sm:justify-self-start">
                    Status Permohonan: <span class="text-blue-600">{{ $label }}</span>
                </h2>
                <div class="flex flex-wrap items-center justify-center gap-2 sm:justify-self-center">
                    <a
                        href="{{ route('pelulus.status-permohonan') }}"
                        class="{{ $status === 'Diluluskan' ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }} rounded-lg px-4 py-2 text-sm font-semibold transition"
                    >
                        Lulus
                    </a>
                    <a
                        href="{{ route('pelulus.status-permohonan.pending') }}"
                        class="{{ $status === 'Dalam tindakan' ? 'bg-amber-500 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }} rounded-lg px-4 py-2 text-sm font-semibold transition"
                    >
                        Pending
                    </a>
                    <a
                        href="{{ route('pelulus.status-permohonan.failed') }}"
                        class="{{ $status === 'Tidak diluluskan' ? 'bg-rose-600 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }} rounded-lg px-4 py-2 text-sm font-semibold transition"
                    >
                        Gagal
                    </a>
                </div>
                <span class="rounded-lg bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 sm:justify-self-end">
                    {{ $permohonans->count() }} rekod
                </span>
            </div>

            <form method="GET" action="{{ route('pelulus.status-permohonan') }}" class="mb-6 max-w-5xl">
                <div class="flex items-center overflow-hidden rounded-xl border border-slate-300 bg-white shadow-sm">
                    <span class="whitespace-nowrap border-r border-slate-300 bg-slate-100 px-4 py-2.5 text-xs font-bold uppercase tracking-wider text-slate-600">
                        Cari Nama Syarikat /
                    </span>
                    <input
                        type="text"
                        name="q"
                        value="{{ $query }}"
                        placeholder="Negeri/Kawasan/No Sijil/Tarikh"
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
                <table class="w-full min-w-[1400px] border-collapse text-left text-sm text-slate-600">
                    <thead>
                        <tr class="bg-slate-100 font-semibold text-slate-700 uppercase text-xs border-b border-slate-200">
                            <th class="border-r border-slate-200 p-3">Tarikh Permohonan</th>
                            <th class="border-r border-slate-200 p-3">Negeri</th>
                            <th class="border-r border-slate-200 p-3">Nama Syarikat</th>
                            <th class="border-r border-slate-200 p-3">Perihal Barangan</th>
                            <th class="border-r border-slate-200 p-3 text-center">Unit</th>
                            <th class="border-r border-slate-200 p-3 text-center">Kuantiti</th>
                            <th class="border-r border-slate-200 p-3">Kawasan</th>
                            <th class="border-r border-slate-200 p-3 bg-blue-50 text-blue-900">Status</th>
                            <th class="border-r border-slate-200 p-3 bg-blue-50 text-blue-900">No. Sijil Pengecualian</th>
                            <th class="border-r border-slate-200 p-3 bg-blue-50 text-blue-900">Tarikh Diluluskan</th>
                            <th class="border-r border-slate-200 p-3 bg-blue-50 text-blue-900">Tarikh Tamat</th>
                            <th class="border-r border-slate-200 p-3 bg-blue-50 text-blue-900">Jumlah Hari Diluluskan</th>
                            <th class="border-r border-slate-200 p-3 bg-blue-50 text-blue-900">Indicator</th>
                            <th class="border-r border-slate-200 p-3 bg-blue-50 text-blue-900 text-center">Jana Sijil Pengecualian</th>
                            <th class="p-3 text-center bg-slate-100 text-slate-700">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($permohonans as $permohonan)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="border-r border-slate-200 p-3">{{ $permohonan->tarikh_permohonan?->format('d/m/Y') ?? '-' }}</td>
                                <td class="border-r border-slate-200 p-3">{{ $permohonan->negeri ?? '-' }}</td>
                                <td class="border-r border-slate-200 p-3 font-semibold text-slate-900">{{ $permohonan->nama_syarikat ?? '-' }}</td>
                                <td class="border-r border-slate-200 p-3">{{ collect($permohonan->barangs)->pluck('perihal')->filter()->join(', ') ?: '-' }}</td>
                                <td class="border-r border-slate-200 p-3 text-center">{{ collect($permohonan->barangs)->pluck('unit')->filter()->join(', ') ?: '-' }}</td>
                                <td class="border-r border-slate-200 p-3 text-center">{{ collect($permohonan->barangs)->pluck('kuantiti')->filter()->join(', ') ?: '-' }}</td>
                                <td class="border-r border-slate-200 p-3">{{ collect($permohonan->barangs)->pluck('kawasan')->filter()->join(', ') ?: '-' }}</td>
                                <td class="border-r border-slate-200 p-3 bg-blue-50/30">
                                    @include('partials.status-permohonan-badge', ['status' => $permohonan->status])
                                </td>
                                <td class="border-r border-slate-200 p-3 bg-blue-50/30 font-mono text-xs">{{ $permohonan->no_sijil_pengecualian ?? '-' }}</td>
                                <td class="border-r border-slate-200 p-3 bg-blue-50/30">{{ $permohonan->tarikh_diluluskan ? \Illuminate\Support\Carbon::parse($permohonan->tarikh_diluluskan)->format('d/m/Y') : '-' }}</td>
                                <td class="border-r border-slate-200 p-3 bg-blue-50/30">{{ $permohonan->tarikh_tamat?->format('d/m/Y') ?? '-' }}</td>
                                <td class="border-r border-slate-200 p-3 bg-blue-50/30">
                                    @if($permohonan->tarikh_diluluskan && $permohonan->tarikh_tamat)
                                        <div class="font-semibold text-slate-900">{{ $permohonan->tempoh_hari_label }}</div>
                                        <div class="text-xs text-slate-500">{{ $permohonan->baki_hari_label }}</div>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="border-r border-slate-200 p-3 bg-blue-50/30">
                                    @if($permohonan->tarikh_diluluskan && $permohonan->tarikh_tamat)
                                        <span class="inline-flex items-center justify-center rounded-full px-2.5 py-1 text-center text-xs font-semibold ring-1 ring-inset {{ $permohonan->tempoh_hari_indicator_class }}">
                                            {{ $permohonan->tempoh_hari_indicator_label }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="border-r border-slate-200 p-3 bg-blue-50/30 text-center">
                                    @if(filled($permohonan->no_sijil_pengecualian))
                                        <button type="button" onclick="openCertificatePreview(@js(route('pelulus.permohonan.preview', $permohonan)))" class="inline-flex items-center rounded-md bg-red-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-red-500">pdf</button>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="p-3 text-center">
                                    <a href="{{ route('pelulus.permohonan.semak', $permohonan) }}" class="inline-flex items-center rounded-md bg-green-600 px-4 py-1.5 text-xs font-bold text-white shadow-md hover:bg-green-700 transition uppercase tracking-wider">
                                        semak
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="15" class="p-8 text-center text-sm text-slate-400 italic">
                                    Tiada rekod permohonan {{ strtolower($label) }} buat masa ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('partials.certificate-print-modal', ['modalId' => 'pelulus-list-preview-modal', 'frameId' => 'pelulus-list-preview-frame'])
</x-role-dashboard-layout>
