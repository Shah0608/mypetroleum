<?php

namespace Tests\Feature\Jkdm;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UtamaTest extends TestCase
{
    use RefreshDatabase;

    public function test_jkdm_dashboard_shows_kpdn_logo_link(): void
    {
        $user = User::query()->create([
            'name' => 'JKDM User',
            'login_id' => 'jkdm-1',
            'role' => 'jkdm',
            'password' => Hash::make('password'),
        ]);

        $response = $this->actingAs($user)->get(route('jkdm.utama'));

        $response->assertOk();
        $response->assertSee('https://www.kpdn.gov.my/ms/', false);
        $response->assertSee('images/kpdn.png', false);
    }
}
