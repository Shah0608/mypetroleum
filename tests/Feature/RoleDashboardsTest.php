<?php

namespace Tests\Feature;

use App\Models\LaporanCjp;
use App\Models\Permohonan58A;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RoleDashboardsTest extends TestCase
{
    use RefreshDatabase;

    public function test_role_dashboard_main_pages_show_the_same_subtitle(): void
    {
        $roles = ['syarikat', 'admin', 'jkdm', 'ketua_unit_jkdm', 'pelulus'];

        foreach ($roles as $role) {
            $user = User::query()->create([
                'name' => ucfirst($role),
                'login_id' => $role.'-1',
                'role' => $role,
                'password' => Hash::make('password'),
            ]);

            $response = $this->actingAs($user)->get(match ($role) {
                'syarikat' => route('syarikat.utama'),
                'admin' => route('admin.utama'),
                'jkdm', 'ketua_unit_jkdm' => route('jkdm.utama'),
                'pelulus' => route('pelulus.utama'),
            });

            $response->assertOk();
            $response->assertSee('Sistem Maklumat Bunker Petroleum', false);
        }
    }

    public function test_admin_tambah_pengguna_shows_ketua_unit_jkdm_role_option(): void
    {
        $admin = User::query()->create([
            'name' => 'Admin',
            'login_id' => 'admin-1',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        $response = $this->actingAs($admin)->get(route('admin.tambahpengguna'));

        $response->assertOk();
        $response->assertSee('KETUA UNIT (JKDM)', false);
    }

    public function test_admin_tambah_pengguna_disables_company_name_until_syarikat_role_is_selected(): void
    {
        $admin = User::query()->create([
            'name' => 'Admin',
            'login_id' => 'admin-1',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        $response = $this->actingAs($admin)->get(route('admin.tambahpengguna'));

        $response->assertOk();
        $response->assertSee('x-bind:disabled="role !== \'syarikat\'"', false);
        $response->assertSee('x-bind:required="role === \'syarikat\'"', false);
    }

    public function test_admin_can_create_ketua_unit_jkdm_user(): void
    {
        $admin = User::query()->create([
            'name' => 'Admin',
            'login_id' => 'admin-1',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        $response = $this->actingAs($admin)->post(route('admin.pengguna.store'), [
            'name' => 'Ketua Unit',
            'login_id' => 'ketua-unit-1',
            'role' => 'ketua_unit_jkdm',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('admin.uruspengguna'));
        $this->assertDatabaseHas('users', [
            'login_id' => 'ketua-unit-1',
            'role' => 'ketua_unit_jkdm',
        ]);
    }

    public function test_admin_can_create_syarikat_user_with_optional_company_name(): void
    {
        $admin = User::query()->create([
            'name' => 'Admin',
            'login_id' => 'admin-1',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        $response = $this->actingAs($admin)->post(route('admin.pengguna.store'), [
            'name' => 'Syarikat User',
            'nama_syarikat' => 'ATIFA TOWAGE AND TRANSPORT SDN BHD',
            'login_id' => 'syarikat-1',
            'role' => 'syarikat',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('admin.uruspengguna'));
        $this->assertDatabaseHas('users', [
            'login_id' => 'syarikat-1',
            'role' => 'syarikat',
            'nama_syarikat' => 'ATIFA TOWAGE AND TRANSPORT SDN BHD',
        ]);
    }

    public function test_admin_must_provide_company_name_for_syarikat_user(): void
    {
        $admin = User::query()->create([
            'name' => 'Admin',
            'login_id' => 'admin-1',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        $response = $this->actingAs($admin)->post(route('admin.pengguna.store'), [
            'name' => 'Syarikat User',
            'nama_syarikat' => '',
            'login_id' => 'syarikat-1',
            'role' => 'syarikat',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors('nama_syarikat');
    }

    public function test_admin_users_list_shows_company_name_only_for_syarikat_users(): void
    {
        $admin = User::query()->create([
            'name' => 'Admin',
            'login_id' => 'admin-1',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        User::query()->create([
            'name' => 'Syarikat User',
            'nama_syarikat' => 'ATIFA TOWAGE AND TRANSPORT SDN BHD',
            'login_id' => 'syarikat-1',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        User::query()->create([
            'name' => 'Pegawai JKDM',
            'login_id' => 'jkdm-1',
            'role' => 'jkdm',
            'password' => Hash::make('password'),
        ]);

        $response = $this->actingAs($admin)->get(route('admin.uruspengguna'));

        $response->assertOk();
        $response->assertSee('Nama Syarikat', false);
        $response->assertSee('ATIFA TOWAGE AND TRANSPORT SDN BHD', false);
        $response->assertSeeInOrder([
            'Syarikat User',
            'ATIFA TOWAGE AND TRANSPORT SDN BHD',
            'syarikat-1',
        ], false);
        $response->assertSeeInOrder([
            'Pegawai JKDM',
            '-',
            'jkdm-1',
        ], false);
    }

    public function test_admin_dashboard_links_counts_to_related_pages(): void
    {
        $admin = User::query()->create([
            'name' => 'Admin',
            'login_id' => 'admin-1',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        Permohonan58A::query()->create([
            'user_id' => $admin->id,
            'nama' => 'Admin User',
            'no_telefon' => '0123456789',
            'email' => 'admin@example.com',
            'no_kp' => '900101-01-1234',
            'jawatan' => 'Pengurus',
            'nama_syarikat' => 'Syarikat Admin',
            'tarikh_permohonan' => '2026-07-29',
            'no_kelulusan' => 'JKDM-001',
            'no_pesanan_belian' => 'PO-001',
            'alamat' => 'Alamat Admin',
            'negeri' => 'Melaka',
            'tandatangan_nama' => 'Admin User',
            'tandatangan_no_kp' => '900101-01-1234',
            'tandatangan_jawatan' => 'Pengurus',
            'pembekal_nama' => 'Pembekal Sdn Bhd',
            'pembekal_alamat' => 'Alamat Pembekal',
            'barangs' => [],
            'attachments' => [],
            'status' => 'Dalam tindakan',
        ]);

        LaporanCjp::query()->create([
            'user_id' => $admin->id,
            'negeri' => 'Melaka',
            'nama_syarikat' => 'Syarikat Admin',
            'tahun' => 2026,
            'bulan' => 'Julai',
            'fail_path' => null,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.utama'));

        $response->assertOk();
        $response->assertSee(route('admin.senaraipermohonan'), false);
        $response->assertSee(route('admin.senarailaporan'), false);
        $response->assertSee('Jumlah Permohonan: 1', false);
        $response->assertSee('Jumlah Laporan CJ(P): 1', false);
    }

    public function test_user_normalized_role_keeps_ketua_unit_jkdm_separate_from_jkdm(): void
    {
        $jkdm = User::query()->create([
            'name' => 'JKDM',
            'login_id' => 'jkdm-1',
            'role' => 'jkdm',
            'password' => Hash::make('password'),
        ]);

        $ketuaUnit = User::query()->create([
            'name' => 'Ketua Unit',
            'login_id' => 'ketua-unit-1',
            'role' => 'ketua_unit_jkdm',
            'password' => Hash::make('password'),
        ]);

        $this->assertSame('jkdm', $jkdm->normalizedRole());
        $this->assertSame('ketua_unit_jkdm', $ketuaUnit->normalizedRole());
    }
}
