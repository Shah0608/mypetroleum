<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Permohonan 58A</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111827; }
        h1 { font-size: 18px; margin-bottom: 4px; }
        h2 { font-size: 14px; margin: 18px 0 8px; border-bottom: 1px solid #d1d5db; padding-bottom: 4px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
        th, td { border: 1px solid #d1d5db; padding: 6px; vertical-align: top; }
        th { width: 32%; background: #f3f4f6; text-align: left; }
        .small { font-size: 10px; color: #4b5563; }
    </style>
</head>
<body>
    <h1>Permohonan Pengecualian Cukai Jualan Butiran 58A</h1>
    <div class="small">Dijana pada {{ now()->format('d/m/Y H:i') }}</div>

    <h2>Maklumat Pemohon</h2>
    <table>
        <tr><th>Nama</th><td>{{ $permohonan->nama ?: '-' }}</td></tr>
        <tr><th>Nama Syarikat</th><td>{{ $permohonan->nama_syarikat ?: '-' }}</td></tr>
        <tr><th>No. Telefon</th><td>{{ $permohonan->no_telefon ?: '-' }}</td></tr>
        <tr><th>Alamat E-mel</th><td>{{ $permohonan->email ?: '-' }}</td></tr>
        <tr><th>No. KP</th><td>{{ $permohonan->no_kp ?: '-' }}</td></tr>
        <tr><th>Jawatan</th><td>{{ $permohonan->jawatan ?: '-' }}</td></tr>
        <tr><th>Negeri</th><td>{{ $permohonan->negeri ?: '-' }}</td></tr>
        <tr><th>Tarikh Permohonan</th><td>{{ $permohonan->tarikh_permohonan?->format('d/m/Y') ?? '-' }}</td></tr>
        <tr><th>Alamat</th><td>{{ $permohonan->alamat ?: '-' }}</td></tr>
    </table>

    <h2>Perihal Barang-Barang</h2>
    <table>
        <thead>
            <tr>
                <th>No Kod Tarif</th>
                <th>Perihal</th>
                <th>Unit</th>
                <th>Kuantiti</th>
                <th>Kawasan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($permohonan->barangs ?? [] as $barang)
                <tr>
                    <td>{{ $barang['kod_tarif'] ?? '-' }}</td>
                    <td>{{ $barang['perihal'] ?? '-' }}</td>
                    <td>{{ $barang['unit'] ?? '-' }}</td>
                    <td>{{ $barang['kuantiti'] ?? '-' }}</td>
                    <td>{{ $barang['kawasan'] ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="5">Tiada maklumat barang.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Ulasan JKDM</h2>
    <table>
        <tr><th>Ulasan Pegawai Kanan</th><td>{{ $permohonan->ulasan_jkdm ?: '-' }}</td></tr>
        <tr><th>Nama Pegawai</th><td>{{ $permohonan->nama_pegawai_jkdm ?: '-' }}</td></tr>
        <tr><th>Tarikh Ulasan</th><td>{{ $permohonan->tarikh_ulasan_jkdm?->format('d/m/Y') ?? '-' }}</td></tr>
        <tr><th>Tarikh Tamat CGA</th><td>{{ $permohonan->tarikh_tamat_cga?->format('d/m/Y') ?? '-' }}</td></tr>
    </table>

    <h2>Keputusan Pengarah Kastam Negeri</h2>
    <table>
        <tr><th>Keputusan</th><td>{{ $permohonan->status ?: '-' }}</td></tr>
        <tr><th>No. Sijil</th><td>{{ $permohonan->no_sijil_pengecualian ?: '-' }}</td></tr>
        <tr><th>Tarikh Diluluskan</th><td>{{ $permohonan->tarikh_diluluskan?->format('d/m/Y') ?? '-' }}</td></tr>
        <tr><th>Tarikh Tamat</th><td>{{ $permohonan->tarikh_tamat?->format('d/m/Y') ?? '-' }}</td></tr>
    </table>
</body>
</html>
