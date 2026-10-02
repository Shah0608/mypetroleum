<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileAvatarUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_upload_avatar_without_name_field(): void
    {
        Storage::fake('public');

        $user = User::create([
            'name' => 'Test User',
            'login_id' => 'test-user-'.uniqid(),
            'role' => 'syarikat',
            'password' => 'password',
        ]);

        $response = $this->actingAs($user)->patch('/profile', [
            'avatar' => UploadedFile::fake()->image('avatar.jpg', 200, 200),
        ]);

        $response->assertRedirect();

        $user->refresh();

        $this->assertNotNull($user->avatar_path);
        $this->assertStringStartsWith('avatars/', $user->avatar_path);
        $this->assertTrue(Storage::disk('public')->exists($user->avatar_path));
    }
}
