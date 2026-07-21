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

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-950/10">
            <h2 class="mb-4 border-b border-slate-100 pb-3 text-xl font-bold text-slate-900">Maklumat Permohonan</h2>
            <div class="grid gap-4 text-sm md:grid-cols-2">
                <div><span class="font-semibold">Nama Syarikat:</span> {{ $permohonan->nama_syarikat ?? '-' }}</div>
                <div><span class="font-semibold">Negeri:</span> {{ $permohonan->negeri ?? '-' }}</div>
                <div><span class="font-semibold">Pemohon:</span> {{ $permohonan->nama ?? '-' }}</div>
                <div><span class="font-semibold">Tarikh Permohonan:</span> {{ $permohonan->tarikh_permohonan?->format('d/m/Y') ?? '-' }}</div>
            </div>
        </div>

        <form action="{{ route('admin.permohonan.update', $permohonan) }}" method="POST" enctype="multipart/form-data" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-950/10">
            @csrf
            @method('PUT')

            <div class="mb-6 inline-flex rounded-md bg-blue-500 px-12 py-2 text-lg font-semibold uppercase text-white shadow">
                Ulasan JKDM
            </div>

            <div class="grid gap-5">
                <label class="block">
                    <span class="text-sm font-semibold text-slate-700">Ulasan Pegawai Kanan</span>
                    <textarea name="ulasan_jkdm" rows="4" class="mt-1 w-full rounded-lg border border-blue-400 px-3 py-2 focus:border-blue-600 focus:outline-none">{{ old('ulasan_jkdm', $permohonan->ulasan_jkdm) }}</textarea>
                </label>

                <div class="grid gap-4 md:grid-cols-2">
                    <label class="block">
                        <span class="text-sm font-semibold text-slate-700">Nama Pegawai</span>
                        <input type="text" name="nama_pegawai_jkdm" value="{{ old('nama_pegawai_jkdm', $permohonan->nama_pegawai_jkdm) }}" class="mt-1 w-full rounded-lg border border-blue-400 px-3 py-2 focus:border-blue-600 focus:outline-none">
                    </label>
                    <label class="block">
                        <span class="text-sm font-semibold text-slate-700">Tarikh</span>
                        <input type="date" name="tarikh_ulasan_jkdm" value="{{ old('tarikh_ulasan_jkdm', $permohonan->tarikh_ulasan_jkdm?->format('Y-m-d')) }}" class="mt-1 w-full rounded-lg border border-blue-400 px-3 py-2 focus:border-blue-600 focus:outline-none">
                    </label>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <label class="block">
                        <span class="text-sm font-semibold text-slate-700">Keputusan</span>
                        <select name="status" class="mt-1 w-full rounded-lg border border-blue-400 px-3 py-2 focus:border-blue-600 focus:outline-none">
                            @foreach(['Dalam tindakan', 'Diluluskan', 'Tidak diluluskan'] as $status)
                                <option value="{{ $status }}" @selected(old('status', $permohonan->status ?? 'Dalam tindakan') === $status)>{{ $status }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="block">
                        <span class="text-sm font-semibold text-slate-700">Tarikh Diluluskan</span>
                        <input type="date" name="tarikh_diluluskan" value="{{ old('tarikh_diluluskan', $permohonan->tarikh_diluluskan?->format('Y-m-d')) }}" class="mt-1 w-full rounded-lg border border-blue-400 px-3 py-2 focus:border-blue-600 focus:outline-none">
                    </label>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <label class="block">
                        <span class="text-sm font-semibold text-slate-700">No. Sijil</span>
                        <input type="text" name="no_sijil_pengecualian" value="{{ old('no_sijil_pengecualian', $permohonan->no_sijil_pengecualian) }}" class="mt-1 w-full rounded-lg border border-blue-400 px-3 py-2 focus:border-blue-600 focus:outline-none">
                    </label>
                    <label class="block">
                        <span class="text-sm font-semibold text-slate-700">Tarikh Tamat</span>
                        <input type="date" name="tarikh_tamat" value="{{ old('tarikh_tamat', $permohonan->tarikh_tamat?->format('Y-m-d')) }}" class="mt-1 w-full rounded-lg border border-blue-400 px-3 py-2 focus:border-blue-600 focus:outline-none">
                    </label>
                </div>

                <label class="block">
                    <span class="text-sm font-semibold text-slate-700">Muat Naik Sijil Pengecualian PDF</span>
                    <input type="file" name="sijil_pengecualian" accept="application/pdf" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
                </label>
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <button type="submit" class="rounded-lg bg-emerald-600 px-10 py-2.5 font-bold text-white shadow hover:bg-emerald-700">Hantar</button>
                <a href="{{ route('admin.senaraipermohonan') }}" class="rounded-lg bg-blue-500 px-10 py-2.5 font-bold text-white shadow hover:bg-blue-600">Kembali</a>
            </div>
        </form>
    </div>
</x-role-dashboard-layout>
