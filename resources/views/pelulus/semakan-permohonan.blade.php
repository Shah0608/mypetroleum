<x-role-dashboard-layout
    role="pelulus"
    title="SEMAKAN PERMOHONAN"
    subtitle="Sistem Maklumat Bunker Petroleum"
    :nav-items="[
        ['label' => 'UTAMA', 'url' => route('pelulus.utama'), 'active' => '/pelulus/utama'],
        ['label' => 'SENARAI SYARIKAT', 'url' => route('pelulus.senarai-pengguna'), 'active' => '/pelulus/senarai-pengguna'],
        ['label' => 'SENARAI PERMOHONAN', 'url' => route('pelulus.senaraipermohonan'), 'active' => '/pelulus/senaraipermohonan'],
    ]"
>
    <div class="space-y-6">
        @php
            $stationOptions = [
                'M10' => 'M10 - Melaka',
                'N10' => 'N10 - Seremban',
                'N11' => 'N11 - Port Dickson',
                'P11' => 'P11 - Georgetown',
                'P13' => 'P13 - Seberang Jaya',
                'R10' => 'R10 - Kangar',
                'S10' => 'S10 - Kota Kinabalu',
                'T10' => 'T10 - Kuala Terengganu',
                'T13' => 'T13 - Kemaman',
                'W10' => 'W10 - Kuala Lumpur',
                'W24' => 'W24 - KLIA CD',
                'A10' => 'A10 - Ipoh',
                'A11' => 'A11 - Taiping',
                'B10' => 'B10 - Port Klang',
                'B16' => 'B16 - Subang (OPA)',
                'C10' => 'C10 - Kuantan',
                'C11' => 'C11 - Bentong',
                'D10' => 'D10 - Kota Bahru',
                'E10' => 'E10 - Labuan',
                'J11' => 'J11 - Batu Pahat',
                'J12' => 'J12 - Kluang',
                'J13' => 'J13 - Muar',
                'J31' => 'J31 - Johor Bahru',
                'K10' => 'K10 - Alor Setar',
                'Y58' => 'Y58 - Bintulu',
                'Y60' => 'Y60 - Kuching',
            ];
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

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-950/10">
            <div class="mb-6 inline-flex rounded-md bg-slate-700 px-12 py-2 text-lg font-semibold uppercase text-white shadow">
                Ulasan Pegawai Verifikasi
            </div>

            <div class="grid gap-4 text-sm md:grid-cols-3">
                <div>
                    <span class="font-semibold text-slate-700">Nama Pegawai</span>
                    <p class="mt-1 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">{{ $permohonan->nama_pegawai_verifikasi ?: '-' }}</p>
                </div>
                <div>
                    <span class="font-semibold text-slate-700">Tarikh Ulasan</span>
                    <p class="mt-1 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">{{ $permohonan->tarikh_ulasan_verifikasi?->format('d/m/Y') ?? '-' }}</p>
                </div>
                <div>
                    <span class="font-semibold text-slate-700">Tarikh Tamat PDA 2</span>
                    <p class="mt-1 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">{{ $permohonan->tarikh_tamat_pda2_verifikasi?->format('d/m/Y') ?? '-' }}</p>
                </div>
                <div class="md:col-span-3">
                    <span class="font-semibold text-slate-700">Ulasan Pegawai Verifikasi</span>
                    <p class="mt-1 min-h-24 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">{{ $permohonan->ulasan_pegawai_verifikasi ?: '-' }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-950/10">
            <div class="mb-6 inline-flex rounded-md bg-slate-700 px-12 py-2 text-lg font-semibold uppercase text-white shadow">
                Ulasan Ketua Unit/Cawangan
            </div>

            <div class="grid gap-4 text-sm md:grid-cols-3">
                <div>
                    <span class="font-semibold text-slate-700">Nama Pegawai</span>
                    <p class="mt-1 min-h-11 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">{{ $permohonan->nama_pegawai_ketua_unit ?: '-' }}</p>
                </div>
                <div>
                    <span class="font-semibold text-slate-700">Tarikh Ulasan</span>
                    <p class="mt-1 min-h-11 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">{{ $permohonan->tarikh_ulasan_ketua_unit?->format('d/m/Y') ?? '-' }}</p>
                </div>
                <div>
                    <span class="font-semibold text-slate-700">Tarikh Tamat PDA 2</span>
                    <p class="mt-1 min-h-11 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">{{ $permohonan->tarikh_tamat_pda2_verifikasi?->format('d/m/Y') ?? '-' }}</p>
                </div>
                <div class="md:col-span-3">
                    <span class="font-semibold text-slate-700">Ulasan Ketua Unit/Cawangan</span>
                    <p class="mt-1 min-h-24 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">{{ $permohonan->ulasan_ketua_unit ?: '-' }}</p>
                </div>
            </div>
        </div>

        <form action="{{ route('pelulus.permohonan.update', $permohonan) }}" method="POST" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-950/10">
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
                        <select name="kod_stesen" class="mt-1 w-full rounded-lg border border-blue-400 px-3 py-2 uppercase focus:border-blue-600 focus:outline-none">
                            <option value="">Sila pilih kod stesen</option>
                            @foreach($stationOptions as $kodStesen => $label)
                                <option value="{{ $kodStesen }}" @selected(old('kod_stesen') === $kodStesen)>{{ $label }}</option>
                            @endforeach
                        </select>
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

                <div>
                <div>
                    <span class="text-sm font-semibold text-slate-700">Tarikh Tamat</span>
                    <p class="mt-1 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">{{ $permohonan->tarikh_tamat_pda2_verifikasi?->format('d/m/Y') ?? '-' }}</p>
                </div>
            </div>
        </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <button type="submit" class="rounded-lg bg-emerald-600 px-10 py-2.5 font-bold text-white shadow hover:bg-emerald-700">Hantar</button>
                <a href="{{ route('pelulus.senaraipermohonan') }}" class="rounded-lg bg-blue-500 px-10 py-2.5 font-bold text-white shadow hover:bg-blue-600">Kembali</a>
            </div>
        </form>
    </div>
</x-role-dashboard-layout>
