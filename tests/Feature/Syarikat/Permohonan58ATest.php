<?php

namespace Tests\Feature\Syarikat;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class Permohonan58ATest extends TestCase
{
    use RefreshDatabase;

    public function test_permohonan_58a_cannot_be_submitted_with_missing_fields(): void
    {
        $user = User::query()->create([
            'name' => 'Test User',
            'login_id' => 'tester',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        $response = $this->actingAs($user)->post(route('syarikat.permohonan-58a.store'), []);

        $response->assertSessionHasErrors([
            'nama',
            'no_telefon',
            'email',
            'no_kp',
            'jawatan',
            'nama_syarikat',
            'tarikh_permohonan',
            'no_kelulusan',
            'no_pesanan_belian',
            'alamat',
            'negeri',
            'tandatangan_nama',
            'tandatangan_no_kp',
            'tandatangan_jawatan',
            'pembekal_nama',
            'pembekal_alamat',
            'kod_tarif',
            'perihal_barang',
            'unit',
            'deskripsi',
            'kuantiti',
            'nilai',
            'kawasan',
            'attachments',
        ]);
    }

    public function test_complete_permohonan_58a_can_be_submitted(): void
    {
        $user = User::query()->create([
            'name' => 'Test User',
            'login_id' => 'tester',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        $payload = [
            'nama' => 'Tester',
            'no_telefon' => '0123456789',
            'email' => 'tester@example.com',
            'no_kp' => '900101-01-1234',
            'jawatan' => 'Pengurus',
            'nama_syarikat' => 'Tester Sdn Bhd',
            'no_pendaftaran_cukai' => 'C1234567890',
            'tarikh_permohonan' => '2026-07-23',
            'no_kelulusan' => 'JKDM-001',
            'no_pesanan_belian' => 'PO-001',
            'alamat' => 'Alamat 1, Kuala Lumpur',
            'negeri' => 'WP Kuala Lumpur',
            'tandatangan_nama' => 'Tester',
            'tandatangan_no_kp' => '900101-01-1234',
            'tandatangan_jawatan' => 'Pengurus',
            'pembekal_nama' => 'Pembekal Sdn Bhd',
            'pembekal_alamat' => 'Alamat Pembekal',
            'kod_tarif' => ['1234'],
            'perihal_barang' => ['Minyak bunker'],
            'unit' => ['liter'],
            'deskripsi' => ['Barang lengkap'],
            'kuantiti' => [10],
            'nilai' => [1000],
            'kawasan' => ['Port Klang'],
            'attachments' => [
                UploadedFile::fake()->create('ssm.pdf', 100, 'application/pdf'),
            ],
        ];

        $response = $this->actingAs($user)->post(route('syarikat.permohonan-58a.store'), $payload);

        $response->assertRedirect(route('syarikat.senaraipermohonan'));
        $this->assertDatabaseCount('permohonan_58a', 1);
    }

    public function test_complete_permohonan_58a_can_be_submitted_without_tax_registration_number(): void
    {
        $user = User::query()->create([
            'name' => 'Test User',
            'login_id' => 'tester',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        $payload = [
            'nama' => 'Tester',
            'no_telefon' => '0123456789',
            'email' => 'tester@example.com',
            'no_kp' => '900101-01-1234',
            'jawatan' => 'Pengurus',
            'nama_syarikat' => 'Tester Sdn Bhd',
            'no_pendaftaran_cukai' => '',
            'tarikh_permohonan' => '2026-07-23',
            'no_kelulusan' => 'JKDM-001',
            'no_pesanan_belian' => 'PO-001',
            'alamat' => 'Alamat 1, Kuala Lumpur',
            'negeri' => 'WP Kuala Lumpur',
            'tandatangan_nama' => 'Tester',
            'tandatangan_no_kp' => '900101-01-1234',
            'tandatangan_jawatan' => 'Pengurus',
            'pembekal_nama' => 'Pembekal Sdn Bhd',
            'pembekal_alamat' => 'Alamat Pembekal',
            'kod_tarif' => ['1234'],
            'perihal_barang' => ['Minyak bunker'],
            'unit' => ['liter'],
            'deskripsi' => ['Barang lengkap'],
            'kuantiti' => [10],
            'nilai' => [1000],
            'kawasan' => ['Port Klang'],
            'attachments' => [
                UploadedFile::fake()->create('ssm.pdf', 100, 'application/pdf'),
            ],
        ];

        $response = $this->actingAs($user)->post(route('syarikat.permohonan-58a.store'), $payload);

        $response->assertRedirect(route('syarikat.senaraipermohonan'));
        $this->assertDatabaseCount('permohonan_58a', 1);
    }
}
