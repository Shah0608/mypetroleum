<x-role-dashboard-layout
    role="pelulus"
    title="SENARAI PERMOHONAN"
    subtitle="Keputusan permohonan oleh Pelulus."
    :nav-items="[
        ['label' => 'UTAMA', 'url' => route('pelulus.utama'), 'active' => '/pelulus/utama'],
        ['label' => 'SENARAI PERMOHONAN', 'url' => route('pelulus.senaraipermohonan'), 'active' => '/pelulus/senaraipermohonan'],
    ]"
>
    <div class="space-y-6">
        <!-- Pengecualian Butiran 58A Header Seksyen -->
        <div class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-lg shadow-slate-950/10">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-b border-slate-100 pb-4 mb-6">
                <h2 class="text-xl font-bold text-slate-900">
                    Senarai Permohonan: <span class="text-blue-600">Pengecualian Butiran 58A</span>
                </h2>
                <span class="mt-2 rounded-lg bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 sm:mt-0">
                    {{ $permohonans->count() }} rekod
                </span>
            </div>

            <!-- Bar Carian Panjang (Format: Cari Nama Syarikat / Negeri/Kawasan/Status/No Sijil/Tarikh) -->
            <form method="GET" action="{{ route('pelulus.senaraipermohonan') }}" class="mb-6 max-w-5xl">
                <div class="flex items-center overflow-hidden rounded-xl border border-slate-300 bg-white shadow-sm">
                    <span class="whitespace-nowrap border-r border-slate-300 bg-slate-100 px-4 py-2.5 text-xs font-bold uppercase tracking-wider text-slate-600">
                        Cari Nama Syarikat /
                    </span>
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Negeri/Kawasan/Status/No Sijil/Tarikh"
                        class="w-full px-4 py-2.5 text-sm focus:outline-none"
                    />
                    <button type="submit" class="flex items-center pr-3 text-slate-400" aria-label="Cari">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </form>

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
                                <td class="border-r border-slate-200 p-3 bg-blue-50/30">{{ $permohonan->tarikh_tamat ? \Illuminate\Support\Carbon::parse($permohonan->tarikh_tamat)->format('d/m/Y') : '-' }}</td>
                                <td class="border-r border-slate-200 p-3 bg-blue-50/30 text-center">
                                    @if($permohonan->sijil_pengecualian_path)
                                        <a href="{{ asset('storage/'.$permohonan->sijil_pengecualian_path) }}" target="_blank" class="inline-flex items-center rounded-md bg-red-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-red-500">pdf</a>
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
                                <td colspan="13" class="p-8 text-center text-sm text-slate-400 italic">
                                    Tiada rekod permohonan baharu untuk disemak buat masa ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-role-dashboard-layout>
