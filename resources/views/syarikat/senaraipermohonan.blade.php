<x-role-dashboard-layout
    role="syarikat"
    title="SENARAI PERMOHONAN"
    subtitle="Senarai permohonan syarikat/pemilik."
    :nav-items="[
        ['label' => 'UTAMA', 'url' => route('syarikat.utama'), 'active' => '/syarikat/utama'],
        ['label' => 'BORANG 58A', 'url' => route('syarikat.permohonan-58a'), 'active' => '/syarikat/permohonan-58a'],
        ['label' => 'LAPORAN CJ', 'url' => route('syarikat.laporan-cj'), 'active' => '/syarikat/laporan-cj'],
        ['label' => 'SENARAI LAPORAN', 'url' => route('syarikat.senarailaporan'), 'active' => '/syarikat/senarailaporan'],
        ['label' => 'SENARAI PERMOHONAN', 'url' => route('syarikat.senaraipermohonan'), 'active' => '/syarikat/senaraipermohonan'],
    ]"
>
    <div class="rounded-2xl bg-white/95 p-6 shadow-lg shadow-slate-950/10">
        @if($permohonans->isEmpty())
            <p class="text-slate-700">Tiada permohonan ditemui.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-slate-200">
                            <th class="border px-2">Tarikh Permohonan</th>
                            <th class="border px-2">Negeri</th>
                            <th class="border px-2">Nama Syarikat</th>
                            <th class="border px-2">Perihal Barangan</th>
                            <th class="border px-2">Unit</th>
                            <th class="border px-2">Kuantiti</th>
                            <th class="border px-2">Kawasan</th>
                            <th class="border px-2">Status</th>
                            <th class="border px-2">No. Sijil Pengecualian</th>
                            <th class="border px-2">Tarikh diluluskan</th>
                            <th class="border px-2">Tarikh tamat</th>
                            <th class="border px-2">Sijil Pengecualian</th>
                            <th class="border px-2">Lampiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permohonans as $p)
                            <tr>
                                <td class="border px-2">{{ optional($p->tarikh_permohonan)->format('d/m/Y') ?? '-' }}</td>
                                <td class="border px-2">{{ $p->negeri ?? '-' }}</td>
                                <td class="border px-2">{{ $p->nama_syarikat ?? $p->nama ?? '-' }}</td>
                                <td class="border px-2">
                                    @if(!empty($p->barangs))
                                        <ul class="list-disc pl-4">
                                        @foreach($p->barangs as $b)
                                            <li>{{ $b['perihal'] ?? $b['kod_tarif'] ?? '-' }}</li>
                                        @endforeach
                                        </ul>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="border px-2">
                                    @if(!empty($p->barangs))
                                        {{ implode(', ', array_filter(array_map(fn($b) => $b['unit'] ?? null, $p->barangs))) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="border px-2">
                                    @if(!empty($p->barangs))
                                        {{ implode(', ', array_filter(array_map(fn($b) => $b['kuantiti'] ?? null, $p->barangs))) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="border px-2">
                                    @if(!empty($p->barangs))
                                        {{ implode(', ', array_filter(array_map(fn($b) => $b['kawasan'] ?? null, $p->barangs))) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="border px-2">-</td>
                                <td class="border px-2">-</td>
                                <td class="border px-2">-</td>
                                <td class="border px-2">-</td>
                                <td class="border px-2">-</td>
                                <td class="border px-2">
                                    @if(!empty($p->attachments))
                                        <ul class="list-none">
                                        @foreach($p->attachments as $i => $att)
                                            <li><a class="text-blue-600" href="{{ route('syarikat.permohonan-58a.attachment', [$p->id, $i]) }}">Muat Turun Lampiran {{ $i+1 }}</a></li>
                                        @endforeach
                                        </ul>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-role-dashboard-layout>
