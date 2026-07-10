<x-role-dashboard-layout
    role="syarikat"
    title="SENARAI LAPORAN"
    subtitle="Senarai laporan yang dihantar oleh syarikat."
    :nav-items="[
        ['label' => 'UTAMA', 'url' => route('syarikat.utama'), 'active' => '/syarikat/utama'],
        ['label' => 'BORANG 58A', 'url' => route('syarikat.permohonan-58a'), 'active' => '/syarikat/permohonan-58a'],
        ['label' => 'LAPORAN CJ', 'url' => route('syarikat.laporan-cj'), 'active' => '/syarikat/laporan-cj'],
        ['label' => 'SENARAI LAPORAN', 'url' => route('syarikat.senarailaporan'), 'active' => '/syarikat/senarailaporan'],
        ['label' => 'SENARAI PERMOHONAN', 'url' => route('syarikat.senaraipermohonan'), 'active' => '/syarikat/senaraipermohonan'],
    ]"
>
    <div class="rounded-2xl bg-white/95 p-6 shadow-lg shadow-slate-950/10">
        <p class="text-slate-700">Senarai laporan syarikat akan dipaparkan di sini.</p>
    </div>
</x-role-dashboard-layout>
