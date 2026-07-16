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
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-lg shadow-slate-950/10">
            <div class="mb-5 border-b border-slate-100 pb-4">
                <h2 class="text-xl font-semibold text-slate-900">Senarai Permohonan</h2>
                <p class="mt-1 text-sm text-slate-500">Paparan semua permohonan Borang 58A yang telah dihantar.</p>
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