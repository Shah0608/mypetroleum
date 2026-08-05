<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Log Masuk', false);
        $response->assertDontSee('data-theme-toggle', false);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create([
            'login_id' => 'auth-user-1',
            'role' => 'syarikat',
        ]);

        $response = $this->post('/login', [
            'login_id' => $user->login_id,
            'password' => 'password',
            'user_type' => 'syarikat',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('syarikat.utama', absolute: false));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create([
            'login_id' => 'auth-user-2',
            'role' => 'syarikat',
        ]);

        $this->post('/login', [
            'login_id' => $user->login_id,
            'password' => 'wrong-password',
            'user_type' => 'syarikat',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create([
            'login_id' => 'auth-user-3',
            'role' => 'syarikat',
        ]);

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
