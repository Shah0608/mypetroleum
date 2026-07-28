<?php

namespace Tests\Feature\Syarikat;

use App\Models\LaporanCjp;
use App\Models\Permohonan58A;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_syarikat_dashboard_links_counts_to_related_pages(): void
    {
        $user = User::query()->create([
            'name' => 'Syarikat User',
            'login_id' => 'syarikat-1',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        Permohonan58A::query()->create([
            'user_id' => $user->id,
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

        LaporanCjp::query()->create([
            'user_id' => $user->id,
            'negeri' => 'Melaka',
            'nama_syarikat' => 'ATIFA TOWAGE AND TRANSPORT SDN BHD',
            'tahun' => 2026,
            'bulan' => 'Julai',
            'fail_path' => null,
        ]);

        $response = $this->actingAs($user)->get(route('syarikat.utama'));

        $response->assertOk();
        $response->assertSee(route('syarikat.senaraipermohonan'), false);
        $response->assertSee(route('syarikat.senarailaporan'), false);
        $response->assertSee('Jumlah Permohonan: 1', false);
        $response->assertSee('Jumlah Laporan CJ(P): 1', false);
    }
}
