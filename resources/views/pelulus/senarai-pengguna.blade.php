<x-role-dashboard-layout
    role="pelulus"
    title="SENARAI PENGGUNA"
    subtitle="Sistem Maklumat Bunker Petroleum"
    :nav-items="[
        ['label' => 'UTAMA', 'url' => route('pelulus.utama'), 'active' => '/pelulus/utama'],
        ['label' => 'SENARAI PENGGUNA', 'url' => route('pelulus.senarai-pengguna'), 'active' => '/pelulus/senarai-pengguna'],
        ['label' => 'SENARAI PERMOHONAN', 'url' => route('pelulus.senaraipermohonan'), 'active' => '/pelulus/senaraipermohonan'],
    ]"
>
    <div class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-lg shadow-slate-950/10">
        <div class="mb-5 flex flex-col gap-3 border-b border-slate-100 pb-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Senarai Pengguna</h2>
                <p class="mt-1 text-sm text-slate-500">Paparan berdasarkan permohonan yang telah dihantar.</p>
            </div>
            <span class="rounded-lg bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700">
                {{ $penggunas->count() }} rekod
            </span>
        </div>

        <form method="GET" action="{{ route('pelulus.senarai-pengguna') }}" class="mb-6 max-w-4xl">
            <div class="flex items-center overflow-hidden rounded-xl border border-slate-300 bg-white shadow-sm">
                <span class="whitespace-nowrap border-r border-slate-300 bg-slate-100 px-4 py-2.5 text-xs font-bold uppercase tracking-wider text-slate-600">
                    Cari
                </span>
                <input
                    type="text"
                    name="q"
                    value="{{ $query ?? request('q') }}"
                    placeholder="Nama Syarikat / Alamat"
                    class="w-full px-4 py-2.5 text-sm focus:outline-none"
                />
                <button type="submit" class="flex items-center pr-3 text-slate-400" aria-label="Cari">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </div>
        </form>

        <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="min-w-full text-sm text-slate-700">
                <thead class="bg-slate-100 text-left text-xs uppercase text-slate-700">
                    <tr>
                        <th class="px-4 py-3">Nama Syarikat</th>
                        <th class="px-4 py-3">Alamat Syarikat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($penggunas as $permohonan)
                        <tr>
                            <td class="px-4 py-3 font-semibold text-slate-900">
                                <div>{{ $permohonan->nama_syarikat ?? '-' }}</div>
                                @php
                                    $companyKey = mb_strtolower(trim((string) $permohonan->nama_syarikat));
                                    $companyApplicationCount = $permohonanCountsByCompany[$companyKey] ?? 0;
                                @endphp
                                @if($companyApplicationCount > 1)
                                    <div class="mt-1 text-xs font-medium text-slate-500">
                                        Bilangan permohonan: {{ $companyApplicationCount }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3">{{ $permohonan->alamat ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-4 py-8 text-center text-slate-400">Tiada rekod permohonan ditemui.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-role-dashboard-layout>
