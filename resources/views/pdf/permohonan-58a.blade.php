@php
    $barangs = collect($permohonan->barangs ?? []);
    $approvedAreas = $barangs->pluck('kawasan')->filter()->unique()->values();
    $logoPath = asset('images/kastam-diraja-malaysia-seeklogo.png');
    $certificateExpiryDate = $permohonan->tarikh_tamat?->format('d/m/Y') ?? $permohonan->tarikh_tamat_cga?->format('d/m/Y') ?? '-';
@endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Exemption Certificate 58A</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            color: #000;
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            line-height: 1.25;
            margin: 0;
        }

    .preview-toolbar {
            background: #111827;
            color: #fff;
            display: {{ !empty($previewMode) ? 'block' : 'none' }};
            padding: 16px 20px;
        }

        .preview-toolbar a {
            border-radius: 8px;
            display: inline-block;
            font-weight: 700;
            margin-right: 10px;
            padding: 10px 16px;
            text-decoration: none;
        }

        .preview-toolbar .download-button {
            background: #dc2626;
            color: #fff;
        }

        .preview-toolbar .back-button {
            background: #2563eb;
            color: #fff;
        }

        .sheet {
            height: 742pt;
            padding: 50pt 51pt;
            position: relative;
        }

        @media print {
            .preview-toolbar {
                display: none !important;
            }
        }

        .page-break {
            page-break-after: always;
        }

        .certificate-number {
            font-size: 9px;
            position: absolute;
            right: 51pt;
            top: 91pt;
        }

        .certificate-number .number-value {
            display: inline-block;
            min-width: 130pt;
        }

        .customs-logo {
            height: 84pt;
            left: 50%;
            object-fit: contain;
            position: absolute;
            top: 135pt;
            transform: translateX(-50%);
            width: 96pt;
        }

        .certificate-heading {
            font-size: 10px;
            font-weight: bold;
            left: 51pt;
            line-height: 1.45;
            position: absolute;
            right: 51pt;
            text-align: center;
            text-transform: uppercase;
            top: 230pt;
        }

        .certificate-heading .certificate-title {
            display: block;
            margin-top: 7pt;
        }

        .statement {
            font-size: 9px;
            left: 84pt;
            line-height: 1.5;
            position: absolute;
            right: 62pt;
            top: 319pt;
        }

        .statement .field-line {
            border-bottom: 0.5pt dotted #000;
            display: inline-block;
            height: 14pt;
            text-align: center;
            vertical-align: bottom;
        }

        .statement .field-hint {
            display: block;
            font-size: 8px;
            text-align: center;
        }

        .statement .person-field {
            margin-left: 8pt;
            width: 142pt;
        }

        .statement .company-field {
            margin-left: 9pt;
            width: 142pt;
        }

        .statement .person-hint {
            margin-left: 37pt;
            width: 145pt;
        }

        .statement .company-hint {
            margin-left: 198pt;
            margin-top: -10pt;
            width: 145pt;
        }

        .address-row {
            margin-top: 9pt;
        }

        .address-field {
            border-bottom: 0.5pt dotted #000;
            display: inline-block;
            height: 15pt;
            margin-left: 7pt;
            vertical-align: bottom;
            width: 425pt;
        }

        .address-hint {
            display: block;
            font-size: 8px;
            margin-left: 181pt;
            text-align: center;
            width: 250pt;
        }

        .acknowledgement {
            margin-top: 25pt;
            text-align: justify;
        }

        .signature-details {
            border-collapse: collapse;
            font-size: 9px;
            left: 344pt;
            position: absolute;
            top: 580pt;
            width: 242pt;
        }

        .signature-details td {
            padding: 3pt 0;
            vertical-align: bottom;
        }

        .signature-details .signature-label {
            white-space: nowrap;
            width: 102pt;
        }

        .signature-value {
            border-bottom: 0.5pt dotted #000;
            min-height: 11pt;
        }

        .certificate-dates {
            font-size: 9px;
            left: 84pt;
            position: absolute;
            top: 658pt;
        }

        .date-line {
            border-bottom: 0.5pt dotted #000;
            display: inline-block;
            min-width: 175pt;
            text-align: center;
        }

        .expiry-date {
            left: 336pt;
            position: absolute;
            top: 672pt;
        }

        .computer-note {
            bottom: 42pt;
            font-size: 9px;
            left: 51pt;
            position: absolute;
            right: 51pt;
            text-align: center;
        }

        .notice-sheet {
            height: 731pt;
            padding: 61pt 63pt 50pt;
        }

        .notice-heading {
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 4pt;
            text-transform: uppercase;
        }

        .notice-title {
            font-size: 9px;
            font-weight: bold;
            line-height: 1.4;
            margin-bottom: 18pt;
            text-transform: uppercase;
        }

        .conditions {
            border-collapse: collapse;
            width: 100%;
        }

        .conditions td {
            font-size: 8.5px;
            line-height: 1.4;
            padding: 0 0 10pt;
            text-align: justify;
            vertical-align: top;
        }

        .conditions .number {
            padding-right: 9pt;
            text-align: right;
            width: 10pt;
        }

        .notice-footer {
            bottom: 36pt;
            font-size: 9px;
            left: 0;
            position: absolute;
            right: 0;
            text-align: center;
        }

        .appendix-sheet {
            height: 744pt;
            padding: 49pt 51pt;
        }

        .appendix-label {
            border-top: 0.5pt dotted #000;
            font-size: 10px;
            padding-top: 8pt;
            position: absolute;
            right: 51pt;
            text-align: right;
            top: 71pt;
            width: 440pt;
        }

        .appendix-title {
            font-size: 10px;
            font-weight: bold;
            line-height: 1.45;
            margin: 115pt auto 20pt;
            text-align: center;
            text-transform: uppercase;
        }

        .appendix-subtitle {
            font-size: 10px;
            font-weight: bold;
            line-height: 1.4;
            margin-bottom: 14pt;
            text-transform: uppercase;
        }

        .goods-table {
            border-collapse: collapse;
            width: 100%;
        }

        .goods-table th,
        .goods-table td {
            border: 0.5pt solid #000;
            font-size: 8px;
            min-height: 25pt;
            padding: 5pt 4pt;
            vertical-align: top;
        }

        .goods-table th {
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
        }

        .number-cell {
            text-align: center;
            width: 28pt;
        }

        .area-title {
            font-size: 10px;
            font-weight: bold;
            line-height: 1.45;
            margin: 63pt auto 20pt;
            text-align: center;
            text-transform: uppercase;
        }

        .area-table {
            margin-top: 14pt;
        }
    </style>
</head>
<body>
    @if(!empty($previewMode))
        <div class="preview-toolbar">
            <a href="{{ $downloadUrl ?? '#' }}" class="download-button" target="_blank" rel="noopener">Muat Turun PDF</a>
            <a href="{{ $backUrl ?? '#' }}" class="back-button">Kembali</a>
        </div>
    @endif

    <div class="sheet page-break">
        <div class="certificate-number">
            Exemption Certificate Number: <span class="number-value">{{ $permohonan->no_sijil_pengecualian ?: '-' }}</span>
        </div>

        <img class="customs-logo" src="{{ $logoPath }}" alt="Jabatan Kastam Diraja Malaysia">

        <div class="certificate-heading">
            Sales Tax (Persons Exempted From Payment of Tax) Order 2018<br>
            Sales Tax Act 2018
            <span class="certificate-title">Certificate Under The Sales Tax (Person Exempted From Payment Of Tax) Order 2018</span>
        </div>

        <div class="statement">
            I <span class="field-line person-field">{{ $permohonan->tandatangan_nama ?: $permohonan->nama ?: '-' }}</span>
            for <span class="field-line company-field">{{ $permohonan->nama_syarikat ?: '-' }}</span>
            <span class="field-hint person-hint">(Director, Manager, Secretary or any other authorized person)</span>
            <span class="field-hint company-hint">(Name of firm or company)</span>

            <div class="address-row">
                address <span class="address-field">{{ $permohonan->alamat ?: '-' }}</span>
                <span class="address-hint">(Address of place of business)</span>
            </div>

            <div class="acknowledgement">
                hereby acknowledges that the goods described in Appendix are purchased / transported with exemption from sales tax
                claimed under Item 58A Schedule A, Sales Tax (Persons Exempted From Payment of Tax) Order 2018 subject to the
                conditions as specified.
            </div>
        </div>

        <table class="signature-details">
            <tr>
                <td class="signature-label">Signature :</td>
                <td class="signature-value">&nbsp;</td>
            </tr>
            <tr>
                <td class="signature-label">Name :</td>
                <td class="signature-value">{{ $permohonan->tandatangan_nama ?: $permohonan->nama ?: '-' }}</td>
            </tr>
            <tr>
                <td class="signature-label">Identity Card Number :</td>
                <td class="signature-value">{{ $permohonan->tandatangan_no_kp ?: $permohonan->no_kp ?: '-' }}</td>
            </tr>
            <tr>
                <td class="signature-label">Designation :</td>
                <td class="signature-value">{{ $permohonan->tandatangan_jawatan ?: $permohonan->jawatan ?: '-' }}</td>
            </tr>
        </table>

        <div class="certificate-dates">
            Date: <span class="date-line">{{ $permohonan->tarikh_diluluskan?->format('d/m/Y') ?? '-' }}</span>
        </div>
        <div class="expiry-date">
            Expiry date of exemption certificate: <span class="date-line">{{ $certificateExpiryDate }}</span>
        </div>

        <div class="computer-note">This document is computer printed and digitally signed. No signature is required</div>
    </div>

    <div class="sheet notice-sheet page-break">
        <div class="notice-heading">Notis Penting / Important Notice</div>
        <div class="notice-title">
            Syarat-Syarat Di Bawah Butiran 58A, Jadual A, Perintah Cukai Jualan<br>
            (Orang Yang Dikecualikan Daripada Pembayaran Cukai) 2018<br>
            Conditions Under Item 58A, Schedule A, Sales Tax (Person Exempted From Payment Of Tax) Order 2018
        </div>

        <table class="conditions">
            <tr><td class="number">1.</td><td>Barang tersebut dibeli daripada pengilang berdaftar atau diangkut dari Kawasan Khas;<br>That the goods are purchased from a registered manufacturer or transported from Special Area;</td></tr>
            <tr><td class="number">2.</td><td>Barang tersebut digunakan semata-mata sebagai minyak bunker bagi kapal termasuk bot nelayan;<br>That the goods are to be used solely as bunker fuel of the vessel including fishing boats;</td></tr>
            <tr><td class="number">3.</td><td>Kapal termasuk bot nelayan tersebut adalah seperti yang ditentukan oleh Ketua Pengarah;<br>That the vessel including fishing boats is of a type as determined by the Director General;</td></tr>
            <tr><td class="number">4.</td><td>Pembuktian dapat dibuat dengan memuaskan hati Ketua Pengarah bahawa barang itu akan dihantar terus ke kapal termasuk bot nelayan;<br>That it is proved to the satisfaction of the Director General that the goods are to be delivered directly to such vessel including the fishing boats;</td></tr>
            <tr><td class="number">5.</td><td>Orang di ruang (2) hendaklah mematuhi syarat-syarat lain yang ditetapkan oleh Ketua Pengarah;<br>That the person in column (2) shall comply with any other conditions as the Director General may deem fit to impose;</td></tr>
            <tr><td class="number">6.</td><td>Orang yang diluluskan hendaklah menyediakan Laporan CJ(P) Jadual A - 58A pada setiap bulan. Laporan yang lengkap perlu dihantar sebelum atau pada setiap 10 hari bulan bulan berikutnya kepada stesen kastam yang mengawal;<br>The approved person shall prepare Laporan CJ(P) Jadual A - 58A for every month. A complete report must be submitted before or on the 10th of the following month to the customs controlling station;</td></tr>
            <tr><td class="number">7.</td><td>Orang yang diluluskan hendaklah membayar semua cukai ke atas barang yang tidak boleh diakaunkan; dan<br>The approved person shall pay all the taxes on any goods that cannot be accounted for; and</td></tr>
            <tr><td class="number">8.</td><td>Orang yang diluluskan hendaklah menyimpan rekod atau akaun yang berkaitan dengan barang yang dibeli / diangkut dan dijual. Rekod atau akaun tersebut perlu disediakan untuk pemeriksaan oleh pegawai cukai jualan pada bila-bila masa.<br>The approved person shall keep records or accounts of the goods purchased / transported and sold. Such records or accounts shall be provided for inspection by any sales tax officer at any time.</td></tr>
        </table>

        <div class="notice-footer">NOTICE</div>
    </div>

    <div class="sheet appendix-sheet">
        <div class="appendix-label">Lampiran 58A</div>
        <div class="appendix-title">
            Senarai Barang Yang Diluluskan Pengecualian Cukai Jualan Di Bawah Butiran 58, Jadual A,<br>
            Perintah Cukai Jualan (Orang Yang Dikecualikan Daripada Pembayaran Cukai) 2018
        </div>

        <div class="appendix-subtitle">Bahagian D: Perihal Barang-Barang<br>Part D: Description Of Goods</div>
        <table class="goods-table">
            <thead>
                <tr>
                    <th style="width: 28pt;">Bil</th>
                    <th style="width: 78pt;">No. Kod Tariff</th>
                    <th style="width: 125pt;">Perihal Barangan</th>
                    <th style="width: 125pt;">Deskripsi</th>
                    <th style="width: 85pt;">Kuantiti Dipohon</th>
                    <th style="width: 64pt;">Nilai</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangs as $index => $barang)
                    <tr>
                        <td class="number-cell">{{ $index + 1 }}</td>
                        <td>{{ $barang['kod_tarif'] ?? '-' }}</td>
                        <td>{{ $barang['perihal'] ?? '-' }}</td>
                        <td>{{ $barang['deskripsi'] ?? '-' }}</td>
                        <td>{{ $barang['kuantiti'] ?? '-' }} {{ $barang['unit'] ?? '' }}</td>
                        <td>{{ isset($barang['nilai']) ? number_format((float) $barang['nilai'], 2) : '-' }}</td>
                    </tr>
                @empty
                    <tr><td class="number-cell">1</td><td colspan="5">&nbsp;</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="area-title">
            Kawasan Yang Diluluskan Bagi Menjalankan Aktiviti Bunkering Di Bawah Butiran 58, Jadual A,<br>
            Perintah Cukai Jualan (Orang Yang Dikecualikan Daripada Pembayaran Cukai) 2018
        </div>

        <div class="appendix-subtitle">Bahagian E: Kawasan Yang Diluluskan Bagi Menjalankan Aktiviti Bunkering<br>Part E: Approved Area For Business</div>
        <table class="goods-table area-table">
            <thead><tr><th style="width: 28pt;">Bil</th><th>Nama Kawasan<br>Name Of Area</th></tr></thead>
            <tbody>
                @forelse($approvedAreas as $index => $area)
                    <tr><td class="number-cell">{{ $index + 1 }}</td><td>{{ $area }}</td></tr>
                @empty
                    <tr><td class="number-cell">1</td><td>&nbsp;</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
