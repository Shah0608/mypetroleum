<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_route_redirects_to_the_previous_or_dashboard_page(): void
    {
        $user = User::query()->create([
            'name' => 'Profile User',
            'login_id' => 'profile-user-1',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        $response = $this
            ->actingAs($user)
            ->get('/profile');

        $response->assertRedirect(route('dashboard'));
    }

    public function test_profile_information_can_be_updated_from_the_header_avatar_form(): void
    {
        Storage::fake('public');

        $user = User::query()->create([
            'name' => 'Profile User',
            'login_id' => 'profile-user-1',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'avatar' => UploadedFile::fake()->create('avatar.jpg', 100, 'image/jpeg'),
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertNotNull($user->avatar_path);
        Storage::disk('public')->assertExists($user->avatar_path);
    }

    public function test_dashboard_header_shows_the_avatar_upload_field(): void
    {
        $user = User::query()->create([
            'name' => 'Profile User',
            'login_id' => 'profile-user-1',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('syarikat.utama'));

        $response
            ->assertOk()
            ->assertSee('name="avatar"', false)
            ->assertSee('id="header-avatar-preview"', false)
            ->assertSee('onchange="', false);
    }

    public function test_user_can_delete_their_account(): void
    {
        $user = User::query()->create([
            'name' => 'Profile User',
            'login_id' => 'profile-user-1',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        $response = $this
            ->actingAs($user)
            ->delete('/profile', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $user = User::query()->create([
            'name' => 'Profile User',
            'login_id' => 'profile-user-1',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->delete('/profile', [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrorsIn('userDeletion', 'password')
            ->assertRedirect('/profile');

        $this->assertNotNull($user->fresh());
    }
}
