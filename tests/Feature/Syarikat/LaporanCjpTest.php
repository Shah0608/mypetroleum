<?php

namespace Tests\Feature\Syarikat;

use App\Models\LaporanCjp;
use App\Models\Permohonan58A;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LaporanCjpTest extends TestCase
{
    use RefreshDatabase;

    public function test_laporan_form_prefills_approved_certificate_data(): void
    {
        $user = User::query()->create([
            'name' => 'Test User',
            'nama_syarikat' => 'ATIFA TOWAGE AND TRANSPORT SDN BHD',
            'login_id' => 'tester-syarikat',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        $permohonan = $this->approvedApplication($user);

        $response = $this->actingAs($user)->get(route('syarikat.laporan-cj'));

        $response->assertOk();
        $response->assertSee($permohonan->no_sijil_pengecualian, false);
        $response->assertSee('Kod Tarif / Perihal Barang', false);
        $response->assertSee('Tambah Pembelian', false);
        $response->assertSee('Tambah Penjualan', false);
        $response->assertSee("textContent = 'Ltr'", false);
    }

    public function test_laporan_cjp_uses_authenticated_users_company_name_when_storing(): void
    {
        $user = User::query()->create([
            'name' => 'Test User',
            'nama_syarikat' => 'ATIFA TOWAGE AND TRANSPORT SDN BHD',
            'login_id' => 'tester-syarikat',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        $permohonan = $this->approvedApplication($user);

        $response = $this->actingAs($user)->post(route('syarikat.laporan-cj.store'), [
            'permohonan_58a_id' => $permohonan->id,
            'barang_index' => 0,
            'negeri' => 'Melaka',
            'tahun' => 2026,
            'bulan' => 'Julai',
            'baki_awal' => 50,
            'pembelians' => [[
                'tarikh' => '2026-07-01',
                'no_invois' => 'DO-001',
                'no_k9' => 'K9-001',
                'kuantiti' => 200,
                'nilai' => 12500,
            ]],
            'penjualans' => [[
                'tarikh' => '2026-07-02',
                'nama_kapal' => 'Kapal Contoh',
                'pelabuhan' => 'Melaka',
                'no_invois' => 'INV-001',
                'kuantiti' => 125,
                'nilai' => 8000,
            ]],
            'nama_penuh' => 'Test User',
            'jawatan' => 'Pengurus',
            'no_telefon' => '0123456789',
        ]);

        $response->assertRedirect(route('syarikat.senarailaporan'));
        $this->assertDatabaseHas('laporan_cjps', [
            'user_id' => $user->id,
            'nama_syarikat' => 'ATIFA TOWAGE AND TRANSPORT SDN BHD',
            'no_sijil_pengecualian' => $permohonan->no_sijil_pengecualian,
            'baki_kuantiti_diluluskan' => 800,
            'baki_akhir' => 125,
        ]);

        $this->actingAs($user)->get(route('syarikat.senarailaporan'))
            ->assertOk()
            ->assertSee('800', false)
            ->assertDontSee('800.000', false);
    }

    public function test_syarikat_can_preview_its_structured_report_but_not_another_companys_report(): void
    {
        $user = $this->user('Syarikat A');
        $otherUser = $this->user('Syarikat B');
        $laporan = LaporanCjp::query()->create([
            'user_id' => $user->id,
            'negeri' => 'Melaka',
            'nama_syarikat' => 'Syarikat A',
            'tahun' => 2026,
            'bulan' => 'Julai',
            'no_sijil_pengecualian' => 'M10-58A-2607-0001',
            'kuantiti_diluluskan' => 1000,
            'baki_kuantiti_diluluskan' => 1000,
            'baki_awal' => 0,
            'baki_akhir' => 0,
            'nama_penuh' => 'Syarikat A',
            'jawatan' => 'Pengurus',
            'no_telefon' => '0123456789',
        ]);

        $this->actingAs($user)->get(route('syarikat.laporan.preview', $laporan))
            ->assertOk()
            ->assertSee('LAPORAN CJ(P) JADUAL A-58A', false);

        $this->actingAs($otherUser)->get(route('syarikat.laporan.preview', $laporan))
            ->assertForbidden();
    }

    public function test_every_role_list_shows_the_generated_report_pdf_button(): void
    {
        $syarikat = $this->user('Syarikat A');
        $laporan = LaporanCjp::query()->create([
            'user_id' => $syarikat->id,
            'negeri' => 'Melaka',
            'nama_syarikat' => 'Syarikat A',
            'tahun' => 2026,
            'bulan' => 'Julai',
            'no_sijil_pengecualian' => 'M10-58A-2607-0001',
            'kuantiti_diluluskan' => 1000,
            'baki_kuantiti_diluluskan' => 1000,
            'baki_awal' => 0,
            'baki_akhir' => 0,
            'nama_penuh' => 'Syarikat A',
            'jawatan' => 'Pengurus',
            'no_telefon' => '0123456789',
        ]);

        $this->actingAs($syarikat)->get(route('syarikat.senarailaporan'))
            ->assertOk()
            ->assertSee('openLaporanCjpPreview', false);

        foreach (['admin' => 'admin.senarailaporan', 'jkdm' => 'jkdm.senarailaporan', 'ketua_unit_jkdm' => 'ketua.senarailaporan'] as $role => $route) {
            $pegawai = User::query()->create([
                'name' => ucfirst($role),
                'login_id' => $role,
                'role' => $role,
                'password' => Hash::make('password'),
            ]);

            $this->actingAs($pegawai)->get(route($route))
                ->assertOk()
                ->assertSee('Laporan PDF', false);
        }
    }

    public function test_admin_can_edit_a_report_and_recalculate_its_balances(): void
    {
        $syarikat = $this->user('Syarikat A');
        $admin = User::query()->create([
            'name' => 'Admin',
            'login_id' => 'admin-laporan',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);
        $laporan = LaporanCjp::query()->create([
            'user_id' => $syarikat->id,
            'negeri' => 'Melaka',
            'nama_syarikat' => 'Syarikat A',
            'tahun' => 2026,
            'bulan' => 'Julai',
            'no_sijil_pengecualian' => 'M10-58A-2607-0001',
            'kuantiti_diluluskan' => 1000,
            'baki_kuantiti_diluluskan' => 1000,
            'baki_awal' => 0,
            'baki_akhir' => 0,
            'nama_penuh' => 'Syarikat A',
            'jawatan' => 'Pengurus',
            'no_telefon' => '0123456789',
        ]);

        $this->actingAs($admin)->get(route('admin.senarailaporan'))
            ->assertOk()
            ->assertSee(route('admin.laporan.edit', $laporan), false);

        $this->actingAs($admin)->put(route('admin.laporan.update', $laporan), [
            'negeri' => 'Melaka',
            'tahun' => 2026,
            'bulan' => 'Ogos',
            'baki_awal' => 100,
            'pembelians' => [['kuantiti' => 300, 'nilai' => 12000]],
            'penjualans' => [['kuantiti' => 150, 'nilai' => 6000]],
            'nama_penuh' => 'Admin Kemaskini',
            'jawatan' => 'Pengurus Operasi',
            'no_telefon' => '0191234567',
        ])->assertRedirect(route('admin.senarailaporan'));

        $this->assertDatabaseHas('laporan_cjps', [
            'id' => $laporan->id,
            'bulan' => 'Ogos',
            'baki_awal' => 100,
            'baki_kuantiti_diluluskan' => 700,
            'baki_akhir' => 250,
            'nama_penuh' => 'Admin Kemaskini',
        ]);
    }

    private function user(string $companyName): User
    {
        return User::query()->create([
            'name' => 'Test User',
            'nama_syarikat' => $companyName,
            'login_id' => strtolower(str_replace(' ', '-', $companyName)),
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);
    }

    private function approvedApplication(User $user): Permohonan58A
    {
        return Permohonan58A::query()->create([
            'user_id' => $user->id,
            'nama_syarikat' => 'ATIFA TOWAGE AND TRANSPORT SDN BHD',
            'alamat' => 'Jalan Contoh, Melaka',
            'negeri' => 'Melaka',
            'pembekal_nama' => 'Petronas Dagangan Berhad',
            'barangs' => [['kod_tarif' => '2710197200', 'perihal' => 'Other Diesel Fuel', 'unit' => 'Ltr', 'kuantiti' => 1000]],
            'status' => 'Diluluskan',
            'no_sijil_pengecualian' => 'M10-58A-2607-0001',
            'tarikh_diluluskan' => '2026-07-01',
            'tarikh_tamat' => '2027-07-01',
        ]);
    }
}
