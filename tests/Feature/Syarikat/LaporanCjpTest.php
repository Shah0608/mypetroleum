<?php

namespace Tests\Feature\Syarikat;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LaporanCjpTest extends TestCase
{
    use RefreshDatabase;

    public function test_nama_syarikat_defaults_to_authenticated_users_name(): void
    {
        $user = User::query()->create([
            'name' => 'Test User',
            'nama_syarikat' => 'ATIFA TOWAGE AND TRANSPORT SDN BHD',
            'login_id' => 'tester-syarikat',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        $response = $this->actingAs($user)->get(route('syarikat.laporan-cj'));

        $response->assertOk();
        $response->assertSee('value="ATIFA TOWAGE AND TRANSPORT SDN BHD"', false);
        $response->assertSee('name="nama_syarikat"', false);
        $response->assertSee('readonly', false);
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

        $response = $this->actingAs($user)->post(route('syarikat.laporan-cj.store'), [
            'negeri' => 'Melaka',
            'nama_syarikat' => 'Fake Company Name',
            'tahun' => 2026,
            'bulan' => 'Julai',
        ]);

        $response->assertRedirect(route('syarikat.senarailaporan'));
        $this->assertDatabaseHas('laporan_cjps', [
            'user_id' => $user->id,
            'nama_syarikat' => 'ATIFA TOWAGE AND TRANSPORT SDN BHD',
        ]);
        $this->assertDatabaseMissing('laporan_cjps', [
            'user_id' => $user->id,
            'nama_syarikat' => 'Fake Company Name',
        ]);
    }
}
