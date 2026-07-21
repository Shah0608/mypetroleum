<x-role-dashboard-layout
    role="syarikat"
    title="SENARAI PERMOHONAN"
    subtitle="Senarai permohonan syarikat/pemilik."
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
            <div class="mb-5 border-b border-slate-100 pb-4">
                <h2 class="text-xl font-semibold text-slate-900">Senarai Permohonan</h2>
                <p class="mt-1 text-sm text-slate-500">Paparan semua permohonan Borang 58A yang telah dihantar.</p>
            </div>

            <!-- Bar Carian / Filter (sama seperti Senarai Laporan) -->
            <div class="mb-6 max-w-4xl">
                <div class="flex items-center rounded-lg border border-slate-300 bg-white shadow-sm overflow-hidden">
                    <span class="bg-slate-100 px-4 py-2.5 text-sm font-semibold text-slate-600 border-r border-slate-300 whitespace-nowrap">
                        Cari Nama Syarikat /
                    </span>
                    <input 
                        type="text" 
                        name="q"
                        value="{{ request('q') }}"
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

            @if(isset($permohonans) && $permohonans->isEmpty())
                <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-6 text-slate-600">
                    Tiada permohonan ditemui.
                </div>
            @else
                <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-slate-50">
                    <table class="min-w-full divide-y divide-slate-200 text-sm text-slate-700">
                        <thead class="bg-slate-100 text-slate-800">
                            <tr>
                                <th class="px-4 py-3 text-left">Tarikh Permohonan</th>
                                <th class="px-4 py-3 text-left">Negeri</th>
                                <th class="px-4 py-3 text-left">Nama Syarikat</th>
                                <th class="px-4 py-3 text-left">Perihal Barangan</th>
                                <th class="px-4 py-3 text-left">Unit</th>
                                <th class="px-4 py-3 text-left">Kuantiti</th>
                                <th class="px-4 py-3 text-left">Kawasan</th>
                                <th class="px-4 py-3 text-left">Lampiran</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-left">No. Sijil Pengecualian</th>
                                <th class="px-4 py-3 text-left">Tarikh Diluluskan</th>
                                <th class="px-4 py-3 text-left">Tarikh Tamat</th>
                                <th class="px-4 py-3 text-left">Sijil Pengecualian</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @if(isset($permohonans))
                                @foreach($permohonans as $p)
                                    <tr>
                                        <td class="px-4 py-3">{{ optional($p->tarikh_permohonan)->format('d/m/Y') ?? '-' }}</td>
                                        <td class="px-4 py-3">{{ $p->negeri ?? '-' }}</td>
                                        <td class="px-4 py-3">{{ $p->nama_syarikat ?? $p->nama ?? '-' }}</td>
                                        <td class="px-4 py-3">
                                            @if(!empty($p->barangs))
                                                <ul class="list-disc pl-5">
                                                    @foreach($p->barangs as $barang)
                                                        <li>{{ $barang['perihal'] ?? '–' }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">{{ collect($p->barangs)->pluck('unit')->filter()->join(', ') ?: '-' }}</td>
                                        <td class="px-4 py-3">{{ collect($p->barangs)->pluck('kuantiti')->filter()->join(', ') ?: '-' }}</td>
                                        <td class="px-4 py-3">{{ collect($p->barangs)->pluck('kawasan')->filter()->join(', ') ?: '-' }}</td>
                                        <td class="px-4 py-3">
                                            @if(!empty($p->attachments))
                                                <ul class="space-y-1">
                                                    @foreach($p->attachments as $i => $attachment)
                                                        <li><a href="{{ route('syarikat.permohonan-58a.attachment', [$p->id, $i]) }}" class="text-blue-600 hover:text-blue-800">Muat Turun {{ $i + 1 }}</a></li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">{{ $p->status ?? 'Dalam tindakan' }}</td>
                                        <td class="px-4 py-3">{{ $p->no_sijil_pengecualian ?? '-' }}</td>
                                        <td class="px-4 py-3">{{ $p->tarikh_diluluskan ? \Illuminate\Support\Carbon::parse($p->tarikh_diluluskan)->format('d/m/Y') : '-' }}</td>
                                        <td class="px-4 py-3">{{ $p->tarikh_tamat ? \Illuminate\Support\Carbon::parse($p->tarikh_tamat)->format('d/m/Y') : '-' }}</td>
                                        <td class="px-4 py-3">
                                            @if($p->sijil_pengecualian_path)
                                                <a href="{{ asset('storage/'.$p->sijil_pengecualian_path) }}" target="_blank" class="inline-flex rounded-md bg-red-600 px-3 py-1 text-xs font-semibold text-white hover:bg-red-500">pdf</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-role-dashboard-layout>
