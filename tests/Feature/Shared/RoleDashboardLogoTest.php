<?php

namespace Tests\Feature\Shared;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleDashboardLogoTest extends TestCase
{
    use RefreshDatabase;

    public function test_role_dashboard_layout_uses_double_logo_for_admin_and_syarikat_users(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'login_id' => 'admin-1',
            'password' => 'password',
        ]);

        $syarikat = User::factory()->create([
            'role' => 'syarikat',
            'login_id' => 'syarikat-1',
            'password' => 'password',
        ]);

        $adminResponse = $this->actingAs($admin)->get(route('admin.utama'));
        $adminResponse->assertOk();
        $adminResponse->assertSee('double_logo.png', false);
        $adminResponse->assertSee('h-32 w-auto shrink-0 object-contain', false);

        $syarikatResponse = $this->actingAs($syarikat)->get(route('syarikat.utama'));
        $syarikatResponse->assertOk();
        $syarikatResponse->assertSee('double_logo.png', false);
        $syarikatResponse->assertSee('h-32 w-auto shrink-0 object-contain', false);
    }
}
