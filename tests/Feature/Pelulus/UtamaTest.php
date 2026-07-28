<?php

namespace Tests\Feature\Pelulus;

use App\Models\Permohonan58A;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UtamaTest extends TestCase
{
    use RefreshDatabase;

    public function test_pelulus_dashboard_shows_counts_linked_to_related_pages(): void
    {
        $pelulus = User::query()->create([
            'name' => 'Pelulus',
            'login_id' => 'pelulus-1',
            'role' => 'pelulus',
            'password' => Hash::make('password'),
        ]);

        $user = User::query()->create([
            'name' => 'Pengguna Syarikat',
            'login_id' => 'syarikat-1',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        Permohonan58A::query()->create([
            'user_id' => $user->id,
            'nama' => 'Pengguna Syarikat',
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
            'tandatangan_nama' => 'Pengguna Syarikat',
            'tandatangan_no_kp' => '900101-01-1234',
            'tandatangan_jawatan' => 'Pengurus',
            'pembekal_nama' => 'Pembekal Sdn Bhd',
            'pembekal_alamat' => 'Alamat Pembekal',
            'barangs' => [],
            'attachments' => [],
            'status' => 'Dalam tindakan',
        ]);

        $response = $this->actingAs($pelulus)->get(route('pelulus.utama'));

        $response->assertOk();
        $response->assertSee(route('pelulus.senarai-pengguna'), false);
        $response->assertSee(route('pelulus.senaraipermohonan'), false);
        $response->assertSee('Jumlah Pengguna: <span class="font-bold">1</span>', false);
        $response->assertSee('Jumlah Permohonan: <span class="font-bold">1</span>', false);
    }
}
