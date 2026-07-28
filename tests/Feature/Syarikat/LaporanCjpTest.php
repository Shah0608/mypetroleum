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
            'login_id' => 'tester-syarikat',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        $response = $this->actingAs($user)->get(route('syarikat.laporan-cj'));

        $response->assertOk();
        $response->assertSee('value="Test User"', false);
        $response->assertSee('name="nama_syarikat"', false);
        $response->assertSee('readonly', false);
    }
}
