<x-role-dashboard-layout
    role="admin"
    title="SENARAI PERMOHONAN"
    subtitle="Permohonan yang sedang dalam semakan pentadbir."
    :nav-items="[
        ['label' => 'UTAMA', 'url' => route('admin.utama'), 'active' => '/admin/utama'],
        ['label' => 'URUS PENGGUNA', 'url' => route('admin.uruspengguna'), 'active' => '/admin/uruspengguna'],
        ['label' => 'TAMBAH PENGGUNA', 'url' => route('admin.tambahpengguna'), 'active' => '/admin/tambahpengguna'],
        ['label' => 'SENARAI LAPORAN', 'url' => route('admin.senarailaporan'), 'active' => '/admin/senarailaporan'],
        ['label' => 'SENARAI PERMOHONAN', 'url' => route('admin.senaraipermohonan'), 'active' => '/admin/senaraipermohonan'],
    ]"
>
    <div class="rounded-2xl bg-white/95 p-6 shadow-lg shadow-slate-950/10">
        <h2 class="mb-5 border-b border-slate-100 pb-4 text-xl font-bold text-slate-900">Senarai Permohonan 58A</h2>

        <form method="GET" action="{{ route('admin.senaraipermohonan') }}" class="mb-6 max-w-4xl">
            <div class="flex items-center overflow-hidden rounded-lg border border-slate-300 bg-white shadow-sm">
                <span class="whitespace-nowrap border-r border-slate-300 bg-slate-100 px-4 py-2.5 text-sm font-semibold text-slate-600">
                    Cari Nama Syarikat /
                </span>
                <input
                    type="text"
                    name="q"
                    value="{{ $query ?? request('q') }}"
                    placeholder="Negeri / Status / Tahun / No. Sijil / ID Syarikat"
                    class="w-full px-4 py-2.5 text-sm focus:outline-none"
                />
                <button type="submit" class="flex items-center pr-3 text-slate-400" aria-label="Cari">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </div>
        </form>

        @if (session('success'))
            <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">{{ session('success') }}</div>
        @endif

        <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="min-w-[1200px] w-full text-sm text-slate-700">
                <thead class="bg-slate-100 text-left text-xs uppercase text-slate-700">
                    <tr>
                        <th class="px-4 py-3">Tarikh</th>
                        <th class="px-4 py-3">Nama Syarikat</th>
                        <th class="px-4 py-3">Negeri</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">No. Sijil</th>
                        <th class="px-4 py-3">Tarikh Diluluskan</th>
                        <th class="px-4 py-3">Tarikh Tamat</th>
                        <th class="px-4 py-3">Sijil</th>
                        <th class="px-4 py-3 text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($permohonans as $permohonan)
                        <tr>
                            <td class="px-4 py-3">{{ $permohonan->tarikh_permohonan?->format('d/m/Y') ?? '-' }}</td>
                            <td class="px-4 py-3 font-semibold text-slate-900">{{ $permohonan->nama_syarikat ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $permohonan->negeri ?? '-' }}</td>
                            <td class="px-4 py-3">@include('partials.status-permohonan-badge', ['status' => $permohonan->status])</td>
                            <td class="px-4 py-3">{{ $permohonan->no_sijil_pengecualian ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $permohonan->tarikh_diluluskan ? \Illuminate\Support\Carbon::parse($permohonan->tarikh_diluluskan)->format('d/m/Y') : '-' }}</td>
                            <td class="px-4 py-3">{{ $permohonan->tarikh_tamat ? \Illuminate\Support\Carbon::parse($permohonan->tarikh_tamat)->format('d/m/Y') : '-' }}</td>
                            <td class="px-4 py-3">
                                @if($permohonan->sijil_pengecualian_path)
                                    <a href="{{ asset('storage/'.$permohonan->sijil_pengecualian_path) }}" target="_blank" class="rounded-md bg-red-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-500">pdf</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.permohonan.semak', $permohonan) }}" class="rounded-md bg-green-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-green-700">Semak</a>
                                    <form action="{{ route('admin.permohonan.destroy', $permohonan) }}" method="POST" onsubmit="return confirm('Padam permohonan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-md bg-red-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-700">Padam</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="px-4 py-8 text-center text-slate-400">Tiada permohonan dijumpai.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-role-dashboard-layout>
