<x-role-dashboard-layout
    role="jkdm"
    title="SENARAI PERMOHONAN"
    subtitle="Semakan permohonan oleh pegawai JKDM."
    :nav-items="[
        ['label' => 'UTAMA', 'url' => route('jkdm.utama'), 'active' => '/jkdm/utama'],
        ['label' => 'SENARAI LAPORAN', 'url' => route('jkdm.senarailaporan'), 'active' => '/jkdm/senarailaporan'],
        ['label' => 'SENARAI PERMOHONAN', 'url' => route('jkdm.senaraipermohonan'), 'active' => '/jkdm/senaraipermohonan'],
    ]"
>
    <div class="rounded-2xl bg-white/95 p-6 shadow-lg shadow-slate-950/10">
        <p class="text-slate-700">Senarai permohonan JKDM akan dipaparkan di sini.</p>
    </div>
</x-role-dashboard-layout>
