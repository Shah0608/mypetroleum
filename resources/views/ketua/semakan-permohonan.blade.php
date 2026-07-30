<x-role-dashboard-layout
    role="ketua"
    title="SEMAKAN PERMOHONAN"
    subtitle="Sistem Maklumat Bunker Petroleum"
    :nav-items="[
        ['label' => 'UTAMA', 'url' => route('ketua.utama'), 'active' => '/ketua/utama'],
        ['label' => 'SENARAI LAPORAN', 'url' => route('ketua.senarailaporan'), 'active' => '/ketua/senarailaporan'],
        ['label' => 'SENARAI PERMOHONAN', 'url' => route('ketua.senaraipermohonan'), 'active' => '/ketua/senaraipermohonan'],
    ]"
>
    <div class="space-y-6">
        @if ($errors->any())
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                Sila semak semula maklumat yang dimasukkan.
            </div>
        @endif

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-950/10">
            <h2 class="mb-6 inline-flex rounded-md bg-slate-700 px-12 py-2 text-lg font-semibold uppercase text-white shadow">Maklumat Permohonan</h2>
            @include('partials.permohonan-58a-readonly', ['permohonan' => $permohonan])
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-950/10">
            <div class="mb-6 inline-flex rounded-md bg-slate-700 px-12 py-2 text-lg font-semibold uppercase text-white shadow">
                Ulasan Pegawai Verifikasi
            </div>

            <div class="grid gap-5">
                <div class="block">
                    <span class="text-sm font-semibold text-slate-700">Ulasan Pegawai Verifikasi</span>
                    <p class="mt-1 min-h-24 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">{{ $permohonan->ulasan_pegawai_verifikasi ?: '-' }}</p>
                </div>

                <div class="grid gap-4 md:grid-cols-3">
                    <div class="block">
                        <span class="text-sm font-semibold text-slate-700">Nama Pegawai</span>
                        <p class="mt-1 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">{{ $permohonan->nama_pegawai_verifikasi ?: '-' }}</p>
                    </div>
                    <div class="block">
                        <span class="text-sm font-semibold text-slate-700">Tarikh Ulasan</span>
                        <p class="mt-1 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">{{ $permohonan->tarikh_ulasan_verifikasi?->format('d/m/Y') ?? '-' }}</p>
                    </div>
                    <div class="block">
                        <span class="text-sm font-semibold text-slate-700">Tarikh Tamat PDA 2</span>
                        <p class="mt-1 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">
                            {{ $permohonan->tarikh_tamat_pda2_verifikasi?->format('d/m/Y') ?? $permohonan->tarikh_tamat_pda2_ketua_unit?->format('d/m/Y') ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('ketua.permohonan.update', $permohonan) }}" method="POST" enctype="multipart/form-data" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-950/10">
            @csrf
            @method('PUT')
            <input type="hidden" name="review_section" value="ketua_unit">

            <div class="mb-6 inline-flex rounded-md bg-blue-500 px-12 py-2 text-lg font-semibold uppercase text-white shadow">
                Ulasan Ketua Unit/Cawangan
            </div>

            <div class="grid gap-5">
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
                    <div class="block">
                        <span class="text-sm font-semibold text-slate-700">Tarikh Tamat PDA 2</span>
                        <p class="mt-1 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">{{ $permohonan->tarikh_tamat_pda2_verifikasi?->format('d/m/Y') ?? '-' }}</p>
                    </div>
                </div>

                <div class="rounded-lg border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                    Keputusan Pengarah Kastam Negeri, Tarikh Diluluskan, Tarikh Tamat dan No. Sijil akan diisi oleh Pelulus.
                </div>
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <button type="submit" class="rounded-lg bg-emerald-600 px-10 py-2.5 font-bold text-white shadow hover:bg-emerald-700">Hantar</button>
                <a href="{{ route('ketua.senaraipermohonan') }}" class="rounded-lg bg-blue-500 px-10 py-2.5 font-bold text-white shadow hover:bg-blue-600">Kembali</a>
            </div>
        </form>
    </div>
</x-role-dashboard-layout>
