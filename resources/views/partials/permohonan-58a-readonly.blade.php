@php
    $detailClass = 'rounded-lg border border-slate-200 bg-slate-50 px-4 py-3';
    $labelClass = 'text-xs font-semibold uppercase tracking-wide text-slate-500';
    $valueClass = 'mt-1 text-sm font-semibold text-slate-900';
@endphp

<div class="space-y-6">
    <section class="space-y-4">
        <h3 class="text-lg font-semibold text-slate-800">BAHAGIAN A: MAKLUMAT PEMOHON</h3>
        <div class="grid gap-4 md:grid-cols-2">
            @foreach([
                'Nama' => $permohonan->nama,
                'No. Telefon' => $permohonan->no_telefon,
                'Alamat E-mel' => $permohonan->email,
                'No. Kad Pengenalan' => $permohonan->no_kp,
                'Jawatan' => $permohonan->jawatan,
                'Nama Syarikat' => $permohonan->nama_syarikat,
                'No. Pendaftaran Cukai Jualan' => $permohonan->no_pendaftaran_cukai,
                'Tarikh Permohonan' => $permohonan->tarikh_permohonan?->format('d/m/Y'),
                'No. Kelulusan (PDA2, JKDM dll)' => $permohonan->no_kelulusan,
                'No. Pesanan Belian' => $permohonan->no_pesanan_belian,
                'Negeri (stesen dipohon)' => $permohonan->negeri,
            ] as $label => $value)
                <div class="{{ $detailClass }}">
                    <div class="{{ $labelClass }}">{{ $label }}</div>
                    <div class="{{ $valueClass }}">{{ $value ?: '-' }}</div>
                </div>
            @endforeach

            <div class="{{ $detailClass }} md:col-span-2">
                <div class="{{ $labelClass }}">Alamat</div>
                <div class="{{ $valueClass }}">{{ $permohonan->alamat ?: '-' }}</div>
            </div>
        </div>
    </section>

    <section class="space-y-4">
        <h3 class="text-lg font-semibold text-slate-800">BAHAGIAN B: MAKLUMAT ORANG YANG AKAN MENANDATANGANI SIJIL PENGECUALIAN</h3>
        <div class="grid gap-4 md:grid-cols-3">
            @foreach([
                'Nama Pemohon' => $permohonan->tandatangan_nama,
                'No KP Pemohon' => $permohonan->tandatangan_no_kp,
                'Jawatan' => $permohonan->tandatangan_jawatan,
            ] as $label => $value)
                <div class="{{ $detailClass }}">
                    <div class="{{ $labelClass }}">{{ $label }}</div>
                    <div class="{{ $valueClass }}">{{ $value ?: '-' }}</div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="space-y-4">
        <h3 class="text-lg font-semibold text-slate-800">BAHAGIAN C: MAKLUMAT PEMBEKAL</h3>
        <div class="grid gap-4 md:grid-cols-2">
            <div class="{{ $detailClass }}">
                <div class="{{ $labelClass }}">Nama Firma/Syarikat</div>
                <div class="{{ $valueClass }}">{{ $permohonan->pembekal_nama ?: '-' }}</div>
            </div>
            <div class="{{ $detailClass }}">
                <div class="{{ $labelClass }}">Alamat</div>
                <div class="{{ $valueClass }}">{{ $permohonan->pembekal_alamat ?: '-' }}</div>
            </div>
        </div>
    </section>

    <section class="space-y-4">
        <h3 class="text-lg font-semibold text-slate-800">BAHAGIAN D: PERIHAL BARANG-BARANG</h3>
        <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-100 text-left text-slate-700">
                    <tr>
                        <th class="px-3 py-2">No Kod Tarif</th>
                        <th class="px-3 py-2">Perihal Barangan</th>
                        <th class="px-3 py-2">Unit</th>
                        <th class="px-3 py-2">Deskripsi</th>
                        <th class="px-3 py-2">Kuantiti</th>
                        <th class="px-3 py-2">Nilai (RM)</th>
                        <th class="px-3 py-2">Nama Kawasan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse(($permohonan->barangs ?? []) as $barang)
                        <tr>
                            <td class="px-3 py-2">{{ $barang['kod_tarif'] ?? '-' }}</td>
                            <td class="px-3 py-2">{{ $barang['perihal'] ?? '-' }}</td>
                            <td class="px-3 py-2">{{ $barang['unit'] ?? '-' }}</td>
                            <td class="px-3 py-2">{{ $barang['deskripsi'] ?? '-' }}</td>
                            <td class="px-3 py-2">{{ $barang['kuantiti'] ?? '-' }}</td>
                            <td class="px-3 py-2">{{ $barang['nilai'] ?? '-' }}</td>
                            <td class="px-3 py-2">{{ $barang['kawasan'] ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-3 py-4 text-center text-slate-500">Tiada barangan direkodkan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="space-y-4">
        <h3 class="text-lg font-semibold text-slate-800">Muat Naik Fail Berkaitan</h3>
        @if(!empty($permohonan->attachments))
            <div class="flex flex-wrap gap-2">
                @foreach($permohonan->attachments as $index => $attachment)
                    <a href="{{ asset('storage/'.$attachment) }}" target="_blank" class="rounded-md bg-blue-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-blue-700">
                        Lampiran {{ $index + 1 }}
                    </a>
                @endforeach
            </div>
        @else
            <div class="rounded-lg border border-dashed border-slate-300 bg-slate-50 p-4 text-sm text-slate-500">
                Tiada lampiran dimuat naik.
            </div>
        @endif
    </section>
</div>
