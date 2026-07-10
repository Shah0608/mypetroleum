<x-role-dashboard-layout
    role="jkdm"
    title="UTAMA"
    subtitle="Sistem Maklumat Bunker Petroleum"
    :nav-items="[
        ['label' => 'UTAMA', 'url' => route('jkdm.utama'), 'active' => '/jkdm/utama'],
        ['label' => 'SENARAI LAPORAN', 'url' => route('jkdm.senarailaporan'), 'active' => '/jkdm/senarailaporan'],
        ['label' => 'SENARAI PERMOHONAN', 'url' => route('jkdm.senaraipermohonan'), 'active' => '/jkdm/senaraipermohonan'],
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
                Jumlah Permohonan Ship Chandler: 1
            </div>
            <div class="rounded-xl border border-slate-300 bg-sky-200 px-6 py-5 text-center text-[18px] font-medium text-sky-900">
                Jumlah Penyata Bunkering-01: 1
            </div>
        </div>
    </div>
</x-role-dashboard-layout>
