@php
    $formatNumber = fn ($value) => number_format((float) $value, 0, '.', ',');
    $formatMoney = fn ($value) => number_format((float) $value, 2, '.', ',');
    $pembelians = $laporan->pembelians ?? [];
    $penjualans = $laporan->penjualans ?? [];
@endphp
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="utf-8">
    <title>Laporan CJ(P) {{ $laporan->no_sijil_pengecualian }}</title>
    <style>
        @page { size: A4 landscape; margin: 10mm; }
        * { box-sizing: border-box; }
        body { margin: 0; color: #111; font-family: Arial, sans-serif; font-size: 9px; }
        .toolbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; }
        .toolbar button { border: 0; border-radius: 6px; background: #b91c1c; color: #fff; cursor: pointer; font-weight: 700; padding: 9px 15px; }
        .document { width: 100%; }
        .meta-top { text-align: right; font-weight: 700; font-size: 11px; }
        .appendix { text-align: right; margin: 16px 0 2px; }
        h1 { margin: 0 55px 26px 0; text-align: center; font-size: 13px; line-height: 1.35; }
        .period { margin: 0 0 2px auto; width: 37%; text-align: right; }
        table { width: 100%; border-collapse: collapse; }
        .info td { border: 1px solid #111; height: 17px; padding: 2px 4px; }
        .info .label { width: 9%; }
        .report { margin-top: 16px; table-layout: fixed; }
        .report th, .report td { border: 1px solid #111; padding: 3px 2px; text-align: center; vertical-align: middle; word-wrap: break-word; }
        .report th { background: #d9d9d9; font-weight: 700; }
        .report .left { text-align: left; }
        .report tbody td { height: 175px; vertical-align: top; }
        .report .amount { text-align: right; }
        .totals td { height: auto !important; font-weight: 700; }
        .declaration { font-style: italic; margin: 10px 0 24px 7px; }
        .signature { display: flex; justify-content: flex-end; }
        .signature table { width: 31%; }
        .signature td { line-height: 1.7; vertical-align: top; }
        .signature .label { width: 90px; white-space: nowrap; }
        .signature .value { border-bottom: 1px dotted #444; min-width: 185px; }
        .nowrap { white-space: nowrap; }
        @media print { .toolbar { display: none; } }
    </style>
</head>
<body>
    @if (!empty($previewMode))
        <div class="toolbar"><strong>Preview Laporan CJ(P)</strong><button type="button" onclick="window.print()">Cetak / Simpan PDF</button></div>
    @endif
    <main class="document">
        <div class="meta-top">LAPORAN CJ(P) JADUAL A-58A</div>
        <div class="appendix">Lampiran VIII</div>
        <h1>LAPORAN BULANAN PEMBELIAN DAN PENJUALAN BARANG-BARANG YANG DIBERI PENGECUALIAN CUKAI DI BAWAH BUTIRAN 58A, JADUAL A, PERINTAH CUKAI JUALAN (ORANG YANG DIKECUALIKAN DARIPADA PEMBAYARAN CUKAI) 2018</h1>
        <div class="period">Bulan / Tahun : {{ $laporan->bulan }} {{ $laporan->tahun }}</div>
        <table class="info">
            <tr><td class="label">Nama Syarikat</td><td>{{ $laporan->nama_syarikat }}</td><td class="label">No. Sijil Pengecualian</td><td>{{ $laporan->no_sijil_pengecualian }}</td></tr>
            <tr><td class="label">Alamat Syarikat</td><td>{{ $laporan->permohonan?->alamat ?? '-' }}</td><td class="label">Tarikh Sah Laku Sijil</td><td>{{ $laporan->tarikh_sah_laku_sijil?->format('d.m.Y') ?? '-' }}</td></tr>
            <tr><td class="label">Nama Pembekal</td><td>{{ $laporan->pembekal_nama ?? '-' }}</td><td class="label">Sijil Sah Sehingga</td><td>{{ $laporan->tarikh_tamat_sijil?->format('d.m.Y') ?? '-' }}</td></tr>
        </table>
        <table class="report">
            <colgroup>
                <col style="width:2.5%"><col style="width:6.5%"><col style="width:7%"><col style="width:5.5%"><col style="width:7.5%"><col style="width:6%"><col style="width:6%"><col style="width:8%"><col style="width:5%"><col style="width:5.5%"><col style="width:7%"><col style="width:6.5%"><col style="width:6.5%"><col style="width:5%"><col style="width:5.5%"><col style="width:6.5%">
            </colgroup>
            <thead>
                <tr><th rowspan="2">Bil.</th><th rowspan="2">Kod Tarif Barang</th><th rowspan="2">Perihal Barang</th><th rowspan="2">Kuantiti Diluluskan</th><th rowspan="2">Baki Awal Belum Dijual Pada Awal Bulan</th><th colspan="5">Pembelian dari Pengilang Berdaftar / Kawasan Khas</th><th colspan="5">Penjualan</th><th rowspan="2">Baki Akhir Belum Dijual Pada Akhir Bulan</th></tr>
                <tr><th>Tarikh</th><th>No. Invois / Delivery Order</th><th>No. K9</th><th>Kuantiti</th><th>Nilai (RM)</th><th>Tarikh</th><th>Nama Kapal Penerima</th><th>Pelabuhan Penerima</th><th>No. Invois / Delivery Order</th><th>Kuantiti / Nilai (RM)</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td><td>{{ $laporan->kod_tarif_barang ?? '-' }}</td><td class="left">{{ $laporan->perihal_barang ?? '-' }}</td><td class="amount">{{ $formatNumber($laporan->kuantiti_diluluskan) }}<br><br><strong>Baki: {{ $formatNumber($laporan->baki_kuantiti_diluluskan) }}</strong></td><td class="amount">{{ $formatNumber($laporan->baki_awal) }}</td>
                    <td class="left">@foreach ($pembelians as $row){{ filled($row['tarikh'] ?? null) ? \Illuminate\Support\Carbon::parse($row['tarikh'])->format('d.m.Y') : '-' }}<br>@endforeach</td><td class="left">@foreach ($pembelians as $row){{ $row['no_invois'] ?? '-' }}<br>@endforeach</td><td class="left nowrap">@foreach ($pembelians as $row){{ $row['no_k9'] ?? '-' }}<br>@endforeach</td><td class="amount">@foreach ($pembelians as $row){{ $formatNumber($row['kuantiti'] ?? 0) }}<br>@endforeach</td><td class="amount">@foreach ($pembelians as $row){{ $formatMoney($row['nilai'] ?? 0) }}<br>@endforeach</td>
                    <td class="left">@foreach ($penjualans as $row){{ filled($row['tarikh'] ?? null) ? \Illuminate\Support\Carbon::parse($row['tarikh'])->format('d.m.Y') : '-' }}<br>@endforeach</td><td class="left">@foreach ($penjualans as $row){{ $row['nama_kapal'] ?? '-' }}<br>@endforeach</td><td class="left">@foreach ($penjualans as $row){{ $row['pelabuhan'] ?? '-' }}<br>@endforeach</td><td class="left">@foreach ($penjualans as $row){{ $row['no_invois'] ?? '-' }}<br>@endforeach</td><td class="amount">@foreach ($penjualans as $row){{ $formatNumber($row['kuantiti'] ?? 0) }} / {{ $formatMoney($row['nilai'] ?? 0) }}<br>@endforeach</td><td class="amount">{{ $formatNumber($laporan->baki_akhir) }}</td>
                </tr>
            </tbody>
            <tfoot class="totals"><tr><td colspan="3">JUMLAH</td><td></td><td></td><td colspan="3"></td><td class="amount">{{ $formatNumber(collect($pembelians)->sum('kuantiti')) }}</td><td class="amount">{{ $formatMoney(collect($pembelians)->sum('nilai')) }}</td><td colspan="3"></td><td class="amount">{{ $formatNumber(collect($penjualans)->sum('kuantiti')) }} / {{ $formatMoney(collect($penjualans)->sum('nilai')) }}</td><td></td></tr></tfoot>
        </table>
        <p class="declaration">* Saya akui butir-butir maklumat yang dinyatakan dalam laporan ini adalah betul dan benar.</p>
        <div class="signature"><table><tr><td class="label">Tandatangan :</td><td class="value"></td></tr><tr><td class="label">Nama penuh :</td><td class="value">{{ $laporan->nama_penuh }}</td></tr><tr><td class="label">Jawatan :</td><td class="value">{{ $laporan->jawatan }}</td></tr><tr><td class="label">Nombor Telefon :</td><td class="value">{{ $laporan->no_telefon }}</td></tr></table></div>
    </main>
</body>
</html>
