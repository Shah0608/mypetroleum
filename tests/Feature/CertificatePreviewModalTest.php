<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CertificatePreviewModalTest extends TestCase
{
    use RefreshDatabase;

    public function test_certificate_preview_modal_uses_a_flexible_layout(): void
    {
        $user = User::query()->create([
            'name' => 'Syarikat User',
            'login_id' => 'syarikat-1',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        $response = $this->actingAs($user)->get(route('syarikat.senaraipermohonan'));

        $response->assertOk();
        $response->assertSee('flex h-[calc(100vh-2rem)] w-full max-w-6xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl', false);
        $response->assertSee('min-h-0 flex-1 bg-slate-200', false);
        $response->assertSee('flex shrink-0 flex-wrap gap-3 border-t border-slate-200 px-5 py-4', false);
    }
}
