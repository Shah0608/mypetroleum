<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Senarai Permohonan Pelulus</title>
    @vite(['resources/css/app.css'])
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body class="bg-white text-slate-900">
    <div class="mx-auto max-w-[1400px] p-6">
        <div class="no-print mb-6 flex items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold">Senarai Permohonan Pengecualian Butiran 58A</h1>
                <p class="text-sm text-slate-500">Status: {{ $selectedStatusLabel }}@if(filled($query)) | Carian: {{ $query }}@endif</p>
            </div>
            <button type="button" onclick="window.print()" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">
                Print
            </button>
        </div>

        <div class="mb-4 flex items-center justify-between text-sm text-slate-600">
            <div>Jumlah rekod: {{ $permohonans->count() }}</div>
            <div>Dijana pada: {{ now()->format('d/m/Y H:i') }}</div>
        </div>

        <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="w-full min-w-[1200px] border-collapse text-left text-sm text-slate-700">
                <thead>
                    <tr class="bg-slate-100 text-xs font-semibold uppercase text-slate-700">
                        <th class="border-r border-slate-200 p-3">Tarikh Permohonan</th>
                        <th class="border-r border-slate-200 p-3">Negeri</th>
                        <th class="border-r border-slate-200 p-3">Nama Syarikat</th>
                        <th class="border-r border-slate-200 p-3">Perihal Barangan</th>
                        <th class="border-r border-slate-200 p-3 text-center">Unit</th>
                        <th class="border-r border-slate-200 p-3 text-center">Kuantiti</th>
                        <th class="border-r border-slate-200 p-3">Kawasan</th>
                        <th class="border-r border-slate-200 p-3">Status</th>
                        <th class="border-r border-slate-200 p-3">No. Sijil Pengecualian</th>
                        <th class="border-r border-slate-200 p-3">Tarikh Diluluskan</th>
                        <th class="border-r border-slate-200 p-3">Tarikh Tamat</th>
                        <th class="border-r border-slate-200 p-3">Jumlah Hari Diluluskan</th>
                        <th class="border-r border-slate-200 p-3">Indicator</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($permohonans as $permohonan)
                        <tr>
                            <td class="border-r border-slate-200 p-3">{{ $permohonan->tarikh_permohonan?->format('d/m/Y') ?? '-' }}</td>
                            <td class="border-r border-slate-200 p-3">{{ $permohonan->negeri ?? '-' }}</td>
                            <td class="border-r border-slate-200 p-3 font-semibold text-slate-900">{{ $permohonan->nama_syarikat ?? '-' }}</td>
                            <td class="border-r border-slate-200 p-3">{{ collect($permohonan->barangs)->pluck('perihal')->filter()->join(', ') ?: '-' }}</td>
                            <td class="border-r border-slate-200 p-3 text-center">{{ collect($permohonan->barangs)->pluck('unit')->filter()->join(', ') ?: '-' }}</td>
                            <td class="border-r border-slate-200 p-3 text-center">{{ collect($permohonan->barangs)->pluck('kuantiti')->filter()->join(', ') ?: '-' }}</td>
                            <td class="border-r border-slate-200 p-3">{{ collect($permohonan->barangs)->pluck('kawasan')->filter()->join(', ') ?: '-' }}</td>
                            <td class="border-r border-slate-200 p-3">
                                @include('partials.status-permohonan-badge', ['status' => $permohonan->status])
                            </td>
                            <td class="border-r border-slate-200 p-3 font-mono text-xs">{{ $permohonan->no_sijil_pengecualian ?? '-' }}</td>
                            <td class="border-r border-slate-200 p-3">{{ $permohonan->tarikh_diluluskan ? \Illuminate\Support\Carbon::parse($permohonan->tarikh_diluluskan)->format('d/m/Y') : '-' }}</td>
                            <td class="border-r border-slate-200 p-3">{{ $permohonan->tarikh_tamat?->format('d/m/Y') ?? '-' }}</td>
                            <td class="border-r border-slate-200 p-3">
                                @if($permohonan->status === 'Diluluskan' && $permohonan->tarikh_diluluskan && $permohonan->tarikh_tamat)
                                    <div class="font-semibold text-slate-900">{{ $permohonan->tempoh_hari_label }}</div>
                                    <div class="text-xs text-slate-500">{{ $permohonan->baki_hari_label }}</div>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="border-r border-slate-200 p-3">
                                @if($permohonan->status === 'Diluluskan' && $permohonan->tarikh_diluluskan && $permohonan->tarikh_tamat)
                                    <span class="inline-flex items-center justify-center rounded-full px-2.5 py-1 text-center text-xs font-semibold ring-1 ring-inset {{ $permohonan->tempoh_hari_indicator_class }}">
                                        {{ $permohonan->tempoh_hari_indicator_label }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="13" class="p-6 text-center text-sm text-slate-400 italic">
                                Tiada rekod untuk dicetak.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
