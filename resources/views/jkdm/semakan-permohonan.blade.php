<x-role-dashboard-layout
    role="jkdm"
    title="SEMAKAN PERMOHONAN"
    subtitle="Sistem Maklumat Bunker Petroleum"
    :nav-items="[
        ['label' => 'UTAMA', 'url' => route('jkdm.utama'), 'active' => '/jkdm/utama'],
        ['label' => 'SENARAI LAPORAN', 'url' => route('jkdm.senarailaporan'), 'active' => '/jkdm/senarailaporan'],
        ['label' => 'SENARAI PERMOHONAN', 'url' => route('jkdm.senaraipermohonan'), 'active' => '/jkdm/senaraipermohonan'],
    ]"
>
    <div class="space-y-6">
        @php
            $role = auth()->user()?->role;
            $canEditVerifikasi = $role === 'jkdm';
            $canEditKetuaUnit = $role === 'ketua_unit_jkdm';
            $submitLabel = $role === 'jkdm' ? 'Simpan' : 'Hantar';
        @endphp

        @if ($errors->any())
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                Sila semak semula maklumat yang dimasukkan.
            </div>
        @endif
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-950/10">
            <h2 class="mb-6 inline-flex rounded-md bg-slate-700 px-12 py-2 text-lg font-semibold uppercase text-white shadow">Maklumat Permohonan</h2>
            @include('partials.permohonan-58a-readonly', ['permohonan' => $permohonan])
        </div>

        <form action="{{ route('jkdm.permohonan.update', $permohonan) }}" method="POST" enctype="multipart/form-data" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-950/10">
            @csrf
            @method('PUT')
            <input type="hidden" name="review_section" value="verifikasi">

            <div class="mb-6 inline-flex rounded-md bg-blue-500 px-12 py-2 text-lg font-semibold uppercase text-white shadow">
                Ulasan Pegawai Verifikasi
            </div>

            <div class="grid gap-5">
                @if(! $canEditVerifikasi)
                    <div class="grid gap-4 md:grid-cols-3">
                        <div class="md:col-span-3">
                            <span class="text-sm font-semibold text-slate-700">Ulasan Pegawai Verifikasi</span>
                            <p class="mt-1 min-h-24 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">{{ $permohonan->ulasan_pegawai_verifikasi ?: '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-slate-700">Nama Pegawai</span>
                            <p class="mt-1 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">{{ $permohonan->nama_pegawai_verifikasi ?: '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-slate-700">Tarikh Ulasan</span>
                            <p class="mt-1 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">{{ $permohonan->tarikh_ulasan_verifikasi?->format('d/m/Y') ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-slate-700">Tarikh Tamat PDA 2</span>
                            <p class="mt-1 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">{{ $permohonan->tarikh_tamat_pda2_verifikasi?->format('d/m/Y') ?? '-' }}</p>
                        </div>
                    </div>
                @else
                    <label class="block">
                        <span class="text-sm font-semibold text-slate-700">Ulasan Pegawai Verifikasi</span>
                        <textarea name="ulasan_pegawai_verifikasi" rows="4" class="mt-1 w-full rounded-lg border border-blue-400 px-3 py-2 focus:border-blue-600 focus:outline-none">{{ old('ulasan_pegawai_verifikasi', $permohonan->ulasan_pegawai_verifikasi) }}</textarea>
                    </label>

                    <div class="grid gap-4 md:grid-cols-3">
                        <label class="block">
                            <span class="text-sm font-semibold text-slate-700">Nama Pegawai</span>
                            <input type="text" name="nama_pegawai_verifikasi" value="{{ old('nama_pegawai_verifikasi', $permohonan->nama_pegawai_verifikasi) }}" class="mt-1 w-full rounded-lg border border-blue-400 px-3 py-2 focus:border-blue-600 focus:outline-none">
                        </label>
                        <label class="block">
                            <span class="text-sm font-semibold text-slate-700">Tarikh Ulasan</span>
                            <input type="date" name="tarikh_ulasan_verifikasi" value="{{ old('tarikh_ulasan_verifikasi', $permohonan->tarikh_ulasan_verifikasi?->format('Y-m-d')) }}" class="mt-1 w-full rounded-lg border border-blue-400 px-3 py-2 focus:border-blue-600 focus:outline-none">
                        </label>
                        <label class="block">
                            <span class="text-sm font-semibold text-slate-700">Tarikh Tamat PDA 2</span>
                            <input type="date" name="tarikh_tamat_pda2_verifikasi" value="{{ old('tarikh_tamat_pda2_verifikasi', $permohonan->tarikh_tamat_pda2_verifikasi?->format('Y-m-d')) }}" class="mt-1 w-full rounded-lg border border-blue-400 px-3 py-2 focus:border-blue-600 focus:outline-none">
                        </label>
                    </div>
                @endif

                <div class="rounded-lg border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                    Keputusan Pengarah Kastam Negeri, Tarikh Diluluskan, Tarikh Tamat dan No. Sijil akan diisi oleh Pelulus.
                </div>

                @if($canEditVerifikasi)
                    <div class="mt-2 flex flex-wrap gap-3">
                        <button type="submit" class="rounded-lg bg-emerald-600 px-10 py-2.5 font-bold text-white shadow hover:bg-emerald-700">{{ $submitLabel }}</button>
                    </div>
                @endif
            </div>
        </form>

        <form action="{{ route('jkdm.permohonan.update', $permohonan) }}" method="POST" enctype="multipart/form-data" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-950/10">
            @csrf
            @method('PUT')
            <input type="hidden" name="review_section" value="ketua_unit">

            <div class="mb-6 inline-flex rounded-md bg-slate-700 px-12 py-2 text-lg font-semibold uppercase text-white shadow">
                Ulasan Ketua Unit/Cawangan
            </div>

            <div class="grid gap-5">
                @if(! $canEditKetuaUnit)
                    <div class="grid gap-4 md:grid-cols-3">
                        <div class="md:col-span-3">
                            <span class="text-sm font-semibold text-slate-700">Ulasan Ketua Unit/Cawangan</span>
                            <p class="mt-1 min-h-24 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">{{ $permohonan->ulasan_ketua_unit ?: '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-slate-700">Nama Pegawai</span>
                            <p class="mt-1 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">{{ $permohonan->nama_pegawai_ketua_unit ?: '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-slate-700">Tarikh Ulasan</span>
                            <p class="mt-1 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">{{ $permohonan->tarikh_ulasan_ketua_unit?->format('d/m/Y') ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-slate-700">Tarikh Tamat PDA 2</span>
                            <p class="mt-1 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">{{ $permohonan->tarikh_tamat_pda2_ketua_unit?->format('d/m/Y') ?? '-' }}</p>
                        </div>
                    </div>
                @else
                    <label class="block">
                        <span class="text-sm font-semibold text-slate-700">Ulasan Ketua Unit/Cawangan</span>
                        <textarea name="ulasan_ketua_unit" rows="4" class="mt-1 w-full rounded-lg border border-blue-400 px-3 py-2 focus:border-blue-600 focus:outline-none">{{ old('ulasan_ketua_unit', $permohonan->ulasan_ketua_unit) }}</textarea>
                    </label>

                    <div class="grid gap-4 md:grid-cols-3">
                        <label class="block">
                            <span class="text-sm font-semibold text-slate-700">Nama Pegawai</span>
                            <input type="text" name="nama_pegawai_ketua_unit" value="{{ old('nama_pegawai_ketua_unit', $permohonan->nama_pegawai_ketua_unit) }}" class="mt-1 w-full rounded-lg border border-blue-400 px-3 py-2 focus:border-blue-600 focus:outline-none">
                        </label>
                        <label class="block">
                            <span class="text-sm font-semibold text-slate-700">Tarikh Ulasan</span>
                            <input type="date" name="tarikh_ulasan_ketua_unit" value="{{ old('tarikh_ulasan_ketua_unit', $permohonan->tarikh_ulasan_ketua_unit?->format('Y-m-d')) }}" class="mt-1 w-full rounded-lg border border-blue-400 px-3 py-2 focus:border-blue-600 focus:outline-none">
                        </label>
                        <label class="block">
                            <span class="text-sm font-semibold text-slate-700">Tarikh Tamat PDA 2</span>
                            <input type="date" name="tarikh_tamat_pda2_ketua_unit" value="{{ old('tarikh_tamat_pda2_ketua_unit', $permohonan->tarikh_tamat_pda2_ketua_unit?->format('Y-m-d')) }}" class="mt-1 w-full rounded-lg border border-blue-400 px-3 py-2 focus:border-blue-600 focus:outline-none">
                        </label>
                    </div>
                @endif

                <div class="rounded-lg border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                    Keputusan Pengarah Kastam Negeri, Tarikh Diluluskan, Tarikh Tamat dan No. Sijil akan diisi oleh Pelulus.
                </div>
            </div>

            @if($canEditKetuaUnit)
                <div class="mt-6 flex flex-wrap gap-3">
                    <button type="submit" class="rounded-lg bg-emerald-600 px-10 py-2.5 font-bold text-white shadow hover:bg-emerald-700">Hantar</button>
                    <a href="{{ route('jkdm.senaraipermohonan') }}" class="rounded-lg bg-blue-500 px-10 py-2.5 font-bold text-white shadow hover:bg-blue-600">Kembali</a>
                </div>
            @endif
        </form>
    </div>
</x-role-dashboard-layout>
