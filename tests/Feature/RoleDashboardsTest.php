<?php

namespace Tests\Feature;

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
        $response->assertSee('KETUA_UNIT(JKDM)', false);
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
