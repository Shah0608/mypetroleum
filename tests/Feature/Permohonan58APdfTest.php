<?php

namespace Tests\Feature;

use App\Models\Permohonan58A;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class Permohonan58APdfTest extends TestCase
{
    use RefreshDatabase;

    public function test_pelulus_can_download_exemption_certificate_pdf(): void
    {
        $pelulus = $this->user('pelulus');
        $permohonan = $this->permohonan();

        $response = $this->actingAs($pelulus)->get(route('pelulus.permohonan.pdf', $permohonan));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_pelulus_can_preview_exemption_certificate_before_downloading(): void
    {
        $pelulus = $this->user('pelulus');
        $permohonan = $this->permohonan([
            'tarikh_tamat_pda2_verifikasi' => '2028-07-20',
        ]);

        $response = $this->actingAs($pelulus)->get(route('pelulus.permohonan.preview', $permohonan));

        $response->assertOk();
        $response->assertSee('Exemption Certificate 58A', false);
        $response->assertSee('20/07/2028', false);
    }

    public function test_pelulus_review_page_shows_full_station_code_options(): void
    {
        $pelulus = $this->user('pelulus');
        $permohonan = $this->permohonan();

        $response = $this->actingAs($pelulus)->get(route('pelulus.permohonan.semak', $permohonan));

        $response->assertOk();
        $response->assertSee('M10 - Melaka', false);
        $response->assertSee('W24 - KLIA CD', false);
        $response->assertSee('Y60 - Kuching', false);
    }

    public function test_admin_can_download_exemption_certificate_pdf(): void
    {
        $admin = $this->user('admin');
        $permohonan = $this->permohonan();

        $response = $this->actingAs($admin)->get(route('admin.permohonan.pdf', $permohonan));

        $response->assertOk();
        $response->assertHeader('content-type', 'text/html; charset=UTF-8');
    }

    public function test_admin_can_preview_exemption_certificate_before_downloading(): void
    {
        $admin = $this->user('admin');
        $permohonan = $this->permohonan();

        $response = $this->actingAs($admin)->get(route('admin.permohonan.preview', $permohonan));

        $response->assertOk();
        $response->assertSee('Exemption Certificate 58A', false);
    }

    public function test_certificate_button_only_appears_for_approved_application_with_certificate_number(): void
    {
        $pelulus = $this->user('pelulus');
        $approved = $this->permohonan();
        $pending = $this->permohonan([
            'nama_syarikat' => 'Syarikat Belum Lulus',
            'status' => 'Dalam tindakan',
            'no_sijil_pengecualian' => null,
            'tarikh_diluluskan' => null,
            'tarikh_tamat' => null,
        ]);

        $response = $this->actingAs($pelulus)->get(route('pelulus.senaraipermohonan'));

        $response->assertOk();
        $response->assertSee('senaraipermohonan\/'.$approved->id.'\/preview', false);
        $response->assertDontSee('senaraipermohonan\/'.$pending->id.'\/preview', false);
    }

    public function test_syarikat_can_preview_own_approved_certificate(): void
    {
        $syarikat = $this->user('syarikat');
        $permohonan = $this->permohonan(['user_id' => $syarikat->id]);

        $response = $this->actingAs($syarikat)->get(route('syarikat.permohonan-58a.preview', $permohonan));

        $response->assertOk();
        $response->assertSee('Exemption Certificate 58A', false);
    }

    public function test_jkdm_receives_popup_when_pelulus_approves_application(): void
    {
        $pelulus = $this->user('pelulus');
        $jkdm = $this->user('jkdm');
        $permohonan = $this->permohonan([
            'status' => 'Dalam tindakan',
            'no_sijil_pengecualian' => null,
            'tarikh_diluluskan' => null,
            'tarikh_tamat' => null,
            'jkdm_notified_at' => now(),
        ]);

        $this->actingAs($pelulus)->put(route('pelulus.permohonan.update', $permohonan), [
            'status' => 'Diluluskan',
            'tarikh_diluluskan' => '2026-07-27',
            'kod_stesen' => 'M10',
            'no_daftar_sijil' => '1',
        ])->assertRedirect(route('pelulus.senaraipermohonan'));

        $response = $this->actingAs($jkdm)->get(route('jkdm.senaraipermohonan'));

        $response->assertOk();
        $response->assertSee('Permohonan telah diluluskan Pelulus', false);
        $response->assertSee('M10-58A-2607-0001', false);
        $this->assertNotNull($permohonan->fresh()->jkdm_notified_at);
    }

    private function user(string $role): User
    {
        return User::query()->create([
            'name' => ucfirst($role),
            'login_id' => $role.'-test-'.User::query()->count(),
            'role' => $role,
            'password' => Hash::make('password'),
        ]);
    }

    private function permohonan(array $overrides = []): Permohonan58A
    {
        $syarikat = $this->user('syarikat');

        return Permohonan58A::query()->create(array_merge([
            'user_id' => $syarikat->id,
            'nama' => 'Ahmad Bin Ali',
            'no_telefon' => '0123456789',
            'email' => 'ahmad@example.com',
            'no_kp' => '900101011234',
            'jawatan' => 'Pengurus',
            'nama_syarikat' => 'Petro Contoh Sdn Bhd',
            'tarikh_permohonan' => '2026-07-27',
            'alamat' => 'Lot 1, Pelabuhan Klang, Selangor',
            'negeri' => 'Selangor',
            'tandatangan_nama' => 'Ahmad Bin Ali',
            'tandatangan_no_kp' => '900101011234',
            'tandatangan_jawatan' => 'Pengurus',
            'pembekal_nama' => 'Pembekal Contoh Sdn Bhd',
            'pembekal_alamat' => 'Alamat Pembekal',
            'barangs' => [
                [
                    'kod_tarif' => '2710.19.71',
                    'perihal' => 'Minyak bunker',
                    'unit' => 'Liter',
                    'deskripsi' => 'Marine fuel oil',
                    'kuantiti' => 1000,
                    'nilai' => 2500,
                    'kawasan' => 'Pelabuhan Klang',
                ],
            ],
            'status' => 'Diluluskan',
            'no_sijil_pengecualian' => 'M10-58A-2607-0001',
            'tarikh_diluluskan' => '2026-07-27',
            'tarikh_tamat' => '2026-12-31',
            'tarikh_tamat_cga' => '2026-12-31',
        ], $overrides));
    }
}
