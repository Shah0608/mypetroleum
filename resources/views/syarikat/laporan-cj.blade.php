<x-role-dashboard-layout
    role="syarikat"
    title="LAPORAN CJ(P)"
    subtitle="Sistem Maklumat Bunker Petroleum"
    :nav-items="[
        ['label' => 'UTAMA', 'url' => route('syarikat.utama'), 'route' => 'syarikat.utama', 'active' => '/syarikat/utama'],
        ['label' => 'PERMOHONAN', 'url' => route('syarikat.permohonan-58a'), 'route' => 'syarikat.permohonan-58a', 'active' => '/syarikat/permohonan-58a'],
        ['label' => 'SENARAI PERMOHONAN', 'url' => route('syarikat.senaraipermohonan'), 'route' => 'syarikat.senaraipermohonan', 'active' => '/syarikat/senaraipermohonan'],
        ['label' => 'LAPORAN CJ(P)', 'url' => route('syarikat.laporan-cj'), 'route' => 'syarikat.laporan-cj', 'active' => '/syarikat/laporan-cj'],
        ['label' => 'SENARAI LAPORAN CJ(P)', 'url' => route('syarikat.senarailaporan'), 'route' => 'syarikat.senarailaporan', 'active' => '/syarikat/senarailaporan'],
    ]"
>
    @php
        $certificates = $permohonans->map(fn ($permohonan) => [
            'id' => $permohonan->id,
            'nama_syarikat' => $permohonan->nama_syarikat,
            'alamat' => $permohonan->alamat,
            'negeri' => $permohonan->negeri,
            'no_sijil' => $permohonan->no_sijil_pengecualian,
            'tarikh_sah_laku' => $permohonan->tarikh_diluluskan?->format('d/m/Y'),
            'tarikh_tamat' => $permohonan->tarikh_tamat?->format('d/m/Y'),
            'barangs' => collect($permohonan->barangs ?? [])->values()->map(fn ($barang, $index) => [
                'index' => $index,
                'label' => ($barang['kod_tarif'] ?? '-') . ' - ' . ($barang['perihal'] ?? 'Barang'),
                'kuantiti' => $barang['kuantiti'] ?? 0,
                'unit' => $barang['unit'] ?? 'Ltr',
            ]),
        ])->values();
    @endphp

    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-lg shadow-slate-950/10">
            <div class="border-b border-slate-100 pb-4">
                <h2 class="text-xl font-bold text-slate-900">Laporan Bulanan Pembelian dan Penjualan Barang Pengecualian Cukai 58A</h2>
                <p class="mt-1 text-sm text-slate-500">Maklumat syarikat, sijil dan barang dipraisi daripada permohonan 58A yang telah diluluskan.</p>
            </div>

            @if ($permohonans->isEmpty())
                <div class="mt-6 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">Tiada sijil pengecualian yang telah diluluskan. Laporan CJ(P) boleh diisi selepas permohonan 58A diluluskan oleh Pelulus.</div>
            @else
                <form action="{{ route('syarikat.laporan-cj.store') }}" method="POST" class="mt-6 space-y-8" id="laporan-cjp-form">
                    @csrf

                    <section class="grid gap-5 rounded-xl border border-slate-200 bg-slate-50 p-5 md:grid-cols-2">
                        <div class="space-y-2"><label for="permohonan_58a_id" class="text-sm font-semibold text-slate-700">No. Sijil Pengecualian</label><select id="permohonan_58a_id" name="permohonan_58a_id" class="w-full rounded-lg border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500" required>@foreach ($certificates as $certificate)<option value="{{ $certificate['id'] }}" @selected((int) old('permohonan_58a_id', $certificates->first()['id']) === $certificate['id'])>{{ $certificate['no_sijil'] }}</option>@endforeach</select>@error('permohonan_58a_id')<p class="text-sm text-red-600">{{ $message }}</p>@enderror</div>
                        <div class="space-y-2"><label for="barang_index" class="text-sm font-semibold text-slate-700">Kod Tarif / Perihal Barang</label><select id="barang_index" name="barang_index" class="w-full rounded-lg border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500" required></select>@error('barang_index')<p class="text-sm text-red-600">{{ $message }}</p>@enderror</div>
                        <div class="space-y-2"><label class="text-sm font-semibold text-slate-700">Nama Syarikat</label><input id="nama-syarikat" type="text" readonly class="w-full rounded-lg border-slate-300 bg-white text-sm text-slate-700" /></div>
                        <div class="space-y-2"><label class="text-sm font-semibold text-slate-700">Alamat Syarikat</label><input id="alamat-syarikat" type="text" readonly class="w-full rounded-lg border-slate-300 bg-white text-sm text-slate-700" /></div>
                        <div class="space-y-2"><label class="text-sm font-semibold text-slate-700">Tarikh Sah Laku Sijil</label><input id="tarikh-sah-laku" type="text" readonly class="w-full rounded-lg border-slate-300 bg-white text-sm text-slate-700" /></div>
                        <div class="space-y-2"><label class="text-sm font-semibold text-slate-700">Sijil Sah Sehingga</label><input id="tarikh-tamat" type="text" readonly class="w-full rounded-lg border-slate-300 bg-white text-sm text-slate-700" /></div>
                    </section>

                    <section class="grid gap-5 rounded-xl border border-blue-100 bg-blue-50/50 p-5 md:grid-cols-2 lg:grid-cols-4">
                        <div class="space-y-2"><label for="negeri" class="text-sm font-semibold text-slate-700">Negeri</label><input id="negeri" name="negeri" value="{{ old('negeri') }}" readonly class="w-full rounded-lg border-slate-300 bg-white text-sm" required /></div>
                        <div class="space-y-2"><label for="bulan" class="text-sm font-semibold text-slate-700">Bulan</label><select id="bulan" name="bulan" class="w-full rounded-lg border-slate-300 text-sm" required>@foreach (['Januari','Februari','Mac','April','Mei','Jun','Julai','Ogos','September','Oktober','November','Disember'] as $bulan)<option value="{{ $bulan }}" @selected(old('bulan', now()->locale('ms')->translatedFormat('F')) === $bulan)>{{ $bulan }}</option>@endforeach</select></div>
                        <div class="space-y-2"><label for="tahun" class="text-sm font-semibold text-slate-700">Tahun</label><select id="tahun" name="tahun" class="w-full rounded-lg border-slate-300 text-sm" required>@foreach (range(now()->year - 1, now()->year + 2) as $tahun)<option value="{{ $tahun }}" @selected((int) old('tahun', now()->year) === $tahun)>{{ $tahun }}</option>@endforeach</select></div>
                        <div class="space-y-2"><label for="baki_awal" class="text-sm font-semibold text-slate-700">Baki Awal Belum Dijual</label><div class="flex gap-2"><input id="baki_awal" name="baki_awal" value="{{ old('baki_awal', 0) }}" type="number" min="0" step="1" class="w-full rounded-lg border-slate-300 text-sm" /><span id="unit-baki-awal" class="rounded-lg bg-white px-3 py-2 text-sm font-semibold text-slate-600">Ltr</span></div></div>
                        <div class="space-y-2"><label class="text-sm font-semibold text-slate-700">Kuantiti Diluluskan</label><div class="flex gap-2"><input id="kuantiti-diluluskan" type="text" readonly class="w-full rounded-lg border-slate-300 bg-white text-sm" /><span id="unit-diluluskan" class="rounded-lg bg-white px-3 py-2 text-sm font-semibold text-slate-600">Ltr</span></div></div>
                        <div class="space-y-2"><label class="text-sm font-semibold text-slate-700">Baki Kuantiti Diluluskan</label><div class="flex gap-2"><input id="baki-diluluskan" type="text" readonly class="w-full rounded-lg border-slate-300 bg-white text-sm" /><span id="unit-baki-diluluskan" class="rounded-lg bg-white px-3 py-2 text-sm font-semibold text-slate-600">Ltr</span></div></div>
                        <div class="space-y-2"><label class="text-sm font-semibold text-slate-700">Baki Akhir Belum Dijual</label><div class="flex gap-2"><input id="baki-akhir" type="text" readonly class="w-full rounded-lg border-slate-300 bg-white text-sm" /><span id="unit-baki-akhir" class="rounded-lg bg-white px-3 py-2 text-sm font-semibold text-slate-600">Ltr</span></div></div>
                    </section>

                    <section class="space-y-4 rounded-xl border border-slate-200 p-5"><div class="flex flex-wrap items-center justify-between gap-3"><div><h3 class="font-bold text-slate-900">Pembelian dari Pengilang Berdaftar / Kawasan Khas</h3><p class="text-sm text-slate-500">Boleh tambah lebih daripada satu rekod pembelian.</p></div><button type="button" data-add-row="pembelian" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">Tambah Pembelian</button></div><div id="pembelian-rows" class="space-y-3"></div></section>
                    <section class="space-y-4 rounded-xl border border-slate-200 p-5"><div class="flex flex-wrap items-center justify-between gap-3"><div><h3 class="font-bold text-slate-900">Penjualan</h3><p class="text-sm text-slate-500">Boleh tambah lebih daripada satu rekod penjualan.</p></div><button type="button" data-add-row="penjualan" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">Tambah Penjualan</button></div><div id="penjualan-rows" class="space-y-3"></div></section>
                    <section class="grid gap-5 rounded-xl border border-slate-200 bg-slate-50 p-5 md:grid-cols-3"><div class="space-y-2"><label for="nama_penuh" class="text-sm font-semibold text-slate-700">Nama Penuh</label><input id="nama_penuh" name="nama_penuh" value="{{ old('nama_penuh', auth()->user()?->name) }}" class="w-full rounded-lg border-slate-300 text-sm" required />@error('nama_penuh')<p class="text-sm text-red-600">{{ $message }}</p>@enderror</div><div class="space-y-2"><label for="jawatan" class="text-sm font-semibold text-slate-700">Jawatan</label><input id="jawatan" name="jawatan" value="{{ old('jawatan') }}" class="w-full rounded-lg border-slate-300 text-sm" required />@error('jawatan')<p class="text-sm text-red-600">{{ $message }}</p>@enderror</div><div class="space-y-2"><label for="no_telefon" class="text-sm font-semibold text-slate-700">No. Telefon</label><input id="no_telefon" name="no_telefon" value="{{ old('no_telefon') }}" class="w-full rounded-lg border-slate-300 text-sm" required />@error('no_telefon')<p class="text-sm text-red-600">{{ $message }}</p>@enderror</div></section>
                    <div class="flex justify-end"><button type="submit" class="rounded-lg bg-emerald-600 px-7 py-3 text-sm font-bold text-white shadow hover:bg-emerald-700">Hantar dan Jana Laporan PDF</button></div>
                </form>
            @endif
        </div>
    </div>

    <template id="pembelian-template"><div class="pembelian-row grid gap-3 rounded-lg border border-slate-200 bg-slate-50 p-4 md:grid-cols-6"><input type="date" name="pembelians[__INDEX__][tarikh]" class="rounded-lg border-slate-300 text-sm"><input name="pembelians[__INDEX__][no_invois]" placeholder="No. Invois / DO" class="rounded-lg border-slate-300 text-sm"><input name="pembelians[__INDEX__][no_k9]" placeholder="No. K9" class="rounded-lg border-slate-300 text-sm"><input data-quantity type="number" min="0" step="1" name="pembelians[__INDEX__][kuantiti]" placeholder="Kuantiti" class="rounded-lg border-slate-300 text-sm"><input type="number" min="0" step="0.01" name="pembelians[__INDEX__][nilai]" placeholder="Nilai (RM)" class="rounded-lg border-slate-300 text-sm"><button type="button" data-remove-row class="rounded-lg bg-red-50 px-3 py-2 text-sm font-semibold text-red-700 hover:bg-red-100">Buang</button></div></template>
    <template id="penjualan-template"><div class="penjualan-row grid gap-3 rounded-lg border border-slate-200 bg-slate-50 p-4 md:grid-cols-7"><input type="date" name="penjualans[__INDEX__][tarikh]" class="rounded-lg border-slate-300 text-sm"><input name="penjualans[__INDEX__][nama_kapal]" placeholder="Nama Kapal Penerima" class="rounded-lg border-slate-300 text-sm"><input name="penjualans[__INDEX__][pelabuhan]" placeholder="Pelabuhan Penerima" class="rounded-lg border-slate-300 text-sm"><input name="penjualans[__INDEX__][no_invois]" placeholder="No. Invois / DO" class="rounded-lg border-slate-300 text-sm"><input data-quantity type="number" min="0" step="1" name="penjualans[__INDEX__][kuantiti]" placeholder="Kuantiti" class="rounded-lg border-slate-300 text-sm"><input type="number" min="0" step="0.01" name="penjualans[__INDEX__][nilai]" placeholder="Nilai (RM)" class="rounded-lg border-slate-300 text-sm"><button type="button" data-remove-row class="rounded-lg bg-red-50 px-3 py-2 text-sm font-semibold text-red-700 hover:bg-red-100">Buang</button></div></template>

    <script>
        const reportCertificates = @json($certificates);
        const certificateSelect = document.getElementById('permohonan_58a_id');
        const itemSelect = document.getElementById('barang_index');
        const activeCertificate = () => reportCertificates.find((certificate) => certificate.id === Number(certificateSelect.value));
        const number = (value) => Number(value || 0);
        const sumRows = (selector) => Array.from(document.querySelectorAll(`${selector} [data-quantity]`)).reduce((sum, input) => sum + number(input.value), 0);
        function updateBalances() { const item = activeCertificate()?.barangs.find((barang) => barang.index === Number(itemSelect.value)); const approved = number(item?.kuantiti); const purchases = sumRows('#pembelian-rows'); const sales = sumRows('#penjualan-rows'); const opening = number(document.getElementById('baki_awal').value); document.getElementById('kuantiti-diluluskan').value = approved.toLocaleString('en-MY', { maximumFractionDigits: 0 }); document.getElementById('baki-diluluskan').value = Math.max(0, approved - purchases).toLocaleString('en-MY', { maximumFractionDigits: 0 }); document.getElementById('baki-akhir').value = (opening + purchases - sales).toLocaleString('en-MY', { maximumFractionDigits: 0 }); }
        function loadCertificate() { const certificate = activeCertificate(); if (!certificate) return; document.getElementById('nama-syarikat').value = certificate.nama_syarikat || ''; document.getElementById('alamat-syarikat').value = certificate.alamat || ''; document.getElementById('negeri').value = certificate.negeri || ''; document.getElementById('tarikh-sah-laku').value = certificate.tarikh_sah_laku || ''; document.getElementById('tarikh-tamat').value = certificate.tarikh_tamat || ''; itemSelect.innerHTML = certificate.barangs.map((barang) => `<option value="${barang.index}">${barang.label}</option>`).join(''); loadItem(); }
        function loadItem() { ['unit-baki-awal', 'unit-diluluskan', 'unit-baki-diluluskan', 'unit-baki-akhir'].forEach((id) => document.getElementById(id).textContent = 'Ltr'); updateBalances(); }
        function addRow(type) { const container = document.getElementById(`${type}-rows`); const template = document.getElementById(`${type}-template`).innerHTML; container.insertAdjacentHTML('beforeend', template.replaceAll('__INDEX__', container.children.length)); updateBalances(); }
        certificateSelect.addEventListener('change', loadCertificate); itemSelect.addEventListener('change', loadItem); document.getElementById('laporan-cjp-form').addEventListener('input', updateBalances); document.querySelectorAll('[data-add-row]').forEach((button) => button.addEventListener('click', () => addRow(button.dataset.addRow))); document.addEventListener('click', (event) => { if (event.target.matches('[data-remove-row]')) { event.target.closest('.pembelian-row, .penjualan-row').remove(); updateBalances(); } }); addRow('pembelian'); addRow('penjualan'); loadCertificate();
    </script>
</x-role-dashboard-layout>
