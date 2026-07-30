<?php

namespace Tests\Feature\Jkdm;

use App\Models\LaporanCjp;
use App\Models\Permohonan58A;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_jkdm_dashboard_links_laporan_count_to_senarai_laporan(): void
    {
        $user = User::query()->create([
            'name' => 'JKDM User',
            'login_id' => 'jkdm-1',
            'role' => 'jkdm',
            'password' => Hash::make('password'),
        ]);

        $syarikat = User::query()->create([
            'name' => 'Syarikat User',
            'login_id' => 'syarikat-1',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        LaporanCjp::query()->create([
            'user_id' => $syarikat->id,
            'negeri' => 'Melaka',
            'nama_syarikat' => 'ATIFA TOWAGE AND TRANSPORT SDN BHD',
            'tahun' => 2026,
            'bulan' => 'Julai',
            'fail_path' => null,
        ]);

        $response = $this->actingAs($user)->get(route('jkdm.utama'));

        $response->assertOk();
        $response->assertSee(route('jkdm.senarailaporan'), false);
        $response->assertSee('Jumlah Laporan CJ(P): 1', false);
    }

    public function test_jkdm_review_page_shows_verification_and_unit_review_sections(): void
    {
        $jkdm = User::query()->create([
            'name' => 'JKDM User',
            'login_id' => 'jkdm-1',
            'role' => 'jkdm',
            'password' => Hash::make('password'),
        ]);

        $syarikat = User::query()->create([
            'name' => 'Syarikat User',
            'login_id' => 'syarikat-1',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        $permohonan = Permohonan58A::query()->create([
            'user_id' => $syarikat->id,
            'nama' => 'Syarikat User',
            'no_telefon' => '0123456789',
            'email' => 'syarikat@example.com',
            'no_kp' => '900101-01-1234',
            'jawatan' => 'Pengurus',
            'nama_syarikat' => 'ATIFA TOWAGE AND TRANSPORT SDN BHD',
            'tarikh_permohonan' => '2026-07-21',
            'no_kelulusan' => 'JKDM-001',
            'no_pesanan_belian' => 'PO-001',
            'alamat' => 'Pelabuhan Miri',
            'negeri' => 'Melaka',
            'tandatangan_nama' => 'Syarikat User',
            'tandatangan_no_kp' => '900101-01-1234',
            'tandatangan_jawatan' => 'Pengurus',
            'pembekal_nama' => 'Pembekal Sdn Bhd',
            'pembekal_alamat' => 'Alamat Pembekal',
            'barangs' => [],
            'attachments' => [],
            'status' => 'Dalam tindakan',
            'ulasan_pegawai_verifikasi' => 'Disemak.',
            'nama_pegawai_verifikasi' => 'Pegawai Verifikasi',
            'tarikh_ulasan_verifikasi' => '2026-07-20',
            'tarikh_tamat_pda2_verifikasi' => '2028-07-20',
            'ulasan_ketua_unit' => 'Disahkan.',
            'nama_pegawai_ketua_unit' => 'Ketua Unit',
            'tarikh_ulasan_ketua_unit' => '2026-07-21',
            'tarikh_tamat_pda2_ketua_unit' => '2028-07-21',
        ]);

        $response = $this->actingAs($jkdm)->get(route('jkdm.permohonan.semak', $permohonan));

        $response->assertOk();
        $response->assertSee('Ulasan Pegawai Verifikasi', false);
        $response->assertSee('Ulasan Ketua Unit/Cawangan', false);
        $response->assertSee('textarea name="ulasan_pegawai_verifikasi"', false);
        $response->assertSee('Simpan', false);
        $response->assertSee('Ketua Unit', false);
        $response->assertDontSee('textarea name="ulasan_ketua_unit"', false);
        $response->assertDontSee('Hantar', false);
    }

    public function test_jkdm_update_only_saves_submitted_review_section(): void
    {
        $jkdm = User::query()->create([
            'name' => 'JKDM User',
            'login_id' => 'jkdm-1',
            'role' => 'jkdm',
            'password' => Hash::make('password'),
        ]);

        $syarikat = User::query()->create([
            'name' => 'Syarikat User',
            'login_id' => 'syarikat-1',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        $permohonan = Permohonan58A::query()->create([
            'user_id' => $syarikat->id,
            'nama' => 'Syarikat User',
            'no_telefon' => '0123456789',
            'email' => 'syarikat@example.com',
            'no_kp' => '900101-01-1234',
            'jawatan' => 'Pengurus',
            'nama_syarikat' => 'ATIFA TOWAGE AND TRANSPORT SDN BHD',
            'tarikh_permohonan' => '2026-07-21',
            'no_kelulusan' => 'JKDM-001',
            'no_pesanan_belian' => 'PO-001',
            'alamat' => 'Pelabuhan Miri',
            'negeri' => 'Melaka',
            'tandatangan_nama' => 'Syarikat User',
            'tandatangan_no_kp' => '900101-01-1234',
            'tandatangan_jawatan' => 'Pengurus',
            'pembekal_nama' => 'Pembekal Sdn Bhd',
            'pembekal_alamat' => 'Alamat Pembekal',
            'barangs' => [],
            'attachments' => [],
            'status' => 'Dalam tindakan',
        ]);

        $this->actingAs($jkdm)->put(route('jkdm.permohonan.update', $permohonan), [
            'review_section' => 'verifikasi',
            'ulasan_pegawai_verifikasi' => 'Disemak dan disokong.',
            'nama_pegawai_verifikasi' => 'Pegawai Verifikasi',
            'tarikh_ulasan_verifikasi' => '2026-07-20',
            'tarikh_tamat_pda2_verifikasi' => '2028-07-20',
        ])->assertRedirect(route('jkdm.senaraipermohonan'));

        $permohonan->refresh();

        $this->assertSame('Disemak dan disokong.', $permohonan->ulasan_pegawai_verifikasi);
        $this->assertSame('Pegawai Verifikasi', $permohonan->nama_pegawai_verifikasi);
        $this->assertSame('2026-07-20', $permohonan->tarikh_ulasan_verifikasi?->format('Y-m-d'));
        $this->assertSame('2028-07-20', $permohonan->tarikh_tamat_pda2_verifikasi?->format('Y-m-d'));
        $this->assertNull($permohonan->ulasan_ketua_unit);

        $response = $this->actingAs($jkdm)->get(route('jkdm.permohonan.semak', $permohonan));

        $response->assertOk();
        $response->assertSee('Disemak dan disokong.', false);
        $response->assertSee('Pegawai Verifikasi', false);
        $response->assertSee('value="2026-07-20"', false);
        $response->assertSee('value="2028-07-20"', false);
        $response->assertSee('textarea name="ulasan_pegawai_verifikasi"', false);
        $response->assertSee('Simpan', false);

        $this->actingAs($jkdm)->put(route('jkdm.permohonan.update', $permohonan), [
            'review_section' => 'ketua_unit',
            'ulasan_ketua_unit' => 'Disahkan.',
            'nama_pegawai_ketua_unit' => 'Ketua Unit',
            'tarikh_ulasan_ketua_unit' => '2026-07-21',
            'tarikh_tamat_pda2_ketua_unit' => '2028-07-21',
        ])->assertRedirect(route('jkdm.senaraipermohonan'));

        $permohonan->refresh();

        $this->assertSame('Disemak dan disokong.', $permohonan->ulasan_pegawai_verifikasi);
        $this->assertSame('Disahkan.', $permohonan->ulasan_ketua_unit);
    }

    public function test_ketua_unit_jkdm_can_view_review_page_but_cannot_edit_it(): void
    {
        $ketuaUnit = User::query()->create([
            'name' => 'Ketua Unit JKDM',
            'login_id' => 'ketua-unit-1',
            'role' => 'ketua_unit_jkdm',
            'password' => Hash::make('password'),
        ]);

        $syarikat = User::query()->create([
            'name' => 'Syarikat User',
            'login_id' => 'syarikat-1',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        $permohonan = Permohonan58A::query()->create([
            'user_id' => $syarikat->id,
            'nama' => 'Syarikat User',
            'no_telefon' => '0123456789',
            'email' => 'syarikat@example.com',
            'no_kp' => '900101-01-1234',
            'jawatan' => 'Pengurus',
            'nama_syarikat' => 'ATIFA TOWAGE AND TRANSPORT SDN BHD',
            'tarikh_permohonan' => '2026-07-21',
            'no_kelulusan' => 'JKDM-001',
            'no_pesanan_belian' => 'PO-001',
            'alamat' => 'Pelabuhan Miri',
            'negeri' => 'Melaka',
            'tandatangan_nama' => 'Syarikat User',
            'tandatangan_no_kp' => '900101-01-1234',
            'tandatangan_jawatan' => 'Pengurus',
            'pembekal_nama' => 'Pembekal Sdn Bhd',
            'pembekal_alamat' => 'Alamat Pembekal',
            'barangs' => [],
            'attachments' => [],
            'status' => 'Dalam tindakan',
            'ulasan_pegawai_verifikasi' => 'Disemak.',
            'nama_pegawai_verifikasi' => 'Pegawai Verifikasi',
            'tarikh_ulasan_verifikasi' => '2026-07-20',
            'tarikh_tamat_pda2_verifikasi' => '2028-07-20',
        ]);

        $response = $this->actingAs($ketuaUnit)->get(route('ketua.permohonan.semak', $permohonan));

        $response->assertOk();
        $response->assertSee('Ulasan Pegawai Verifikasi', false);
        $response->assertSee('Disemak.', false);
        $response->assertSee('Pegawai Verifikasi', false);
        $response->assertSee('20/07/2026', false);
        $response->assertSee('20/07/2028', false);
        $response->assertSee('Ulasan Ketua Unit/Cawangan', false);
        $response->assertDontSee('textarea name="ulasan_pegawai_verifikasi"', false);
        $response->assertDontSee('name="nama_pegawai_verifikasi"', false);
        $response->assertDontSee('name="tarikh_ulasan_verifikasi"', false);
        $response->assertDontSee('name="tarikh_tamat_pda2_verifikasi"', false);
        $response->assertSee('name="ulasan_ketua_unit"', false);
        $response->assertSee('Hantar', false);
    }

    public function test_ketua_unit_review_page_uses_verification_pda2_date_when_available(): void
    {
        $ketuaUnit = User::query()->create([
            'name' => 'Ketua Unit JKDM',
            'login_id' => 'ketua-unit-1',
            'role' => 'ketua_unit_jkdm',
            'password' => Hash::make('password'),
        ]);

        $syarikat = User::query()->create([
            'name' => 'Syarikat User',
            'login_id' => 'syarikat-1',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        $permohonan = Permohonan58A::query()->create([
            'user_id' => $syarikat->id,
            'nama' => 'Syarikat User',
            'no_telefon' => '0123456789',
            'email' => 'syarikat@example.com',
            'no_kp' => '900101-01-1234',
            'jawatan' => 'Pengurus',
            'nama_syarikat' => 'ATIFA TOWAGE AND TRANSPORT SDN BHD',
            'tarikh_permohonan' => '2026-07-21',
            'no_kelulusan' => 'JKDM-001',
            'no_pesanan_belian' => 'PO-001',
            'alamat' => 'Pelabuhan Miri',
            'negeri' => 'Melaka',
            'tandatangan_nama' => 'Syarikat User',
            'tandatangan_no_kp' => '900101-01-1234',
            'tandatangan_jawatan' => 'Pengurus',
            'pembekal_nama' => 'Pembekal Sdn Bhd',
            'pembekal_alamat' => 'Alamat Pembekal',
            'barangs' => [],
            'attachments' => [],
            'status' => 'Dalam tindakan',
            'ulasan_pegawai_verifikasi' => 'Disemak.',
            'nama_pegawai_verifikasi' => 'Pegawai Verifikasi',
            'tarikh_ulasan_verifikasi' => '2026-07-20',
            'tarikh_tamat_pda2_verifikasi' => '2028-07-20',
        ]);

        $response = $this->actingAs($ketuaUnit)->get(route('ketua.permohonan.semak', $permohonan));

        $response->assertOk();
        $response->assertSee('20/07/2028', false);
        $response->assertSee('Tarikh Tamat PDA 2', false);
    }

    public function test_ketua_unit_jkdm_can_update_existing_ketua_unit_review_section(): void
    {
        $ketuaUnit = User::query()->create([
            'name' => 'Ketua Unit JKDM',
            'login_id' => 'ketua-unit-1',
            'role' => 'ketua_unit_jkdm',
            'password' => Hash::make('password'),
        ]);

        $syarikat = User::query()->create([
            'name' => 'Syarikat User',
            'login_id' => 'syarikat-1',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        $permohonan = Permohonan58A::query()->create([
            'user_id' => $syarikat->id,
            'nama' => 'Syarikat User',
            'no_telefon' => '0123456789',
            'email' => 'syarikat@example.com',
            'no_kp' => '900101-01-1234',
            'jawatan' => 'Pengurus',
            'nama_syarikat' => 'ATIFA TOWAGE AND TRANSPORT SDN BHD',
            'tarikh_permohonan' => '2026-07-21',
            'no_kelulusan' => 'JKDM-001',
            'no_pesanan_belian' => 'PO-001',
            'alamat' => 'Pelabuhan Miri',
            'negeri' => 'Melaka',
            'tandatangan_nama' => 'Syarikat User',
            'tandatangan_no_kp' => '900101-01-1234',
            'tandatangan_jawatan' => 'Pengurus',
            'pembekal_nama' => 'Pembekal Sdn Bhd',
            'pembekal_alamat' => 'Alamat Pembekal',
            'barangs' => [],
            'attachments' => [],
            'status' => 'Dalam tindakan',
            'ulasan_ketua_unit' => 'Ulasan lama.',
            'nama_pegawai_ketua_unit' => 'Pegawai Lama',
            'tarikh_ulasan_ketua_unit' => '2026-07-21',
            'tarikh_tamat_pda2_ketua_unit' => '2028-07-21',
        ]);

        $response = $this->actingAs($ketuaUnit)->get(route('ketua.permohonan.semak', $permohonan));

        $response->assertOk();
        $response->assertSee('textarea name="ulasan_ketua_unit"', false);
        $response->assertSee('Ulasan lama.', false);

        $this->actingAs($ketuaUnit)->put(route('ketua.permohonan.update', $permohonan), [
            'review_section' => 'ketua_unit',
            'ulasan_ketua_unit' => 'Ulasan baharu.',
            'nama_pegawai_ketua_unit' => 'Ketua Unit Baharu',
            'tarikh_ulasan_ketua_unit' => '2026-07-28',
            'tarikh_tamat_pda2_ketua_unit' => '2028-07-28',
        ])->assertRedirect(route('ketua.senaraipermohonan'));

        $permohonan->refresh();

        $this->assertSame('Ulasan baharu.', $permohonan->ulasan_ketua_unit);
        $this->assertSame('Ketua Unit Baharu', $permohonan->nama_pegawai_ketua_unit);
        $this->assertSame('2026-07-28', $permohonan->tarikh_ulasan_ketua_unit?->format('Y-m-d'));
        $this->assertSame('2028-07-28', $permohonan->tarikh_tamat_pda2_ketua_unit?->format('Y-m-d'));
    }

    public function test_ketua_unit_dashboard_routes_are_available(): void
    {
        $ketuaUnit = User::query()->create([
            'name' => 'Ketua Unit JKDM',
            'login_id' => 'ketua-unit-1',
            'role' => 'ketua_unit_jkdm',
            'password' => Hash::make('password'),
        ]);

        LaporanCjp::query()->create([
            'user_id' => $ketuaUnit->id,
            'negeri' => 'Melaka',
            'nama_syarikat' => 'Syarikat Ketua',
            'tahun' => 2026,
            'bulan' => 'Julai',
            'fail_path' => null,
        ]);

        $response = $this->actingAs($ketuaUnit)->get(route('ketua.utama'));

        $response->assertOk();
        $response->assertDontSee('MyPetroleum KETUA', false);
        $response->assertSee(route('ketua.senarailaporan'), false);
        $response->assertSee(route('ketua.senaraipermohonan'), false);
        $response->assertSee('Jumlah Permohonan: 0', false);
        $response->assertSee('Jumlah Laporan CJ(P): 1', false);
    }

    public function test_ketua_unit_can_view_senarai_laporan_page(): void
    {
        $ketuaUnit = User::query()->create([
            'name' => 'Ketua Unit JKDM',
            'login_id' => 'ketua-unit-1',
            'role' => 'ketua_unit_jkdm',
            'password' => Hash::make('password'),
        ]);

        $syarikat = User::query()->create([
            'name' => 'Syarikat User',
            'login_id' => 'syarikat-1',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        LaporanCjp::query()->create([
            'user_id' => $syarikat->id,
            'negeri' => 'Melaka',
            'nama_syarikat' => 'ATIFA TOWAGE AND TRANSPORT SDN BHD',
            'tahun' => 2026,
            'bulan' => 'Julai',
            'fail_path' => 'laporan-cjp/sample.pdf',
        ]);

        $response = $this->actingAs($ketuaUnit)->get(route('ketua.senarailaporan'));

        $response->assertOk();
        $response->assertSee('Senarai Laporan CJ(P) Jadual A-58A', false);
        $response->assertSee('ATIFA TOWAGE AND TRANSPORT SDN BHD', false);
        $response->assertSee('pdf', false);
    }

    public function test_jkdm_senarai_permohonan_shows_tempoh_hari_for_approved_application(): void
    {
        Carbon::setTestNow(Carbon::create(2026, 7, 30, 0, 0, 0));

        $jkdm = User::query()->create([
            'name' => 'JKDM User',
            'login_id' => 'jkdm-1',
            'role' => 'jkdm',
            'password' => Hash::make('password'),
        ]);

        $syarikat = User::query()->create([
            'name' => 'Syarikat User',
            'login_id' => 'syarikat-1',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        $permohonan = Permohonan58A::query()->create([
            'user_id' => $syarikat->id,
            'nama' => 'Syarikat User',
            'no_telefon' => '0123456789',
            'email' => 'syarikat@example.com',
            'no_kp' => '900101-01-1234',
            'jawatan' => 'Pengurus',
            'nama_syarikat' => 'ATIFA TOWAGE AND TRANSPORT SDN BHD',
            'tarikh_permohonan' => '2026-07-21',
            'no_kelulusan' => 'JKDM-001',
            'no_pesanan_belian' => 'PO-001',
            'alamat' => 'Pelabuhan Miri',
            'negeri' => 'Melaka',
            'tandatangan_nama' => 'Syarikat User',
            'tandatangan_no_kp' => '900101-01-1234',
            'tandatangan_jawatan' => 'Pengurus',
            'pembekal_nama' => 'Pembekal Sdn Bhd',
            'pembekal_alamat' => 'Alamat Pembekal',
            'barangs' => [],
            'attachments' => [],
            'status' => 'Diluluskan',
            'no_sijil_pengecualian' => 'M10-58A-2607-0001',
            'tarikh_diluluskan' => '2026-07-27',
            'tarikh_tamat' => '2026-12-31',
        ]);

        $response = $this->actingAs($jkdm)->get(route('jkdm.senaraipermohonan'));

        $response->assertOk();
        $response->assertSee('Tempoh Hari', false);
        $response->assertSee($permohonan->tempoh_hari_label, false);
        $response->assertSee($permohonan->baki_hari_label, false);

        Carbon::setTestNow();
    }
}
