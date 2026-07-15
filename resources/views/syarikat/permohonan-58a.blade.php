<x-role-dashboard-layout
    role="syarikat"
    title="BORANG 58A"
    subtitle="Permohonan untuk syarikat/pemilik."
    :nav-items="[
        ['label' => 'My Petroleum Syarikat', 'url' => route('syarikat.utama'), 'route' => 'syarikat.utama', 'active' => '/syarikat/utama'],
        ['label' => 'Permohonan', 'url' => route('syarikat.permohonan-58a'), 'route' => 'syarikat.permohonan-58a', 'active' => '/syarikat/permohonan-58a'],
        ['label' => 'Senarai Permohonan', 'url' => route('syarikat.senaraipermohonan'), 'route' => 'syarikat.senaraipermohonan', 'active' => '/syarikat/senaraipermohonan'],
        ['label' => 'Laporan CJ(P)', 'url' => route('syarikat.laporan-cj'), 'route' => 'syarikat.laporan-cj', 'active' => '/syarikat/laporan-cj'],
        ['label' => 'Senarai Laporan CJ(P)', 'url' => route('syarikat.senarailaporan'), 'route' => 'syarikat.senarailaporan', 'active' => '/syarikat/senarailaporan'],
    ]"
>
    <!-- Ditukar kepada elemen form untuk memproses penghantaran -->
    <form action="{{ route('syarikat.senaraipermohonan') }}" method="GET" class="space-y-6">
        @csrf
        <div class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-lg shadow-slate-950/10">
            <h2 class="text-xl font-semibold text-slate-900">Permohonan Pengecualian Cukai Jualan di bawah Butiran 58A</h2>
        </div>

        <!-- Bahagian A -->
        <div class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-lg shadow-slate-950/10">
            <h3 class="text-lg font-semibold text-slate-900">Bahagian A: Maklumat Permohonan</h3>
            <div class="mt-4 grid gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Nama</label>
                    <input type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2" />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">No. Telefon</label>
                    <input type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2" />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Alamat Emel</label>
                    <input type="email" class="w-full rounded-lg border border-slate-300 px-3 py-2" />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">No. Kad Pengenalan</label>
                    <input type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2" />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Jawatan</label>
                    <input type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2" />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Nama Syarikat</label>
                    <input type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2" placeholder="Nama penuh syarikat" />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">No. Pendaftaran Cukai Jualan (jika berkenaan)</label>
                    <input type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2" />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Tarikh Permohonan</label>
                    <input type="date" class="w-full rounded-lg border border-slate-300 px-3 py-2" />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">No. Kelulusan (PDA2, JKDM dll)</label>
                    <input type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2" />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">No. Pesanan Belian</label>
                    <input type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2" />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Alamat</label>
                    <textarea rows="3" class="w-full rounded-lg border border-slate-300 px-3 py-2"></textarea>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Negeri (Stesen dipohon)</label>
                    <select class="w-full rounded-lg border border-slate-300 px-3 py-2">
                        <option value="">Sila pilih negeri</option>
                        <option value="Johor">Johor</option>
                        <option value="Kedah">Kedah</option>
                        <option value="Kelantan">Kelantan</option>
                        <option value="Melaka">Melaka</option>
                        <option value="Negeri Sembilan">Negeri Sembilan</option>
                        <option value="Pahang">Pahang</option>
                        <option value="Perak">Perak</option>
                        <option value="Perlis">Perlis</option>
                        <option value="Pulau Pinang">Pulau Pinang</option>
                        <option value="Sabah">Sabah</option>
                        <option value="Sarawak">Sarawak</option>
                        <option value="Selangor">Selangor</option>
                        <option value="Terengganu">Terengganu</option>
                        <option value="Kuala Lumpur">Kuala Lumpur</option>
                        <option value="Labuan">Labuan</option>
                        <option value="Putrajaya">Putrajaya</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Bahagian B -->
        <div class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-lg shadow-slate-950/10">
            <h3 class="text-lg font-semibold text-slate-900">Bahagian B: Maklumat Orang Yang Akan Menandatangan Sijil Pengecualian</h3>
            <div class="mt-4 grid gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Nama Permohonan</label>
                    <input type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2" />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">No. KP Pemohonan</label>
                    <input type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2" />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Jawatan</label>
                    <input type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2" />
                </div>
            </div>
        </div>

        <!-- Bahagian C -->
        <div class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-lg shadow-slate-950/10">
            <h3 class="text-lg font-semibold text-slate-900">Bahagian C: Maklumat Pembekal</h3>
            <div class="mt-4 grid gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Nama Pembekal</label>
                    <input type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2" />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Alamat Pembekal</label>
                    <textarea rows="3" class="w-full rounded-lg border border-slate-300 px-3 py-2"></textarea>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">No. Lesen / Pendaftaran</label>
                    <input type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2" />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">No. Telefon</label>
                    <input type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2" />
                </div>
            </div>
        </div>

        <!-- Bahagian D -->
        <div class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-lg shadow-slate-950/10">
            <h3 class="text-lg font-semibold text-slate-900">Bahagian D: Perihal Barang-barang</h3>
            <div class="mt-4 grid gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">No. Kad Tarif</label>
                    <input type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2" />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Perihal Barangan</label>
                    <input type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2" />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Unit</label>
                    <input type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2" />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Diskripsi</label>
                    <textarea rows="3" class="w-full rounded-lg border border-slate-300 px-3 py-2"></textarea>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Kuantiti</label>
                    <input type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2" />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Nilai (RM)</label>
                    <input type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2" />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Nama Kawasan</label>
                    <input type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2" />
                </div>
                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-medium text-slate-700">Muat Naik Fail Berkaitan (SSM, MAA, PDA2, Surat Kelulusan Ship Chandler)</label>
                    <div class="rounded-lg border border-dashed border-slate-300 bg-slate-50 p-4">
                        <input type="file" class="block w-full text-sm text-slate-600" multiple />
                        <p class="mt-2 text-xs text-slate-500">Fail yang dipilih akan dipaparkan di sini selepas anda memilih fail.</p>
                    </div>
                </div>
            </div>

            <!-- Nama Pengesah Box yang telah dipanjangkan -->
            <div class="mt-6 rounded-lg border border-slate-200 bg-slate-50 p-4 text-sm leading-7 text-slate-700">
                <div class="text-sm leading-8 text-slate-700">
                    <span class="font-medium">Saya</span>
                    <input
                        type="text"
                        class="mx-2 inline-block w-96 max-w-full rounded-lg border border-slate-300 bg-white px-3 py-2 align-middle"
                        placeholder="Masukkan nama pengesah" />
                    <span>
                        memohon untuk membeli barang-barang dan pengecualian dituntut di bawah
                        Butiran 58A Jadual A, Perintah Cukai Jualan (Orang Yang Dikecualikan
                        Daripada Cukai Jualan) 2018 tertakluk kepada syarat-syarat yang
                        ditetapkan. Saya mengaku semua butiran yang diberikan adalah betul dan
                        benar.
                    </span>
                </div>
            </div>
        </div>

        <center>
            <!-- Diubah ke type="submit" untuk simulasi redirect ke Senarai Permohonan -->
            <button type="submit" class="rounded-lg bg-green-800 px-6 py-2.5 font-semibold text-white transition hover:bg-green-700">
                Hantar
            </button>
            <button type="button" class="rounded-lg bg-blue-600 px-6 py-2.5 font-semibold text-white transition hover:bg-blue-700">
                Simpan
            </button>
        </center>
    </form>
</x-role-dashboard-layout>