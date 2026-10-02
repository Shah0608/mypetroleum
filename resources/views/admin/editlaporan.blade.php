<x-role-dashboard-layout
    role="admin"
    title="EDIT LAPORAN"
    subtitle="Sistem Maklumat Bunker Petroleum"
    :nav-items="[
        ['label' => 'UTAMA', 'url' => route('admin.utama'), 'active' => '/admin/utama'],
        ['label' => 'URUS PENGGUNA', 'url' => route('admin.uruspengguna'), 'active' => '/admin/uruspengguna'],
        ['label' => 'TAMBAH PENGGUNA', 'url' => route('admin.tambahpengguna'), 'active' => '/admin/tambahpengguna'],
        ['label' => 'SENARAI LAPORAN', 'url' => route('admin.senarailaporan'), 'active' => '/admin/senarailaporan'],
        ['label' => 'SENARAI PERMOHONAN', 'url' => route('admin.senaraipermohonan'), 'active' => '/admin/senaraipermohonan'],
    ]"
>
    @php
        $pembelians = old('pembelians', $laporan->pembelians ?: [[]]);
        $penjualans = old('penjualans', $laporan->penjualans ?: [[]]);
    @endphp

    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-lg shadow-slate-950/10">
            <div class="flex flex-col gap-3 border-b border-slate-100 pb-4 sm:flex-row sm:items-center sm:justify-between">
                <div><h2 class="text-xl font-bold text-slate-900">Edit Laporan CJ(P) Jadual A-58A</h2><p class="text-sm text-slate-500">Sijil: {{ $laporan->no_sijil_pengecualian ?? '-' }}</p></div>
                <a href="{{ route('admin.senarailaporan') }}" class="rounded-lg bg-slate-100 px-4 py-2 text-center text-sm font-semibold text-slate-700 hover:bg-slate-200">Kembali</a>
            </div>

            <form id="edit-laporan-cjp-form" action="{{ route('admin.laporan.update', $laporan) }}" method="POST" class="mt-6 space-y-7">
                @csrf
                @method('PUT')
                <section class="grid gap-5 rounded-xl border border-slate-200 bg-slate-50 p-5 md:grid-cols-2 lg:grid-cols-3">
                    <div class="space-y-2"><label for="negeri" class="text-sm font-semibold text-slate-700">Negeri</label><input id="negeri" name="negeri" value="{{ old('negeri', $laporan->negeri) }}" class="w-full rounded-lg border-slate-300 text-sm" required>@error('negeri')<p class="text-sm text-red-600">{{ $message }}</p>@enderror</div>
                    <div class="space-y-2"><label for="bulan" class="text-sm font-semibold text-slate-700">Bulan</label><select id="bulan" name="bulan" class="w-full rounded-lg border-slate-300 text-sm" required>@foreach (['Januari','Februari','Mac','April','Mei','Jun','Julai','Ogos','September','Oktober','November','Disember'] as $bulan)<option value="{{ $bulan }}" @selected(old('bulan', $laporan->bulan) === $bulan)>{{ $bulan }}</option>@endforeach</select></div>
                    <div class="space-y-2"><label for="tahun" class="text-sm font-semibold text-slate-700">Tahun</label><input id="tahun" name="tahun" type="number" min="2000" max="2100" value="{{ old('tahun', $laporan->tahun) }}" class="w-full rounded-lg border-slate-300 text-sm" required></div>
                    <div class="space-y-2"><label for="baki_awal" class="text-sm font-semibold text-slate-700">Baki Awal Belum Dijual</label><input id="baki_awal" name="baki_awal" type="number" min="0" step="1" value="{{ old('baki_awal', (int) $laporan->baki_awal) }}" class="w-full rounded-lg border-slate-300 text-sm"></div>
                    <div class="space-y-2"><label class="text-sm font-semibold text-slate-700">Kuantiti Diluluskan</label><input value="{{ number_format((float) $laporan->kuantiti_diluluskan, 0, '.', ',') }} {{ $laporan->unit }}" readonly class="w-full rounded-lg border-slate-300 bg-white text-sm"></div>
                    <div class="space-y-2"><label class="text-sm font-semibold text-slate-700">Baki Akhir (kiraan automatik)</label><input id="baki-akhir-preview" readonly class="w-full rounded-lg border-slate-300 bg-white text-sm"></div>
                </section>

                <section class="space-y-4 rounded-xl border border-slate-200 p-5"><div class="flex flex-wrap items-center justify-between gap-3"><h3 class="font-bold text-slate-900">Pembelian dari Pengilang Berdaftar / Kawasan Khas</h3><button type="button" data-add-row="pembelian" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">Tambah Pembelian</button></div><div id="pembelian-rows" class="space-y-3"></div></section>
                <section class="space-y-4 rounded-xl border border-slate-200 p-5"><div class="flex flex-wrap items-center justify-between gap-3"><h3 class="font-bold text-slate-900">Penjualan</h3><button type="button" data-add-row="penjualan" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">Tambah Penjualan</button></div><div id="penjualan-rows" class="space-y-3"></div></section>
                <section class="grid gap-5 rounded-xl border border-slate-200 bg-slate-50 p-5 md:grid-cols-3"><div class="space-y-2"><label for="nama_penuh" class="text-sm font-semibold text-slate-700">Nama Penuh</label><input id="nama_penuh" name="nama_penuh" value="{{ old('nama_penuh', $laporan->nama_penuh) }}" class="w-full rounded-lg border-slate-300 text-sm" required></div><div class="space-y-2"><label for="jawatan" class="text-sm font-semibold text-slate-700">Jawatan</label><input id="jawatan" name="jawatan" value="{{ old('jawatan', $laporan->jawatan) }}" class="w-full rounded-lg border-slate-300 text-sm" required></div><div class="space-y-2"><label for="no_telefon" class="text-sm font-semibold text-slate-700">No. Telefon</label><input id="no_telefon" name="no_telefon" value="{{ old('no_telefon', $laporan->no_telefon) }}" class="w-full rounded-lg border-slate-300 text-sm" required></div></section>
                <div class="flex justify-end gap-3"><a href="{{ route('admin.senarailaporan') }}" class="rounded-lg bg-slate-200 px-6 py-3 text-sm font-bold text-slate-700 hover:bg-slate-300">Batal</a><button type="submit" class="rounded-lg bg-emerald-600 px-6 py-3 text-sm font-bold text-white hover:bg-emerald-700">Simpan Perubahan</button></div>
            </form>
        </div>
    </div>

    <template id="pembelian-template"><div class="pembelian-row grid gap-3 rounded-lg border border-slate-200 bg-slate-50 p-4 md:grid-cols-6"><input type="date" data-field="tarikh" class="rounded-lg border-slate-300 text-sm"><input data-field="no_invois" placeholder="No. Invois / DO" class="rounded-lg border-slate-300 text-sm"><input data-field="no_k9" placeholder="No. K9" class="rounded-lg border-slate-300 text-sm"><input data-quantity data-field="kuantiti" type="number" min="0" step="1" placeholder="Kuantiti" class="rounded-lg border-slate-300 text-sm"><input data-field="nilai" type="number" min="0" step="0.01" placeholder="Nilai (RM)" class="rounded-lg border-slate-300 text-sm"><button type="button" data-remove-row class="rounded-lg bg-red-50 px-3 py-2 text-sm font-semibold text-red-700 hover:bg-red-100">Buang</button></div></template>
    <template id="penjualan-template"><div class="penjualan-row grid gap-3 rounded-lg border border-slate-200 bg-slate-50 p-4 md:grid-cols-7"><input type="date" data-field="tarikh" class="rounded-lg border-slate-300 text-sm"><input data-field="nama_kapal" placeholder="Nama Kapal Penerima" class="rounded-lg border-slate-300 text-sm"><input data-field="pelabuhan" placeholder="Pelabuhan Penerima" class="rounded-lg border-slate-300 text-sm"><input data-field="no_invois" placeholder="No. Invois / DO" class="rounded-lg border-slate-300 text-sm"><input data-quantity data-field="kuantiti" type="number" min="0" step="1" placeholder="Kuantiti" class="rounded-lg border-slate-300 text-sm"><input data-field="nilai" type="number" min="0" step="0.01" placeholder="Nilai (RM)" class="rounded-lg border-slate-300 text-sm"><button type="button" data-remove-row class="rounded-lg bg-red-50 px-3 py-2 text-sm font-semibold text-red-700 hover:bg-red-100">Buang</button></div></template>

    <script>
        const existingPurchases = @json($pembelians);
        const existingSales = @json($penjualans);
        const approvedQuantity = {{ (int) $laporan->kuantiti_diluluskan }};
        const fields = { pembelian: 'pembelians', penjualan: 'penjualans' };
        const numeric = (value) => Number(value || 0);
        const total = (selector) => Array.from(document.querySelectorAll(`${selector} [data-quantity]`)).reduce((sum, input) => sum + numeric(input.value), 0);
        function updateBalances() { const purchased = total('#pembelian-rows'); const sold = total('#penjualan-rows'); const opening = numeric(document.getElementById('baki_awal').value); document.getElementById('baki-akhir-preview').value = (opening + purchased - sold).toLocaleString('en-MY', { maximumFractionDigits: 0 }); }
        function addRow(type, values = {}) { const container = document.getElementById(`${type}-rows`); const element = document.getElementById(`${type}-template`).content.firstElementChild.cloneNode(true); const index = container.children.length; element.querySelectorAll('[data-field]').forEach((input) => { const field = input.dataset.field; input.name = `${fields[type]}[${index}][${field}]`; input.value = values[field] ?? ''; }); container.appendChild(element); updateBalances(); }
        existingPurchases.forEach((row) => addRow('pembelian', row)); existingSales.forEach((row) => addRow('penjualan', row));
        document.querySelectorAll('[data-add-row]').forEach((button) => button.addEventListener('click', () => addRow(button.dataset.addRow)));
        document.getElementById('edit-laporan-cjp-form').addEventListener('input', updateBalances);
        document.addEventListener('click', (event) => { if (event.target.matches('[data-remove-row]')) { event.target.closest('.pembelian-row, .penjualan-row').remove(); updateBalances(); } });
        updateBalances();
    </script>
</x-role-dashboard-layout>
