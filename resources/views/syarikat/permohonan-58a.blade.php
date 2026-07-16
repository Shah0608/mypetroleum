<x-role-dashboard-layout
    role="syarikat"
    title="BORANG 58A"
    subtitle="Permohonan untuk syarikat/pemilik."
    :nav-items="[
        ['label' => 'UTAMA', 'url' => route('syarikat.utama'), 'active' => '/syarikat/utama'],
        ['label' => 'BORANG 58A', 'url' => route('syarikat.permohonan-58a'), 'active' => '/syarikat/permohonan-58a'],
        ['label' => 'LAPORAN CJ', 'url' => route('syarikat.laporan-cj'), 'active' => '/syarikat/laporan-cj'],
        ['label' => 'SENARAI LAPORAN', 'url' => route('syarikat.senarailaporan'), 'active' => '/syarikat/senarailaporan'],
        ['label' => 'SENARAI PERMOHONAN', 'url' => route('syarikat.senaraipermohonan'), 'active' => '/syarikat/senaraipermohonan'],
    ]"
>
    <div class="rounded-2xl bg-white/95 p-6 shadow-lg shadow-slate-950/10">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('syarikat.permohonan-58a.store') }}" enctype="multipart/form-data">
            @csrf

            <h3 class="font-semibold mb-2">BAHAGIAN A: MAKLUMAT PEMOHON</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium">Nama</label>
                    <input type="text" name="nama" class="mt-1 block w-full" />
                </div>
                <div>
                    <label class="block text-sm font-medium">No. Telefon</label>
                    <input type="text" name="no_telefon" class="mt-1 block w-full" />
                </div>
                <div>
                    <label class="block text-sm font-medium">Alamat E-mel</label>
                    <input type="email" name="email" class="mt-1 block w-full" />
                </div>
                <div>
                    <label class="block text-sm font-medium">No. Kad Pengenalan</label>
                    <input type="text" name="no_kp" class="mt-1 block w-full" />
                </div>
                <div>
                    <label class="block text-sm font-medium">Jawatan</label>
                    <input type="text" name="jawatan" class="mt-1 block w-full" />
                </div>
                <div>
                    <label class="block text-sm font-medium">Nama Syarikat</label>
                    <input type="text" name="nama_syarikat" class="mt-1 block w-full" />
                </div>
                <div>
                    <label class="block text-sm font-medium">No. Pendaftaran Cukai Jualan (jika berkenaan)</label>
                    <input type="text" name="no_pendaftaran_cukai" class="mt-1 block w-full" />
                </div>
                <div>
                    <label class="block text-sm font-medium">Tarikh permohonan (dd/mm/yyyy)</label>
                    <input type="text" name="tarikh_permohonan" placeholder="dd/mm/yyyy" class="mt-1 block w-full" />
                </div>
                <div>
                    <label class="block text-sm font-medium">No. Kelulusan (PDA2, JKDM dll)</label>
                    <input type="text" name="no_kelulusan" class="mt-1 block w-full" />
                </div>
                <div>
                    <label class="block text-sm font-medium">No. Pesanan Belian</label>
                    <input type="text" name="no_pesanan_belian" class="mt-1 block w-full" />
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium">Alamat</label>
                    <textarea name="alamat" class="mt-1 block w-full"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium">Negeri (stesen dipohon)</label>
                    <select name="negeri" class="mt-1 block w-full">
                        <option value="">-- Pilih Negeri --</option>
                        @foreach(['Johor','Kedah','Kelantan','Melaka','Negeri Sembilan','Pahang','Perak','Perlis','Penang','Sabah','Sarawak','Selangor','Terengganu','WP Kuala Lumpur','WP Labuan','WP Putrajaya'] as $state)
                            <option value="{{ $state }}">{{ $state }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <hr class="my-4" />

            <h3 class="font-semibold mb-2">BAHAGIAN B: MAKLUMAT ORANG YANG AKAN MENANDATANGANI SIJIL PENGECUALIAN</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium">Nama Pemohon</label>
                    <input type="text" name="tandatangan_nama" class="mt-1 block w-full" />
                </div>
                <div>
                    <label class="block text-sm font-medium">No KP Pemohon</label>
                    <input type="text" name="tandatangan_no_kp" class="mt-1 block w-full" />
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium">Jawatan</label>
                    <input type="text" name="tandatangan_jawatan" class="mt-1 block w-full" />
                </div>
            </div>

            <hr class="my-4" />

            <h3 class="font-semibold mb-2">BAHAGIAN C: MAKLUMAT PEMBEKAL</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium">Nama Firma/Syarikat</label>
                    <input type="text" name="pembekal_nama" class="mt-1 block w-full" />
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium">Alamat</label>
                    <textarea name="pembekal_alamat" class="mt-1 block w-full"></textarea>
                </div>
            </div>

            <hr class="my-4" />

            <h3 class="font-semibold mb-2">BAHAGIAN D: PERIHAL BARANG-BARANG</h3>
            <div class="overflow-x-auto">
                <table class="w-full table-auto" id="barang-table">
                    <thead>
                        <tr>
                            <th class="border px-2">No Kod Tarif</th>
                            <th class="border px-2">Perihal Barangan</th>
                            <th class="border px-2">Unit</th>
                            <th class="border px-2">Deskripsi</th>
                            <th class="border px-2">Kuantiti</th>
                            <th class="border px-2">Nilai (RM)</th>
                            <th class="border px-2">Nama Kawasan</th>
                            <th class="border px-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2"><input name="kod_tarif[]" class="w-full" /></td>
                            <td class="border px-2"><input name="perihal_barang[]" class="w-full" /></td>
                            <td class="border px-2"><input name="unit[]" class="w-full" /></td>
                            <td class="border px-2"><input name="deskripsi[]" class="w-full" /></td>
                            <td class="border px-2"><input name="kuantiti[]" type="number" step="any" class="w-full" /></td>
                            <td class="border px-2"><input name="nilai[]" type="number" step="any" class="w-full" /></td>
                            <td class="border px-2"><input name="kawasan[]" class="w-full" /></td>
                            <td class="border px-2 text-center"><button type="button" onclick="removeRow(this)" class="text-red-600">Hapus</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-2">
                <button type="button" onclick="addRow()" class="px-3 py-1 bg-blue-600 text-white rounded">Tambah Baris</button>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium">Muat Naik Fail Berkaitan (SSM, MAA, PDA2, Surat kelulusan)</label>
                <input type="file" name="attachments[]" multiple class="mt-1" />
            </div>

            <div class="mt-6">
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Hantar Permohonan</button>
                <a href="{{ route('syarikat.senaraipermohonan') }}" class="ml-3 px-4 py-2 bg-gray-200 rounded">Semak Senarai</a>
            </div>
        </form>
    </div>

    <script>
        function addRow(){
            const tbody = document.querySelector('#barang-table tbody');
            const tr = document.createElement('tr');
            tr.innerHTML = `\
                <td class="border px-2"><input name="kod_tarif[]" class="w-full" /></td>\
                <td class="border px-2"><input name="perihal_barang[]" class="w-full" /></td>\
                <td class="border px-2"><input name="unit[]" class="w-full" /></td>\
                <td class="border px-2"><input name="deskripsi[]" class="w-full" /></td>\
                <td class="border px-2"><input name="kuantiti[]" type="number" step="any" class="w-full" /></td>\
                <td class="border px-2"><input name="nilai[]" type="number" step="any" class="w-full" /></td>\
                <td class="border px-2"><input name="kawasan[]" class="w-full" /></td>\
                <td class="border px-2 text-center"><button type="button" onclick="removeRow(this)" class="text-red-600">Hapus</button></td>`;
            tbody.appendChild(tr);
        }
        function removeRow(btn){
            const tr = btn.closest('tr');
            if(tr) tr.remove();
        }
    </script>
</x-role-dashboard-layout>
