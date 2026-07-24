<x-role-dashboard-layout
    role="admin"
    title="SEMAKAN PERMOHONAN"
    subtitle="Semakan pentadbir untuk permohonan pengecualian."
    :nav-items="[
        ['label' => 'UTAMA', 'url' => route('admin.utama'), 'active' => '/admin/utama'],
        ['label' => 'URUS PENGGUNA', 'url' => route('admin.uruspengguna'), 'active' => '/admin/uruspengguna'],
        ['label' => 'TAMBAH PENGGUNA', 'url' => route('admin.tambahpengguna'), 'active' => '/admin/tambahpengguna'],
        ['label' => 'SENARAI LAPORAN', 'url' => route('admin.senarailaporan'), 'active' => '/admin/senarailaporan'],
        ['label' => 'SENARAI PERMOHONAN', 'url' => route('admin.senaraipermohonan'), 'active' => '/admin/senaraipermohonan'],
    ]"
>
    <div class="space-y-6">
        @if ($errors->any())
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                Sila semak semula maklumat yang dimasukkan.
            </div>
        @endif

        <form action="{{ route('admin.permohonan.update', $permohonan) }}" method="POST" enctype="multipart/form-data" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-950/10">
            @csrf
            @method('PUT')

            <div class="mb-8 space-y-6">
                <h2 class="border-b border-slate-100 pb-3 text-xl font-bold text-slate-900">Maklumat Permohonan</h2>

                <section class="space-y-4">
                    <h3 class="text-lg font-semibold text-slate-800">BAHAGIAN A: MAKLUMAT PEMOHON</h3>
                    <div class="grid gap-5 md:grid-cols-2">
                        <label class="block">
                            <span class="text-sm font-semibold text-slate-700">Nama</span>
                            <input type="text" name="nama" value="{{ old('nama', $permohonan->nama) }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                        </label>
                        <label class="block">
                            <span class="text-sm font-semibold text-slate-700">No. Telefon</span>
                            <input type="text" name="no_telefon" value="{{ old('no_telefon', $permohonan->no_telefon) }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                        </label>
                        <label class="block">
                            <span class="text-sm font-semibold text-slate-700">Alamat E-mel</span>
                            <input type="email" name="email" value="{{ old('email', $permohonan->email) }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                        </label>
                        <label class="block">
                            <span class="text-sm font-semibold text-slate-700">No. Kad Pengenalan</span>
                            <input type="text" name="no_kp" value="{{ old('no_kp', $permohonan->no_kp) }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                        </label>
                        <label class="block">
                            <span class="text-sm font-semibold text-slate-700">Jawatan</span>
                            <input type="text" name="jawatan" value="{{ old('jawatan', $permohonan->jawatan) }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                        </label>
                        <label class="block">
                            <span class="text-sm font-semibold text-slate-700">Nama Syarikat</span>
                            <input type="text" name="nama_syarikat" value="{{ old('nama_syarikat', $permohonan->nama_syarikat) }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                        </label>
                        <label class="block">
                            <span class="text-sm font-semibold text-slate-700">No. Pendaftaran Cukai Jualan</span>
                            <input type="text" name="no_pendaftaran_cukai" value="{{ old('no_pendaftaran_cukai', $permohonan->no_pendaftaran_cukai) }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                        </label>
                        <label class="block">
                            <span class="text-sm font-semibold text-slate-700">Tarikh Permohonan</span>
                            <input type="date" name="tarikh_permohonan" value="{{ old('tarikh_permohonan', $permohonan->tarikh_permohonan?->format('Y-m-d')) }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                        </label>
                        <label class="block">
                            <span class="text-sm font-semibold text-slate-700">No. Kelulusan (PDA2, JKDM dll)</span>
                            <input type="text" name="no_kelulusan" value="{{ old('no_kelulusan', $permohonan->no_kelulusan) }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                        </label>
                        <label class="block">
                            <span class="text-sm font-semibold text-slate-700">No. Pesanan Belian</span>
                            <input type="text" name="no_pesanan_belian" value="{{ old('no_pesanan_belian', $permohonan->no_pesanan_belian) }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                        </label>
                        <label class="block md:col-span-2">
                            <span class="text-sm font-semibold text-slate-700">Alamat</span>
                            <textarea name="alamat" rows="3" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">{{ old('alamat', $permohonan->alamat) }}</textarea>
                        </label>
                        <label class="block md:col-span-2">
                            <span class="text-sm font-semibold text-slate-700">Negeri (stesen dipohon)</span>
                            <select name="negeri" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                                <option value="">Sila pilih negeri</option>
                                @foreach(['Johor','Kedah','Kelantan','Melaka','Negeri Sembilan','Pahang','Perak','Perlis','Penang','Sabah','Sarawak','Selangor','Terengganu','WP Kuala Lumpur','WP Labuan','WP Putrajaya'] as $state)
                                    <option value="{{ $state }}" @selected(old('negeri', $permohonan->negeri) === $state)>{{ $state }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                </section>

                <section class="space-y-4">
                    <h3 class="text-lg font-semibold text-slate-800">BAHAGIAN B: MAKLUMAT ORANG YANG AKAN MENANDATANGANI SIJIL PENGECUALIAN</h3>
                    <div class="grid gap-5 md:grid-cols-3">
                        <label class="block">
                            <span class="text-sm font-semibold text-slate-700">Nama Pemohon</span>
                            <input type="text" name="tandatangan_nama" value="{{ old('tandatangan_nama', $permohonan->tandatangan_nama) }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                        </label>
                        <label class="block">
                            <span class="text-sm font-semibold text-slate-700">No KP Pemohon</span>
                            <input type="text" name="tandatangan_no_kp" value="{{ old('tandatangan_no_kp', $permohonan->tandatangan_no_kp) }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                        </label>
                        <label class="block">
                            <span class="text-sm font-semibold text-slate-700">Jawatan</span>
                            <input type="text" name="tandatangan_jawatan" value="{{ old('tandatangan_jawatan', $permohonan->tandatangan_jawatan) }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                        </label>
                    </div>
                </section>

                <section class="space-y-4">
                    <h3 class="text-lg font-semibold text-slate-800">BAHAGIAN C: MAKLUMAT PEMBEKAL</h3>
                    <div class="grid gap-5 md:grid-cols-2">
                        <label class="block">
                            <span class="text-sm font-semibold text-slate-700">Nama Firma/Syarikat</span>
                            <input type="text" name="pembekal_nama" value="{{ old('pembekal_nama', $permohonan->pembekal_nama) }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                        </label>
                        <label class="block">
                            <span class="text-sm font-semibold text-slate-700">Alamat</span>
                            <textarea name="pembekal_alamat" rows="3" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">{{ old('pembekal_alamat', $permohonan->pembekal_alamat) }}</textarea>
                        </label>
                    </div>
                </section>

                <section class="space-y-4">
                    <h3 class="text-lg font-semibold text-slate-800">BAHAGIAN D: PERIHAL BARANG-BARANG</h3>
                    <div class="overflow-x-auto rounded-xl border border-slate-200">
                        <table class="min-w-[1050px] w-full text-sm text-slate-700">
                            <thead class="bg-slate-100 text-left">
                                <tr>
                                    <th class="px-3 py-2">No Kod Tarif</th>
                                    <th class="px-3 py-2">Perihal Barangan</th>
                                    <th class="px-3 py-2">Unit</th>
                                    <th class="px-3 py-2">Deskripsi</th>
                                    <th class="px-3 py-2">Kuantiti</th>
                                    <th class="px-3 py-2">Nilai (RM)</th>
                                    <th class="px-3 py-2">Nama Kawasan</th>
                                    <th class="px-3 py-2 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="admin-barang-body" class="divide-y divide-slate-100 bg-white">
                                @forelse(old('kod_tarif', collect($permohonan->barangs ?? [])->pluck('kod_tarif')->all()) as $index => $kodTarif)
                                    <tr>
                                        <td class="px-3 py-2"><input name="kod_tarif[]" value="{{ $kodTarif }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></td>
                                        <td class="px-3 py-2"><input name="perihal_barang[]" value="{{ old("perihal_barang.$index", $permohonan->barangs[$index]['perihal'] ?? '') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></td>
                                        <td class="px-3 py-2"><input name="unit[]" value="{{ old("unit.$index", $permohonan->barangs[$index]['unit'] ?? '') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></td>
                                        <td class="px-3 py-2"><input name="deskripsi[]" value="{{ old("deskripsi.$index", $permohonan->barangs[$index]['deskripsi'] ?? '') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></td>
                                        <td class="px-3 py-2"><input type="number" step="any" name="kuantiti[]" value="{{ old("kuantiti.$index", $permohonan->barangs[$index]['kuantiti'] ?? '') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></td>
                                        <td class="px-3 py-2"><input type="number" step="any" name="nilai[]" value="{{ old("nilai.$index", $permohonan->barangs[$index]['nilai'] ?? '') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></td>
                                        <td class="px-3 py-2"><input name="kawasan[]" value="{{ old("kawasan.$index", $permohonan->barangs[$index]['kawasan'] ?? '') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></td>
                                        <td class="px-3 py-2 text-center"><button type="button" onclick="removeAdminBarangRow(this)" class="rounded-md bg-rose-600 px-3 py-1 text-xs font-semibold text-white hover:bg-rose-700">Hapus</button></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-3 py-2"><input name="kod_tarif[]" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></td>
                                        <td class="px-3 py-2"><input name="perihal_barang[]" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></td>
                                        <td class="px-3 py-2"><input name="unit[]" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></td>
                                        <td class="px-3 py-2"><input name="deskripsi[]" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></td>
                                        <td class="px-3 py-2"><input type="number" step="any" name="kuantiti[]" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></td>
                                        <td class="px-3 py-2"><input type="number" step="any" name="nilai[]" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></td>
                                        <td class="px-3 py-2"><input name="kawasan[]" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></td>
                                        <td class="px-3 py-2 text-center"><button type="button" onclick="removeAdminBarangRow(this)" class="rounded-md bg-rose-600 px-3 py-1 text-xs font-semibold text-white hover:bg-rose-700">Hapus</button></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <button type="button" onclick="addAdminBarangRow()" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">Tambah Baris</button>
                </section>

                <section class="space-y-4">
                    <h3 class="text-lg font-semibold text-slate-800">Lampiran Sedia Ada</h3>
                    @if(!empty($permohonan->attachments))
                        <div class="flex flex-wrap gap-2">
                            @foreach($permohonan->attachments as $index => $attachment)
                                <a href="{{ asset('storage/'.$attachment) }}" target="_blank" class="rounded-md bg-blue-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-blue-700">Lampiran {{ $index + 1 }}</a>
                            @endforeach
                        </div>
                    @else
                        <p class="rounded-lg border border-dashed border-slate-300 bg-slate-50 p-4 text-sm text-slate-500">Tiada lampiran dimuat naik.</p>
                    @endif
                </section>
            </div>

            <div class="mb-6 inline-flex rounded-md bg-blue-500 px-12 py-2 text-lg font-semibold uppercase text-white shadow">
                Ulasan JKDM
            </div>

            <div class="grid gap-5">
                <label class="block">
                    <span class="text-sm font-semibold text-slate-700">Ulasan Pegawai Kanan</span>
                    <textarea name="ulasan_jkdm" rows="4" class="mt-1 w-full rounded-lg border border-blue-400 px-3 py-2 focus:border-blue-600 focus:outline-none">{{ old('ulasan_jkdm', $permohonan->ulasan_jkdm) }}</textarea>
                </label>

                <div class="grid gap-4 md:grid-cols-3">
                    <label class="block">
                        <span class="text-sm font-semibold text-slate-700">Nama Pegawai</span>
                        <input type="text" name="nama_pegawai_jkdm" value="{{ old('nama_pegawai_jkdm', $permohonan->nama_pegawai_jkdm) }}" class="mt-1 w-full rounded-lg border border-blue-400 px-3 py-2 focus:border-blue-600 focus:outline-none">
                    </label>
                    <label class="block">
                        <span class="text-sm font-semibold text-slate-700">Tarikh Ulasan</span>
                        <input type="date" name="tarikh_ulasan_jkdm" value="{{ old('tarikh_ulasan_jkdm', $permohonan->tarikh_ulasan_jkdm?->format('Y-m-d')) }}" class="mt-1 w-full rounded-lg border border-blue-400 px-3 py-2 focus:border-blue-600 focus:outline-none">
                    </label>
                    <label class="block">
                        <span class="text-sm font-semibold text-slate-700">Tarikh Tamat CGA</span>
                        <input type="date" name="tarikh_tamat_cga" value="{{ old('tarikh_tamat_cga', $permohonan->tarikh_tamat_cga?->format('Y-m-d')) }}" class="mt-1 w-full rounded-lg border border-blue-400 px-3 py-2 focus:border-blue-600 focus:outline-none">
                    </label>
                </div>

                <div class="rounded-lg border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                    Keputusan Pengarah Kastam Negeri, Tarikh Diluluskan, Tarikh Tamat dan No. Sijil akan diisi oleh Pelulus.
                </div>
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <button type="submit" class="rounded-lg bg-emerald-600 px-10 py-2.5 font-bold text-white shadow hover:bg-emerald-700">Hantar</button>
                <a href="{{ route('admin.permohonan.pdf', $permohonan) }}" class="rounded-lg bg-red-600 px-10 py-2.5 font-bold text-white shadow hover:bg-red-700">Print PDF</a>
                <a href="{{ route('admin.senaraipermohonan') }}" class="rounded-lg bg-blue-500 px-10 py-2.5 font-bold text-white shadow hover:bg-blue-600">Kembali</a>
            </div>
        </form>
    </div>

    <script>
        function addAdminBarangRow() {
            const body = document.getElementById('admin-barang-body');
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="px-3 py-2"><input name="kod_tarif[]" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></td>
                <td class="px-3 py-2"><input name="perihal_barang[]" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></td>
                <td class="px-3 py-2"><input name="unit[]" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></td>
                <td class="px-3 py-2"><input name="deskripsi[]" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></td>
                <td class="px-3 py-2"><input type="number" step="any" name="kuantiti[]" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></td>
                <td class="px-3 py-2"><input type="number" step="any" name="nilai[]" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></td>
                <td class="px-3 py-2"><input name="kawasan[]" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></td>
                <td class="px-3 py-2 text-center"><button type="button" onclick="removeAdminBarangRow(this)" class="rounded-md bg-rose-600 px-3 py-1 text-xs font-semibold text-white hover:bg-rose-700">Hapus</button></td>
            `;
            body.appendChild(row);
        }

        function removeAdminBarangRow(button) {
            const row = button.closest('tr');

            if (row) {
                row.remove();
            }
        }
    </script>
</x-role-dashboard-layout>
