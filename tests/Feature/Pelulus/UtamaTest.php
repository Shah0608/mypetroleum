<?php

namespace Tests\Feature\Pelulus;

use App\Models\Permohonan58A;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UtamaTest extends TestCase
{
    use RefreshDatabase;

    public function test_pelulus_dashboard_shows_counts_linked_to_related_pages(): void
    {
        $pelulus = User::query()->create([
            'name' => 'Pelulus',
            'login_id' => 'pelulus-1',
            'role' => 'pelulus',
            'password' => Hash::make('password'),
        ]);

        $user = User::query()->create([
            'name' => 'Pengguna Syarikat',
            'login_id' => 'syarikat-1',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        Permohonan58A::query()->create([
            'user_id' => $user->id,
            'nama' => 'Pengguna Syarikat',
            'no_telefon' => '0123456789',
            'email' => 'syarikat@example.com',
            'no_kp' => '900101-01-1234',
            'jawatan' => 'Pengurus',
            'nama_syarikat' => 'ATIFA TOWAGE AND TRANSPORT SDN BHD',
            'tarikh_permohonan' => '2026-07-21',
            'no_kelulusan' => 'JKDM-001',
            'no_pesanan_belian' => 'PO-001',
            'alamat' => 'Pelabuhan Miri',
            'negeri' => 'Melaka',
            'tandatangan_nama' => 'Pengguna Syarikat',
            'tandatangan_no_kp' => '900101-01-1234',
            'tandatangan_jawatan' => 'Pengurus',
            'pembekal_nama' => 'Pembekal Sdn Bhd',
            'pembekal_alamat' => 'Alamat Pembekal',
            'barangs' => [],
            'attachments' => [],
            'status' => 'Dalam tindakan',
        ]);

        $response = $this->actingAs($pelulus)->get(route('pelulus.utama'));

        $response->assertOk();
        $response->assertSee(route('pelulus.senarai-pengguna'), false);
        $response->assertSee(route('pelulus.senaraipermohonan'), false);
        $response->assertSee('Jumlah Syarikat: <span class="font-bold">1</span>', false);
        $response->assertSee('Jumlah Permohonan: <span class="font-bold">1</span>', false);
    }

    public function test_pelulus_dashboard_counts_unique_companies_from_senarai_syarikat_logic(): void
    {
        $pelulus = User::query()->create([
            'name' => 'Pelulus',
            'login_id' => 'pelulus-1',
            'role' => 'pelulus',
            'password' => Hash::make('password'),
        ]);

        $userOne = User::query()->create([
            'name' => 'Pengguna 1',
            'login_id' => 'syarikat-1',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        $userTwo = User::query()->create([
            'name' => 'Pengguna 2',
            'login_id' => 'syarikat-2',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        Permohonan58A::query()->create([
            'user_id' => $userOne->id,
            'nama' => 'Pengguna 1',
            'no_telefon' => '0123456789',
            'email' => 'user1@example.com',
            'no_kp' => '900101-01-1234',
            'jawatan' => 'Pengurus',
            'nama_syarikat' => 'Syarikat A Sdn Bhd',
            'tarikh_permohonan' => '2026-07-21',
            'no_kelulusan' => 'JKDM-001',
            'no_pesanan_belian' => 'PO-001',
            'alamat' => 'Alamat A',
            'negeri' => 'Melaka',
            'tandatangan_nama' => 'Pengguna 1',
            'tandatangan_no_kp' => '900101-01-1234',
            'tandatangan_jawatan' => 'Pengurus',
            'pembekal_nama' => 'Pembekal Sdn Bhd',
            'pembekal_alamat' => 'Alamat Pembekal',
            'barangs' => [],
            'attachments' => [],
            'status' => 'Dalam tindakan',
        ]);

        Permohonan58A::query()->create([
            'user_id' => $userTwo->id,
            'nama' => 'Pengguna 2',
            'no_telefon' => '0123456789',
            'email' => 'user2@example.com',
            'no_kp' => '900101-01-1234',
            'jawatan' => 'Pengurus',
            'nama_syarikat' => 'Syarikat B Sdn Bhd',
            'tarikh_permohonan' => '2026-07-22',
            'no_kelulusan' => 'JKDM-002',
            'no_pesanan_belian' => 'PO-002',
            'alamat' => 'Alamat B',
            'negeri' => 'Melaka',
            'tandatangan_nama' => 'Pengguna 2',
            'tandatangan_no_kp' => '900101-01-1234',
            'tandatangan_jawatan' => 'Pengurus',
            'pembekal_nama' => 'Pembekal Sdn Bhd',
            'pembekal_alamat' => 'Alamat Pembekal',
            'barangs' => [],
            'attachments' => [],
            'status' => 'Dalam tindakan',
        ]);

        $response = $this->actingAs($pelulus)->get(route('pelulus.utama'));

        $response->assertOk();
        $response->assertSee('Jumlah Syarikat: <span class="font-bold">2</span>', false);
    }

    public function test_pelulus_can_view_approved_status_page_only_shows_diluluskan_applications(): void
    {
        $pelulus = User::query()->create([
            'name' => 'Pelulus',
            'login_id' => 'pelulus-1',
            'role' => 'pelulus',
            'password' => Hash::make('password'),
        ]);

        $user = User::query()->create([
            'name' => 'Pengguna Syarikat',
            'login_id' => 'syarikat-1',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        Permohonan58A::query()->create([
            'user_id' => $user->id,
            'nama' => 'Pengguna Syarikat',
            'no_telefon' => '0123456789',
            'email' => 'syarikat@example.com',
            'no_kp' => '900101-01-1234',
            'jawatan' => 'Pengurus',
            'nama_syarikat' => 'Syarikat Lulus Sdn Bhd',
            'tarikh_permohonan' => '2026-07-21',
            'no_kelulusan' => 'JKDM-001',
            'no_pesanan_belian' => 'PO-001',
            'alamat' => 'Alamat Lulus',
            'negeri' => 'Melaka',
            'tandatangan_nama' => 'Pengguna Syarikat',
            'tandatangan_no_kp' => '900101-01-1234',
            'tandatangan_jawatan' => 'Pengurus',
            'pembekal_nama' => 'Pembekal Sdn Bhd',
            'pembekal_alamat' => 'Alamat Pembekal',
            'barangs' => [],
            'attachments' => [],
            'status' => 'Diluluskan',
        ]);

        Permohonan58A::query()->create([
            'user_id' => $user->id,
            'nama' => 'Pengguna Syarikat',
            'no_telefon' => '0123456789',
            'email' => 'syarikat@example.com',
            'no_kp' => '900101-01-1234',
            'jawatan' => 'Pengurus',
            'nama_syarikat' => 'Syarikat Tindakan Sdn Bhd',
            'tarikh_permohonan' => '2026-07-22',
            'no_kelulusan' => 'JKDM-002',
            'no_pesanan_belian' => 'PO-002',
            'alamat' => 'Alamat Tindakan',
            'negeri' => 'Melaka',
            'tandatangan_nama' => 'Pengguna Syarikat',
            'tandatangan_no_kp' => '900101-01-1234',
            'tandatangan_jawatan' => 'Pengurus',
            'pembekal_nama' => 'Pembekal Sdn Bhd',
            'pembekal_alamat' => 'Alamat Pembekal',
            'barangs' => [],
            'attachments' => [],
            'status' => 'Dalam tindakan',
        ]);

        $response = $this->actingAs($pelulus)->get(route('pelulus.status-permohonan'));

        $response->assertOk();
        $response->assertSee('Syarikat Lulus Sdn Bhd', false);
        $response->assertDontSee('Syarikat Tindakan Sdn Bhd', false);
    }

    public function test_pelulus_pending_status_page_only_shows_in_progress_applications(): void
    {
        $pelulus = User::query()->create([
            'name' => 'Pelulus',
            'login_id' => 'pelulus-1',
            'role' => 'pelulus',
            'password' => Hash::make('password'),
        ]);

        $user = User::query()->create([
            'name' => 'Pengguna Syarikat',
            'login_id' => 'syarikat-1',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        Permohonan58A::query()->create([
            'user_id' => $user->id,
            'nama' => 'Pengguna Syarikat',
            'no_telefon' => '0123456789',
            'email' => 'syarikat@example.com',
            'no_kp' => '900101-01-1234',
            'jawatan' => 'Pengurus',
            'nama_syarikat' => 'Syarikat Pending Sdn Bhd',
            'tarikh_permohonan' => '2026-07-22',
            'no_kelulusan' => 'JKDM-002',
            'no_pesanan_belian' => 'PO-002',
            'alamat' => 'Alamat Pending',
            'negeri' => 'Melaka',
            'tandatangan_nama' => 'Pengguna Syarikat',
            'tandatangan_no_kp' => '900101-01-1234',
            'tandatangan_jawatan' => 'Pengurus',
            'pembekal_nama' => 'Pembekal Sdn Bhd',
            'pembekal_alamat' => 'Alamat Pembekal',
            'barangs' => [],
            'attachments' => [],
            'status' => 'Dalam tindakan',
        ]);

        Permohonan58A::query()->create([
            'user_id' => $user->id,
            'nama' => 'Pengguna Syarikat',
            'no_telefon' => '0123456789',
            'email' => 'syarikat@example.com',
            'no_kp' => '900101-01-1234',
            'jawatan' => 'Pengurus',
            'nama_syarikat' => 'Syarikat Gagal Sdn Bhd',
            'tarikh_permohonan' => '2026-07-23',
            'no_kelulusan' => 'JKDM-003',
            'no_pesanan_belian' => 'PO-003',
            'alamat' => 'Alamat Gagal',
            'negeri' => 'Melaka',
            'tandatangan_nama' => 'Pengguna Syarikat',
            'tandatangan_no_kp' => '900101-01-1234',
            'tandatangan_jawatan' => 'Pengurus',
            'pembekal_nama' => 'Pembekal Sdn Bhd',
            'pembekal_alamat' => 'Alamat Pembekal',
            'barangs' => [],
            'attachments' => [],
            'status' => 'Tidak diluluskan',
        ]);

        $response = $this->actingAs($pelulus)->get(route('pelulus.status-permohonan.pending'));

        $response->assertOk();
        $response->assertSee('Syarikat Pending Sdn Bhd', false);
        $response->assertDontSee('Syarikat Gagal Sdn Bhd', false);
    }

    public function test_pelulus_failed_status_page_only_shows_failed_applications(): void
    {
        $pelulus = User::query()->create([
            'name' => 'Pelulus',
            'login_id' => 'pelulus-1',
            'role' => 'pelulus',
            'password' => Hash::make('password'),
        ]);

        $user = User::query()->create([
            'name' => 'Pengguna Syarikat',
            'login_id' => 'syarikat-1',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        Permohonan58A::query()->create([
            'user_id' => $user->id,
            'nama' => 'Pengguna Syarikat',
            'no_telefon' => '0123456789',
            'email' => 'syarikat@example.com',
            'no_kp' => '900101-01-1234',
            'jawatan' => 'Pengurus',
            'nama_syarikat' => 'Syarikat Pending Sdn Bhd',
            'tarikh_permohonan' => '2026-07-22',
            'no_kelulusan' => 'JKDM-002',
            'no_pesanan_belian' => 'PO-002',
            'alamat' => 'Alamat Pending',
            'negeri' => 'Melaka',
            'tandatangan_nama' => 'Pengguna Syarikat',
            'tandatangan_no_kp' => '900101-01-1234',
            'tandatangan_jawatan' => 'Pengurus',
            'pembekal_nama' => 'Pembekal Sdn Bhd',
            'pembekal_alamat' => 'Alamat Pembekal',
            'barangs' => [],
            'attachments' => [],
            'status' => 'Dalam tindakan',
        ]);

        Permohonan58A::query()->create([
            'user_id' => $user->id,
            'nama' => 'Pengguna Syarikat',
            'no_telefon' => '0123456789',
            'email' => 'syarikat@example.com',
            'no_kp' => '900101-01-1234',
            'jawatan' => 'Pengurus',
            'nama_syarikat' => 'Syarikat Gagal Sdn Bhd',
            'tarikh_permohonan' => '2026-07-23',
            'no_kelulusan' => 'JKDM-003',
            'no_pesanan_belian' => 'PO-003',
            'alamat' => 'Alamat Gagal',
            'negeri' => 'Melaka',
            'tandatangan_nama' => 'Pengguna Syarikat',
            'tandatangan_no_kp' => '900101-01-1234',
            'tandatangan_jawatan' => 'Pengurus',
            'pembekal_nama' => 'Pembekal Sdn Bhd',
            'pembekal_alamat' => 'Alamat Pembekal',
            'barangs' => [],
            'attachments' => [],
            'status' => 'Tidak diluluskan',
        ]);

        $response = $this->actingAs($pelulus)->get(route('pelulus.status-permohonan.failed'));

        $response->assertOk();
        $response->assertSee('Syarikat Gagal Sdn Bhd', false);
        $response->assertDontSee('Syarikat Pending Sdn Bhd', false);
    }

    public function test_pelulus_dashboard_shows_separate_status_button_next_to_permohonan_button(): void
    {
        $pelulus = User::query()->create([
            'name' => 'Pelulus',
            'login_id' => 'pelulus-1',
            'role' => 'pelulus',
            'password' => Hash::make('password'),
        ]);

        $response = $this->actingAs($pelulus)->get(route('pelulus.utama'));

        $response->assertOk();
        $response->assertSee('SENARAI PERMOHONAN', false);
        $response->assertSee('STATUS', false);
    }

    public function test_pelulus_senarai_permohonan_can_filter_by_status(): void
    {
        $pelulus = User::query()->create([
            'name' => 'Pelulus',
            'login_id' => 'pelulus-1',
            'role' => 'pelulus',
            'password' => Hash::make('password'),
        ]);

        $user = User::query()->create([
            'name' => 'Pengguna Syarikat',
            'login_id' => 'syarikat-1',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        Permohonan58A::query()->create([
            'user_id' => $user->id,
            'nama' => 'Pengguna Syarikat',
            'no_telefon' => '0123456789',
            'email' => 'syarikat@example.com',
            'no_kp' => '900101-01-1234',
            'jawatan' => 'Pengurus',
            'nama_syarikat' => 'Syarikat Lulus Sdn Bhd',
            'tarikh_permohonan' => '2026-07-21',
            'no_kelulusan' => 'JKDM-001',
            'no_pesanan_belian' => 'PO-001',
            'alamat' => 'Alamat Lulus',
            'negeri' => 'Melaka',
            'tandatangan_nama' => 'Pengguna Syarikat',
            'tandatangan_no_kp' => '900101-01-1234',
            'tandatangan_jawatan' => 'Pengurus',
            'pembekal_nama' => 'Pembekal Sdn Bhd',
            'pembekal_alamat' => 'Alamat Pembekal',
            'barangs' => [],
            'attachments' => [],
            'status' => 'Diluluskan',
        ]);

        Permohonan58A::query()->create([
            'user_id' => $user->id,
            'nama' => 'Pengguna Syarikat',
            'no_telefon' => '0123456789',
            'email' => 'syarikat@example.com',
            'no_kp' => '900101-01-1234',
            'jawatan' => 'Pengurus',
            'nama_syarikat' => 'Syarikat Tindakan Sdn Bhd',
            'tarikh_permohonan' => '2026-07-22',
            'no_kelulusan' => 'JKDM-002',
            'no_pesanan_belian' => 'PO-002',
            'alamat' => 'Alamat Tindakan',
            'negeri' => 'Melaka',
            'tandatangan_nama' => 'Pengguna Syarikat',
            'tandatangan_no_kp' => '900101-01-1234',
            'tandatangan_jawatan' => 'Pengurus',
            'pembekal_nama' => 'Pembekal Sdn Bhd',
            'pembekal_alamat' => 'Alamat Pembekal',
            'barangs' => [],
            'attachments' => [],
            'status' => 'Dalam tindakan',
        ]);

        $response = $this->actingAs($pelulus)->get(route('pelulus.senaraipermohonan', ['status' => 'diluluskan']));

        $response->assertOk();
        $response->assertSee('Syarikat Lulus Sdn Bhd', false);
        $response->assertDontSee('Syarikat Tindakan Sdn Bhd', false);
        $response->assertSee('value="diluluskan" selected', false);
    }

    public function test_pelulus_can_export_filtered_senarai_permohonan_to_excel_compatible_file(): void
    {
        $pelulus = User::query()->create([
            'name' => 'Pelulus',
            'login_id' => 'pelulus-1',
            'role' => 'pelulus',
            'password' => Hash::make('password'),
        ]);

        $user = User::query()->create([
            'name' => 'Pengguna Syarikat',
            'login_id' => 'syarikat-1',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        Permohonan58A::query()->create([
            'user_id' => $user->id,
            'nama' => 'Pengguna Syarikat',
            'no_telefon' => '0123456789',
            'email' => 'syarikat@example.com',
            'no_kp' => '900101-01-1234',
            'jawatan' => 'Pengurus',
            'nama_syarikat' => 'Syarikat Lulus Sdn Bhd',
            'tarikh_permohonan' => '2026-07-21',
            'no_kelulusan' => 'JKDM-001',
            'no_pesanan_belian' => 'PO-001',
            'alamat' => 'Alamat Lulus',
            'negeri' => 'Melaka',
            'tandatangan_nama' => 'Pengguna Syarikat',
            'tandatangan_no_kp' => '900101-01-1234',
            'tandatangan_jawatan' => 'Pengurus',
            'pembekal_nama' => 'Pembekal Sdn Bhd',
            'pembekal_alamat' => 'Alamat Pembekal',
            'barangs' => [
                [
                    'perihal' => 'Minyak',
                    'unit' => 'LITER',
                    'kuantiti' => '1000',
                    'kawasan' => 'Port Klang',
                ],
            ],
            'attachments' => [],
            'status' => 'Diluluskan',
            'tarikh_diluluskan' => '2026-07-22',
            'tarikh_tamat' => '2028-07-22',
            'no_sijil_pengecualian' => 'M10-58A-2607-0001',
        ]);

        Permohonan58A::query()->create([
            'user_id' => $user->id,
            'nama' => 'Pengguna Syarikat',
            'no_telefon' => '0123456789',
            'email' => 'syarikat@example.com',
            'no_kp' => '900101-01-1234',
            'jawatan' => 'Pengurus',
            'nama_syarikat' => 'Syarikat Tindakan Sdn Bhd',
            'tarikh_permohonan' => '2026-07-23',
            'no_kelulusan' => 'JKDM-002',
            'no_pesanan_belian' => 'PO-002',
            'alamat' => 'Alamat Tindakan',
            'negeri' => 'Melaka',
            'tandatangan_nama' => 'Pengguna Syarikat',
            'tandatangan_no_kp' => '900101-01-1234',
            'tandatangan_jawatan' => 'Pengurus',
            'pembekal_nama' => 'Pembekal Sdn Bhd',
            'pembekal_alamat' => 'Alamat Pembekal',
            'barangs' => [],
            'attachments' => [],
            'status' => 'Dalam tindakan',
        ]);

        $response = $this->actingAs($pelulus)->get(route('pelulus.senaraipermohonan.export', ['status' => 'diluluskan']));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/vnd.ms-excel; charset=UTF-8');
        $response->assertHeader('content-disposition');
        $response->assertSee('Syarikat Lulus Sdn Bhd', false);
        $response->assertDontSee('Syarikat Tindakan Sdn Bhd', false);
        $response->assertSee('Status: Diluluskan', false);
    }

    public function test_pelulus_print_page_sorts_all_records_by_status_and_excludes_actions_columns(): void
    {
        $pelulus = User::query()->create([
            'name' => 'Pelulus',
            'login_id' => 'pelulus-1',
            'role' => 'pelulus',
            'password' => Hash::make('password'),
        ]);

        $user = User::query()->create([
            'name' => 'Pengguna Syarikat',
            'login_id' => 'syarikat-1',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        $approved = Permohonan58A::query()->create([
            'user_id' => $user->id,
            'nama' => 'Pengguna Syarikat',
            'no_telefon' => '0123456789',
            'email' => 'syarikat@example.com',
            'no_kp' => '900101-01-1234',
            'jawatan' => 'Pengurus',
            'nama_syarikat' => 'Syarikat Lulus Sdn Bhd',
            'tarikh_permohonan' => '2026-07-21',
            'no_kelulusan' => 'JKDM-001',
            'no_pesanan_belian' => 'PO-001',
            'alamat' => 'Alamat Lulus',
            'negeri' => 'Melaka',
            'tandatangan_nama' => 'Pengguna Syarikat',
            'tandatangan_no_kp' => '900101-01-1234',
            'tandatangan_jawatan' => 'Pengurus',
            'pembekal_nama' => 'Pembekal Sdn Bhd',
            'pembekal_alamat' => 'Alamat Pembekal',
            'barangs' => [],
            'attachments' => [],
            'status' => 'Diluluskan',
        ]);

        $pending = Permohonan58A::query()->create([
            'user_id' => $user->id,
            'nama' => 'Pengguna Syarikat',
            'no_telefon' => '0123456789',
            'email' => 'syarikat@example.com',
            'no_kp' => '900101-01-1234',
            'jawatan' => 'Pengurus',
            'nama_syarikat' => 'Syarikat Tindakan Sdn Bhd',
            'tarikh_permohonan' => '2026-07-22',
            'no_kelulusan' => 'JKDM-002',
            'no_pesanan_belian' => 'PO-002',
            'alamat' => 'Alamat Tindakan',
            'negeri' => 'Melaka',
            'tandatangan_nama' => 'Pengguna Syarikat',
            'tandatangan_no_kp' => '900101-01-1234',
            'tandatangan_jawatan' => 'Pengurus',
            'pembekal_nama' => 'Pembekal Sdn Bhd',
            'pembekal_alamat' => 'Alamat Pembekal',
            'barangs' => [],
            'attachments' => [],
            'status' => 'Dalam tindakan',
        ]);

        $failed = Permohonan58A::query()->create([
            'user_id' => $user->id,
            'nama' => 'Pengguna Syarikat',
            'no_telefon' => '0123456789',
            'email' => 'syarikat@example.com',
            'no_kp' => '900101-01-1234',
            'jawatan' => 'Pengurus',
            'nama_syarikat' => 'Syarikat Gagal Sdn Bhd',
            'tarikh_permohonan' => '2026-07-23',
            'no_kelulusan' => 'JKDM-003',
            'no_pesanan_belian' => 'PO-003',
            'alamat' => 'Alamat Gagal',
            'negeri' => 'Melaka',
            'tandatangan_nama' => 'Pengguna Syarikat',
            'tandatangan_no_kp' => '900101-01-1234',
            'tandatangan_jawatan' => 'Pengurus',
            'pembekal_nama' => 'Pembekal Sdn Bhd',
            'pembekal_alamat' => 'Alamat Pembekal',
            'barangs' => [],
            'attachments' => [],
            'status' => 'Tidak diluluskan',
        ]);

        $response = $this->actingAs($pelulus)->get(route('pelulus.senaraipermohonan.print', ['status' => 'semua']));

        $response->assertOk();
        $response->assertSeeInOrder([
            $approved->nama_syarikat,
            $pending->nama_syarikat,
            $failed->nama_syarikat,
        ], false);
        $response->assertSee('Tarikh Tamat', false);
        $response->assertDontSee('Jana Sijil Pengecualian', false);
        $response->assertDontSee('semak', false);
    }
}
