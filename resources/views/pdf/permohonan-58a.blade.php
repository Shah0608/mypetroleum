@php
    $barangs = collect($permohonan->barangs ?? []);
    $approvedAreas = $barangs->pluck('kawasan')->filter()->unique()->values();
    $logoPath = asset('images/kastam-diraja-malaysia-seeklogo.png');
    $certificateExpiryDate = $permohonan->tarikh_tamat_pda2_verifikasi?->format('d/m/Y')
        ?? $permohonan->tarikh_tamat?->format('d/m/Y')
        ?? $permohonan->tarikh_tamat_cga?->format('d/m/Y')
        ?? '-';
@endphp

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Exemption Certificate 58A</title>
    <style>
        /* ==========================================
           1. TETAPAN PRINT & LAYOUT DOKUMEN
           ========================================== */
        * {
            box-sizing: border-box;
        }

        @page {
            size: A4 portrait;
            margin: 0;
        }

        html, body {
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #000;
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            line-height: 1.15;
        }

        /* Paparan Lembaran Skrin (A4 Preview) */
        .sheet {
            width: 210mm;
            min-height: 297mm;
            height: 297mm;
            padding: 50pt 51pt;
            position: relative;
            background: #ffffff;
            margin: 0 auto 20px auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            overflow: hidden;
            page-break-after: always;
            break-after: page;
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .sheet:last-of-type {
            page-break-after: auto !important;
            break-after: auto !important;
            margin-bottom: 0;
        }

        /* Exemption Certificate Number dialihkan ke hujung kanan */
        .certificate-number {
            font-size: 12pt;
            position: absolute;
            right: 51pt;
            text-align: right;
            top: 43pt;
        }

        .certificate-number .number-value {
            display: inline-block;
            min-width: 130pt;
            text-align: left;
        }

        .customs-logo {
            height: 77pt;
            left: 50%;
            object-fit: contain;
            position: absolute;
            top: 88pt;
            transform: translateX(-50%);
            width: 92pt;
        }

        .certificate-heading {
            font-size: 12pt;
            font-weight: bold;
            left: 51pt;
            line-height: 1.15;
            position: absolute;
            right: 51pt;
            text-align: center;
            text-transform: uppercase;
            top: 180pt;
        }

        .certificate-heading .certificate-title {
            display: block;
            font-size: 11pt;
            line-height: 1.1;
            margin-top: 14pt;
        }

        .statement {
            font-size: 12pt;
            left: 63pt;
            line-height: 1.45;
            position: absolute;
            right: 63pt;
            top: 285pt;
        }

        .statement-row {
            display: table;
            width: 100%;
            margin-top: 8pt;
        }

        .statement-label {
            display: table-cell;
            width: 40pt;
            white-space: nowrap;
        }

        .statement .field-line {
            border-bottom: 0.5pt dotted #000;
            display: table-cell;
            height: 18pt;
            padding-left: 10pt;
            padding-right: 10pt;
            text-align: center; /* DIUBAH: Data berada di tengah garisan */
            vertical-align: bottom;
        }

        .statement .field-hint {
            display: block;
            font-size: 10pt;
            text-align: center;
        }

        .statement .person-hint {
            margin-left: 40pt;
            width: 430pt;
        }

        .statement .company-hint {
            margin-left: 40pt;
            margin-top: 7pt;
            width: 430pt;
        }

        .address-row {
            margin-top: 8pt;
        }

        .address-field {
            border-bottom: 0.5pt dotted #000;
            display: table-cell;
            height: 20pt;
            padding-left: 10pt;
            padding-right: 10pt;
            text-align: center; /* DIUBAH: Alamat berada di tengah garisan */
            vertical-align: bottom;
        }

        .address-hint {
            display: block;
            font-size: 10pt;
            margin-left: 54pt;
            margin-top: 2pt;
            text-align: center;
            width: 424pt;
        }

        .acknowledgement {
            margin-top: 24pt;
            text-align: justify;
        }

        /* Container Tandatangan di Kanan */
        .signature-right {
            position: absolute;
            right: 51pt;
            top: 545pt;
            width: 220pt;
        }

        .signature-right table {
            border-collapse: collapse;
            font-size: 11pt;
            width: 100%;
        }

        .signature-right td {
            padding: 1pt 0;
            vertical-align: bottom;
        }

        .signature-right .signature-label {
            white-space: nowrap;
            width: 110pt;
            padding-right: 5pt;
            text-align: left;
        }

        .signature-right .signature-value {
            border-bottom: 0.5pt dotted #000;
            text-align: left;
            padding-left: 5pt;
        }

        /* Baris Tarikh */
        .dates-container {
            position: absolute;
            left: 63pt;
            right: 51pt;
            top: 657pt;
            font-size: 11pt;
        }

        .dates-table {
            width: 100%;
            border-collapse: collapse;
        }

        .dates-table td {
            vertical-align: bottom;
        }

        .date-line {
            border-bottom: 0.5pt dotted #000;
            display: inline-block;
            text-align: center;
            padding-left: 5pt;
            padding-right: 5pt;
        }

        .computer-note {
            bottom: 40pt;
            font-size: 9pt;
            font-style: italic;
            left: 51pt;
            position: absolute;
            right: 51pt;
            text-align: center;
        }

        .notice-heading {
            font-size: 11pt;
            font-weight: bold;
            margin-bottom: 4pt;
            text-transform: uppercase;
        }

        .notice-title {
            font-size: 11pt;
            font-weight: bold;
            line-height: 1.35;
            margin-bottom: 16pt;
            text-transform: uppercase;
        }

        /* Tetapan Syarat-Syarat */
        .conditions {
            border-collapse: collapse;
            width: 100%;
        }

        .conditions td {
            font-size: 10.5pt;
            font-weight: normal;
            line-height: 1.35;
            padding: 0 0 8pt;
            text-align: justify;
            vertical-align: top;
        }

        .conditions .number {
            font-weight: bold;
            padding-right: 8pt;
            text-align: right;
            width: 14pt;
        }

        .notice-footer {
            bottom: 36pt;
            font-size: 10pt;
            left: 0;
            position: absolute;
            right: 0;
            text-align: center;
        }

        .appendix-label {
            border-top: 0.5pt dotted #000;
            font-size: 11pt;
            padding-top: 8pt;
            position: absolute;
            right: 51pt;
            text-align: right;
            top: 45pt;
            width: 440pt;
        }

        .appendix-title {
            font-size: 11pt;
            font-weight: bold;
            line-height: 1.4;
            margin: 45pt auto 16pt;
            text-align: center;
            text-transform: uppercase;
        }

        .appendix-subtitle {
            font-size: 10.5pt;
            font-weight: bold;
            line-height: 1.35;
            margin-bottom: 10pt;
            text-transform: uppercase;
        }

        .goods-table {
            border-collapse: collapse;
            width: 100%;
        }

        .goods-table th,
        .goods-table td {
            border: 0.5pt solid #000;
            font-size: 10pt;
            min-height: 22pt;
            padding: 5pt 6pt;
            vertical-align: middle;
        }

        .goods-table th {
            font-weight: bold;
            text-align: center;
            background-color: #fcfcfc;
        }

        .number-cell {
            text-align: center;
            width: 28pt;
        }

        .area-title {
            font-size: 11pt;
            font-weight: bold;
            line-height: 1.4;
            margin: 25pt auto 12pt;
            text-align: center;
            text-transform: uppercase;
        }

        .area-table {
            margin-top: 8pt;
        }

        /* ==========================================
           2. STYLES BUTANG BAHAGIAN BAWAH
           ========================================== */
        .bottom-action-bar {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin: 20px auto 40px auto;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 40px;
            padding: 0 20px;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
            font-size: 14px;
            font-weight: bold;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            line-height: 1;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
            transition: opacity 0.2s;
        }

        .btn-action:hover {
            opacity: 0.9;
        }

        .btn-pdf {
            background-color: #dc3545;
        }

        .btn-close {
            background-color: #0d6efd;
        }

        /* ==========================================
           3. PENETAPAN KHUSUS WAKTU PRINT (CETAK/PDF)
           ========================================== */
        @media print {
            html, body {
                background: none !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .sheet {
                margin: 0 !important;
                box-shadow: none !important;
                width: 100% !important;
                height: 100vh !important;
            }

            .no-print,
            .bottom-action-bar {
                display: none !important;
                height: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
            }
        }
    </style>
</head>
<body>

    <!-- Muka Surat 1: Sijil Pengecualian -->
    <div class="sheet">
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
            <div class="statement-row">
                <span class="statement-label">I</span>
                <span class="field-line">{{ $permohonan->tandatangan_nama ?: $permohonan->nama ?: '-' }}</span>
            </div>
            <span class="field-hint person-hint">(Director, Manager, Secretary or any other authorized person)</span>

            <div class="statement-row">
                <span class="statement-label">for</span>
                <span class="field-line">{{ $permohonan->nama_syarikat ?: '-' }}</span>
            </div>
            <span class="field-hint company-hint">(Name of firm or company)</span>

            <div class="statement-row address-row">
                <span class="statement-label" style="width: 54pt;">address</span>
                <span class="address-field">{{ $permohonan->alamat ?: '-' }}</span>
            </div>
            <span class="address-hint">(Address of place of business)</span>

            <div class="acknowledgement">
                hereby acknowledges that the goods described in Appendix are purchased / transported with exemption from sales tax
                claimed under Item 58A Schedule A, Sales Tax (Persons Exempted From Payment of Tax) Order 2018 subject to the
                conditions as specified.
            </div>
        </div>

        <!-- Blok Tandatangan (Kanan) -->
        <div class="signature-right">
            <table>
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
        </div>

        <!-- Blok Tarikh Sebaris -->
        <div class="dates-container">
            <table class="dates-table">
                <tr>
                    <td style="text-align: left;">
                        Date: <span class="date-line" style="min-width: 110pt;">{{ $permohonan->tarikh_diluluskan?->format('d/m/Y') ?? '-' }}</span>
                    </td>
                    <td style="text-align: right;">
                        Expiry date of exemption certificate : <span class="date-line" style="min-width: 110pt;">{{ $certificateExpiryDate }}</span>
                    </td>
                </tr>
            </table>
        </div>

        <div class="computer-note">This document is computer printed and digitally signed. No signature is required</div>
    </div>

    <!-- Muka Surat 2: Notis & Syarat -->
    <div class="sheet">
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

    <!-- Muka Surat 3: Lampiran Barangan & Kawasan -->
    <div class="sheet">
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
                    <th style="width: 80pt;">No. Kod Tariff</th>
                    <th style="width: 120pt;">Perihal Barangan</th>
                    <th style="width: 130pt;">Deskripsi</th>
                    <th style="width: 85pt;">Kuantiti Dipohon</th>
                    <th style="width: 65pt;">Nilai</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangs as $index => $barang)
                    <tr>
                        <td class="number-cell">{{ $index + 1 }}</td>
                        <td style="text-align: center;">{{ $barang['kod_tarif'] ?? '-' }}</td>
                        <td>{{ $barang['perihal'] ?? '-' }}</td>
                        <td>{{ $barang['deskripsi'] ?? '-' }}</td>
                        <td style="text-align: center;">{{ $barang['kuantiti'] ?? '-' }} {{ $barang['unit'] ?? '' }}</td>
                        <td style="text-align: right;">{{ isset($barang['nilai']) ? number_format((float) $barang['nilai'], 2) : '-' }}</td>
                    </tr>
                @empty
                    <tr><td class="number-cell">1</td><td colspan="5" style="text-align: center;">-</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="area-title">
            Kawasan Yang Diluluskan Bagi Menjalankan Aktiviti Bunkering Di Bawah Butiran 58, Jadual A,<br>
            Perintah Cukai Jualan (Orang Yang Dikecualikan Daripada Pembayaran Cukai) 2018
        </div>

        <div class="appendix-subtitle">Bahagian E: Kawasan Yang Diluluskan Bagi Menjalankan Aktiviti Bunkering<br>Part E: Approved Area For Business</div>
        <table class="goods-table area-table">
            <thead>
                <tr>
                    <th style="width: 28pt;">Bil</th>
                    <th>Nama Kawasan<br>Name Of Area</th>
                </tr>
            </thead>
            <tbody>
                @forelse($approvedAreas as $index => $area)
                    <tr>
                        <td class="number-cell">{{ $index + 1 }}</td>
                        <td>{{ $area }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="number-cell">1</td>
                        <td style="text-align: center;">-</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
