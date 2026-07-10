<x-role-dashboard-layout
    role="syarikat"
    title="UTAMA"
    subtitle="Sistem Maklumat Bunker Petroleum"
    :nav-items="[
        ['label' => 'UTAMA', 'url' => route('syarikat.utama'), 'active' => '/syarikat/utama'],
        ['label' => 'BORANG 58A', 'url' => route('syarikat.permohonan-58a'), 'active' => '/syarikat/permohonan-58a'],
        ['label' => 'LAPORAN CJ', 'url' => route('syarikat.laporan-cj'), 'active' => '/syarikat/laporan-cj'],
        ['label' => 'SENARAI LAPORAN', 'url' => route('syarikat.senarailaporan'), 'active' => '/syarikat/senarailaporan'],
        ['label' => 'SENARAI PERMOHONAN', 'url' => route('syarikat.senaraipermohonan'), 'active' => '/syarikat/senaraipermohonan'],
    ]"
>
    <div class="space-y-8">
        <div class="space-y-5">
            <p>Selamat Datang ke MyPetroleum- Sistem Maklumat Bunker Petroleum.</p>

            <p>Sistem MyPetroleum dibangunkan sebagai satu platform untuk memohon pengecualian cukai jualan bagi bagi minyak bunker ke atas kapal-kapal yang layak. Bunkering adalah proses menyalurkan bahan petroleum untuk menggerakkan enjin kapal.</p>

            <p>Di bawah Seksyen 35(1) Akta Cukai Jualan 2018, aktiviti bunkering telah diberikan pengecualian cukai jualan ke atas kapal-kapal yang layak di bawah Butiran 58 dan 58 A , Perintah Cukai Jualan (Orang Yang Dikecualikan Daripada Pembayaran Cukai) 2018.</p>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div class="rounded-xl border border-slate-300 bg-sky-200 px-6 py-5 text-center text-[18px] font-medium text-sky-900">
                Jumlah Permohonan: 1
            </div>
            <div class="rounded-xl border border-slate-300 bg-sky-200 px-6 py-5 text-center text-[18px] font-medium text-sky-900">
                Jumlah Penyata Bunkering-01: 1
            </div>
        </div>
    </div>
</x-role-dashboard-layout>
