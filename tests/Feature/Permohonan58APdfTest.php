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
        $response->assertHeader('content-type', 'text/html; charset=UTF-8');
        $response->assertSee('Exemption Certificate 58A', false);
    }

    public function test_pelulus_can_preview_exemption_certificate_before_downloading(): void
    {
        $pelulus = $this->user('pelulus');
        $permohonan = $this->permohonan();

        $response = $this->actingAs($pelulus)->get(route('pelulus.permohonan.preview', $permohonan));

        $response->assertOk();
        $response->assertSee('Exemption Certificate 58A', false);
    }

    public function test_admin_can_download_exemption_certificate_pdf(): void
    {
        $admin = $this->user('admin');
        $permohonan = $this->permohonan();

        $response = $this->actingAs($admin)->get(route('admin.permohonan.pdf', $permohonan));

        $response->assertOk();
        $response->assertHeader('content-type', 'text/html; charset=UTF-8');
        $response->assertSee('Exemption Certificate 58A', false);
    }

    public function test_admin_can_preview_exemption_certificate_before_downloading(): void
    {
        $admin = $this->user('admin');
        $permohonan = $this->permohonan();

        $response = $this->actingAs($admin)->get(route('admin.permohonan.preview', $permohonan));

        $response->assertOk();
        $response->assertSee('Exemption Certificate 58A', false);
    }

    private function user(string $role): User
    {
        return User::query()->create([
            'name' => ucfirst($role),
            'login_id' => $role.'-test',
            'role' => $role,
            'password' => Hash::make('password'),
        ]);
    }

    private function permohonan(): Permohonan58A
    {
        $syarikat = $this->user('syarikat');

        return Permohonan58A::query()->create([
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
        ]);
    }
}
