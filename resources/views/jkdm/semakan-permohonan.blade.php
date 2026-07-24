<x-role-dashboard-layout
    role="jkdm"
    title="SEMAKAN PERMOHONAN"
    subtitle="Semakan dan keputusan permohonan pengecualian."
    :nav-items="[
        ['label' => 'UTAMA', 'url' => route('jkdm.utama'), 'active' => '/jkdm/utama'],
        ['label' => 'SENARAI LAPORAN', 'url' => route('jkdm.senarailaporan'), 'active' => '/jkdm/senarailaporan'],
        ['label' => 'SENARAI PERMOHONAN', 'url' => route('jkdm.senaraipermohonan'), 'active' => '/jkdm/senaraipermohonan'],
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
            @include('partials.permohonan-58a-readonly', ['permohonan' => $permohonan])
        </div>

        <form action="{{ route('jkdm.permohonan.update', $permohonan) }}" method="POST" enctype="multipart/form-data" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-950/10">
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
                <a href="{{ route('jkdm.permohonan.pdf', $permohonan) }}" class="rounded-lg bg-red-600 px-10 py-2.5 font-bold text-white shadow hover:bg-red-700">Print PDF</a>
                <a href="{{ route('jkdm.senaraipermohonan') }}" class="rounded-lg bg-blue-500 px-10 py-2.5 font-bold text-white shadow hover:bg-blue-600">Kembali</a>
            </div>
        </form>
    </div>
</x-role-dashboard-layout>
