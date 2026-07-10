<x-role-dashboard-layout
    role="admin"
    title="Dashboard Pentadbir"
    subtitle="Pusat kawalan untuk urus pengguna, laporan, dan permohonan sistem MyPetroleum."
    :nav-items="[
        ['label' => 'UTAMA', 'url' => route('admin.utama'), 'active' => '/admin/utama'],
        ['label' => 'URUS PENGGUNA', 'url' => route('admin.uruspengguna'), 'active' => '/admin/uruspengguna'],
        ['label' => 'TAMBAH PENGGUNA', 'url' => route('admin.tambahpengguna'), 'active' => '/admin/tambahpengguna'],
        ['label' => 'SENARAI LAPORAN', 'url' => route('admin.senarailaporan'), 'active' => '/admin/senarailaporan'],
        ['label' => 'SENARAI PERMOHONAN', 'url' => route('admin.senaraipermohonan'), 'active' => '/admin/senaraipermohonan'],
    ]"
>
    <div class="grid gap-6 md:grid-cols-3">
        <div class="rounded-2xl bg-white/95 p-6 shadow-lg shadow-slate-950/10">
            <p class="text-sm font-semibold uppercase tracking-wide text-sky-700">Admin</p>
            <h2 class="mt-2 text-xl font-bold text-slate-900">Urusan sistem</h2>
            <p class="mt-3 text-sm leading-6 text-slate-600">Pantau pengguna, permohonan dan laporan daripada satu pusat.</p>
        </div>
        <div class="rounded-2xl bg-white/95 p-6 shadow-lg shadow-slate-950/10">
            <p class="text-sm font-semibold uppercase tracking-wide text-sky-700">Navigasi</p>
            <h2 class="mt-2 text-xl font-bold text-slate-900">Pautan lengkap</h2>
            <p class="mt-3 text-sm leading-6 text-slate-600">Semua halaman admin kini boleh dicapai melalui menu atas.</p>
        </div>
        <div class="rounded-2xl bg-white/95 p-6 shadow-lg shadow-slate-950/10">
            <p class="text-sm font-semibold uppercase tracking-wide text-sky-700">Tema</p>
            <h2 class="mt-2 text-xl font-bold text-slate-900">MyPetroleum Admin</h2>
            <p class="mt-3 text-sm leading-6 text-slate-600">Tajuk navigasi ikut format yang sama seperti contoh yang anda beri.</p>
        </div>
    </div>
</x-role-dashboard-layout>
