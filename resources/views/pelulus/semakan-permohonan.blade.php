<x-role-dashboard-layout
    role="pelulus"
    title="SEMAKAN PERMOHONAN"
    subtitle="Keputusan Pengarah Kastam Negeri."
    :nav-items="[
        ['label' => 'UTAMA', 'url' => route('pelulus.utama'), 'active' => '/pelulus/utama'],
        ['label' => 'SENARAI PERMOHONAN', 'url' => route('pelulus.senaraipermohonan'), 'active' => '/pelulus/senaraipermohonan'],
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

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-950/10">
            <div class="mb-6 inline-flex rounded-md bg-slate-700 px-12 py-2 text-lg font-semibold uppercase text-white shadow">
                Ulasan JKDM
            </div>

            <div class="grid gap-4 text-sm md:grid-cols-3">
                <div>
                    <span class="font-semibold text-slate-700">Nama Pegawai</span>
                    <p class="mt-1 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">{{ $permohonan->nama_pegawai_jkdm ?: '-' }}</p>
                </div>
                <div>
                    <span class="font-semibold text-slate-700">Tarikh Ulasan</span>
                    <p class="mt-1 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">{{ $permohonan->tarikh_ulasan_jkdm?->format('d/m/Y') ?? '-' }}</p>
                </div>
                <div>
                    <span class="font-semibold text-slate-700">Tarikh Tamat CGA</span>
                    <p class="mt-1 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">{{ $permohonan->tarikh_tamat_cga?->format('d/m/Y') ?? '-' }}</p>
                </div>
                <div class="md:col-span-3">
                    <span class="font-semibold text-slate-700">Ulasan Pegawai Kanan</span>
                    <p class="mt-1 min-h-24 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">{{ $permohonan->ulasan_jkdm ?: '-' }}</p>
                </div>
            </div>
        </div>

        <form action="{{ route('pelulus.permohonan.update', $permohonan) }}" method="POST" enctype="multipart/form-data" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-950/10">
            @csrf
            @method('PUT')

            <div class="mb-6 inline-flex rounded-md bg-blue-500 px-12 py-2 text-lg font-semibold uppercase text-white shadow">
                Keputusan Pengarah Kastam Negeri
            </div>

            <div class="grid gap-5">
                <div class="grid gap-4 md:grid-cols-2">
                    <label class="block">
                        <span class="text-sm font-semibold text-slate-700">Keputusan Pengarah Kastam Negeri</span>
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

                <div class="grid gap-4 md:grid-cols-3">
                    <label class="block">
                        <span class="text-sm font-semibold text-slate-700">Kod Stesen</span>
                        <input type="text" name="kod_stesen" value="{{ old('kod_stesen') }}" placeholder="M10" class="mt-1 w-full rounded-lg border border-blue-400 px-3 py-2 uppercase focus:border-blue-600 focus:outline-none">
                    </label>
                    <label class="block">
                        <span class="text-sm font-semibold text-slate-700">No. Daftar</span>
                        <input type="text" name="no_daftar_sijil" value="{{ old('no_daftar_sijil') }}" placeholder="0001" class="mt-1 w-full rounded-lg border border-blue-400 px-3 py-2 focus:border-blue-600 focus:outline-none">
                    </label>
                    <div>
                        <span class="text-sm font-semibold text-slate-700">No. Sijil Semasa</span>
                        <p class="mt-1 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 font-mono text-sm">{{ $permohonan->no_sijil_pengecualian ?: '-' }}</p>
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <span class="text-sm font-semibold text-slate-700">Tarikh Tamat</span>
                        <p class="mt-1 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">{{ $permohonan->tarikh_tamat_cga?->format('d/m/Y') ?? '-' }}</p>
                    </div>
                    <label class="block">
                        <span class="text-sm font-semibold text-slate-700">Muat Naik Sijil Pengecualian PDF</span>
                        <input type="file" name="sijil_pengecualian" accept="application/pdf" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
                    </label>
                </div>

                @if($permohonan->sijil_pengecualian_path)
                    <a href="{{ asset('storage/'.$permohonan->sijil_pengecualian_path) }}" target="_blank" class="inline-flex text-sm font-semibold text-red-600 hover:text-red-700">Lihat sijil semasa</a>
                @endif
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <button type="submit" class="rounded-lg bg-emerald-600 px-10 py-2.5 font-bold text-white shadow hover:bg-emerald-700">Hantar</button>
                <a href="{{ route('pelulus.permohonan.pdf', $permohonan) }}" class="rounded-lg bg-red-600 px-10 py-2.5 font-bold text-white shadow hover:bg-red-700">Print PDF</a>
                <a href="{{ route('pelulus.senaraipermohonan') }}" class="rounded-lg bg-blue-500 px-10 py-2.5 font-bold text-white shadow hover:bg-blue-600">Kembali</a>
            </div>
        </form>
    </div>
</x-role-dashboard-layout>
