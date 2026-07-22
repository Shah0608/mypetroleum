<x-role-dashboard-layout
    role="syarikat"
    title="BORANG 58A"
    subtitle="Permohonan untuk syarikat/pemilik."
    :nav-items="[
        ['label' => 'UTAMA', 'url' => route('syarikat.utama'), 'route' => 'syarikat.utama', 'active' => '/syarikat/utama'],
        ['label' => 'PERMOHONAN', 'url' => route('syarikat.permohonan-58a'), 'route' => 'syarikat.permohonan-58a', 'active' => '/syarikat/permohonan-58a'],
        ['label' => 'SENARAI PERMOHONAN', 'url' => route('syarikat.senaraipermohonan'), 'route' => 'syarikat.senaraipermohonan', 'active' => '/syarikat/senaraipermohonan'],
        ['label' => 'LAPORAN CJ(P)', 'url' => route('syarikat.laporan-cj'), 'route' => 'syarikat.laporan-cj', 'active' => '/syarikat/laporan-cj'],
        ['label' => 'SENARAI LAPORAN CJ(P)', 'url' => route('syarikat.senarailaporan'), 'route' => 'syarikat.senarailaporan', 'active' => '/syarikat/senarailaporan'],
    ]"
>
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-lg shadow-slate-950/10">
            <div class="mb-5 border-b border-slate-100 pb-4">
                <h2 class="text-xl font-semibold text-slate-900">Permohonan Pengecualian Cukai Jualan di bawah Butiran 58A</h2>
                <p class="mt-1 text-sm text-slate-500">Lengkapkan borang berikut untuk menghantar permohonan.</p>
            </div>

            <form action="{{ route('syarikat.permohonan-58a.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <section class="space-y-4">
                    <h3 class="text-lg font-semibold text-slate-800">BAHAGIAN A: MAKLUMAT PEMOHON</h3>
                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-slate-700">Nama</label>
                            <input type="text" name="nama" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none" />
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-slate-700">No. Telefon</label>
                            <input type="text" name="no_telefon" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none" />
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-slate-700">Alamat E-mel</label>
                            <input type="email" name="email" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none" />
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-slate-700">No. Kad Pengenalan</label>
                            <input type="text" name="no_kp" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none" />
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-slate-700">Jawatan</label>
                            <input type="text" name="jawatan" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none" />
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-slate-700">Nama Syarikat</label>
                            <input type="text" name="nama_syarikat" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none" />
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-slate-700">No. Pendaftaran Cukai Jualan (jika berkenaan)</label>
                            <input type="text" name="no_pendaftaran_cukai" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none" />
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-slate-700">Tarikh permohonan (dd/mm/yyyy)</label>
                            <input type="date" name="tarikh_permohonan" lang="ms-MY" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none" />
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-slate-700">No. Kelulusan (PDA2, JKDM dll)</label>
                            <input type="text" name="no_kelulusan" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none" />
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-slate-700">No. Pesanan Belian</label>
                            <input type="text" name="no_pesanan_belian" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none" />
                        </div>
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-sm font-medium text-slate-700">Alamat</label>
                            <textarea name="alamat" rows="3" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none"></textarea>
                        </div>
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-sm font-medium text-slate-700">Negeri (stesen dipohon)</label>
                            <select name="negeri" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none">
                                <option value="">Sila pilih negeri</option>
                                @foreach(['Johor','Kedah','Kelantan','Melaka','Negeri Sembilan','Pahang','Perak','Perlis','Penang','Sabah','Sarawak','Selangor','Terengganu','WP Kuala Lumpur','WP Labuan','WP Putrajaya'] as $state)
                                    <option value="{{ $state }}">{{ $state }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </section>

                <section class="space-y-4">
                    <h3 class="text-lg font-semibold text-slate-800">BAHAGIAN B: MAKLUMAT ORANG YANG AKAN MENANDATANGANI SIJIL PENGECUALIAN</h3>
                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-slate-700">Nama Pemohon</label>
                            <input type="text" name="tandatangan_nama" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none" />
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-slate-700">No KP Pemohon</label>
                            <input type="text" name="tandatangan_no_kp" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none" />
                        </div>
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-sm font-medium text-slate-700">Jawatan</label>
                            <input type="text" name="tandatangan_jawatan" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none" />
                        </div>
                    </div>
                </section>

                <section class="space-y-4">
                    <h3 class="text-lg font-semibold text-slate-800">BAHAGIAN C: MAKLUMAT PEMBEKAL</h3>
                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-slate-700">Nama Firma/Syarikat</label>
                            <input type="text" name="pembekal_nama" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none" />
                        </div>
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-sm font-medium text-slate-700">Alamat</label>
                            <textarea name="pembekal_alamat" rows="3" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none"></textarea>
                        </div>
                    </div>
                </section>

                <section class="space-y-4">
                    <h3 class="text-lg font-semibold text-slate-800">BAHAGIAN D: PERIHAL BARANG-BARANG</h3>
                    <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <table class="min-w-full text-sm text-slate-700" id="barang-table">
                            <thead class="bg-slate-100 text-slate-800">
                                <tr>
                                    <th class="px-3 py-2 text-left">No Kod Tarif</th>
                                    <th class="px-3 py-2 text-left">Perihal Barangan</th>
                                    <th class="px-3 py-2 text-left">Unit</th>
                                    <th class="px-3 py-2 text-left">Deskripsi</th>
                                    <th class="px-3 py-2 text-left">Kuantiti</th>
                                    <th class="px-3 py-2 text-left">Nilai (RM)</th>
                                    <th class="px-3 py-2 text-left">Nama Kawasan</th>
                                    <th class="px-3 py-2 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 bg-white" id="barang-body">
                                <tr>
                                    <td class="px-3 py-2"><input name="kod_tarif[]" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none" /></td>
                                    <td class="px-3 py-2"><input name="perihal_barang[]" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none" /></td>
                                    <td class="px-3 py-2"><input name="unit[]" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none" /></td>
                                    <td class="px-3 py-2"><input name="deskripsi[]" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none" /></td>
                                    <td class="px-3 py-2"><input name="kuantiti[]" type="number" step="any" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none" /></td>
                                    <td class="px-3 py-2"><input name="nilai[]" type="number" step="any" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none" /></td>
                                    <td class="px-3 py-2"><input name="kawasan[]" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none" /></td>
                                    <td class="px-3 py-2 text-center"><button type="button" onclick="removeRow(this)" class="rounded-md bg-rose-600 px-3 py-1 text-sm font-semibold text-white hover:bg-rose-700">Hapus</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button type="button" onclick="addRow()" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">Tambah Baris</button>
                </section>

                <section class="space-y-4">
                    <h3 class="text-lg font-semibold text-slate-800">Muat Naik Fail Berkaitan</h3>
                    <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-4">
                        <label class="block text-sm font-medium text-slate-700">SSM, MAA, PDA2, Surat kelulusan ship chandler</label>
                        <input type="file" name="attachments[]" multiple class="mt-2 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none" />
                    </div>
                </section>

                <div class="flex flex-wrap gap-3 pt-4">
                    <button type="submit" class="rounded-lg bg-emerald-600 px-8 py-2.5 text-sm font-semibold text-white hover:bg-emerald-700">Hantar Permohonan</button>
                    <a href="{{ route('syarikat.senaraipermohonan') }}" class="rounded-lg border border-slate-300 px-8 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-100">Senarai Permohonan</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function addRow() {
            const body = document.getElementById('barang-body');
            const row = document.createElement('tr');
            row.className = 'border-t border-slate-200';
            row.innerHTML = `
                <td class="px-3 py-2"><input name="kod_tarif[]" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none" /></td>
                <td class="px-3 py-2"><input name="perihal_barang[]" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none" /></td>
                <td class="px-3 py-2"><input name="unit[]" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none" /></td>
                <td class="px-3 py-2"><input name="deskripsi[]" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none" /></td>
                <td class="px-3 py-2"><input name="kuantiti[]" type="number" step="any" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none" /></td>
                <td class="px-3 py-2"><input name="nilai[]" type="number" step="any" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none" /></td>
                <td class="px-3 py-2"><input name="kawasan[]" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none" /></td>
                <td class="px-3 py-2 text-center"><button type="button" onclick="removeRow(this)" class="rounded-md bg-rose-600 px-3 py-1 text-sm font-semibold text-white hover:bg-rose-700">Hapus</button></td>
            `;
            body.appendChild(row);
        }

        function removeRow(button) {
            const row = button.closest('tr');
            if (row) {
                row.remove();
            }
        }
    </script>
</x-role-dashboard-layout>
