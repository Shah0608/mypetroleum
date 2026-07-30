<?php

namespace Tests\Feature\Pelulus;

use App\Models\Permohonan58A;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SenaraiPenggunaTest extends TestCase
{
    use RefreshDatabase;

    public function test_pelulus_can_view_senarai_pengguna_from_permohonan_records(): void
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

        $response = $this->actingAs($pelulus)->get(route('pelulus.senarai-pengguna'));

        $response->assertOk();
        $response->assertSee('ATIFA TOWAGE AND TRANSPORT SDN BHD', false);
        $response->assertSee('Pelabuhan Miri', false);
        $response->assertSee('<th class="px-4 py-3">Bil.Permohonan</th>', false);
        $response->assertSee('<td class="px-4 py-3 text-center font-semibold text-slate-900">1</td>', false);
    }

    public function test_pelulus_can_see_bilangan_permohonan_when_same_company_submits_multiple_applications(): void
    {
        $pelulus = User::query()->create([
            'name' => 'Pelulus',
            'login_id' => 'pelulus-1',
            'role' => 'pelulus',
            'password' => Hash::make('password'),
        ]);

        $userOne = User::query()->create([
            'name' => 'Pengguna Syarikat 1',
            'login_id' => 'syarikat-1',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        $userTwo = User::query()->create([
            'name' => 'Pengguna Syarikat 2',
            'login_id' => 'syarikat-2',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        foreach ([$userOne, $userTwo] as $index => $user) {
            Permohonan58A::query()->create([
                'user_id' => $user->id,
                'nama' => 'Pengguna Syarikat '.($index + 1),
                'no_telefon' => '0123456789',
                'email' => 'syarikat'.($index + 1).'@example.com',
                'no_kp' => '900101-01-1234',
                'jawatan' => 'Pengurus',
                'nama_syarikat' => 'ATIFA TOWAGE AND TRANSPORT SDN BHD',
                'tarikh_permohonan' => '2026-07-21',
                'no_kelulusan' => 'JKDM-001',
                'no_pesanan_belian' => 'PO-00'.($index + 1),
                'alamat' => 'Pelabuhan Miri',
                'negeri' => 'Melaka',
                'tandatangan_nama' => 'Pengguna Syarikat '.($index + 1),
                'tandatangan_no_kp' => '900101-01-1234',
                'tandatangan_jawatan' => 'Pengurus',
                'pembekal_nama' => 'Pembekal Sdn Bhd',
                'pembekal_alamat' => 'Alamat Pembekal',
                'barangs' => [],
                'attachments' => [],
                'status' => 'Dalam tindakan',
            ]);
        }

        $response = $this->actingAs($pelulus)->get(route('pelulus.senarai-pengguna'));

        $response->assertOk();
        $response->assertSee('<td class="px-4 py-3 text-center font-semibold text-slate-900">2</td>', false);
    }

    public function test_pelulus_lists_newer_companies_below_older_companies(): void
    {
        $pelulus = User::query()->create([
            'name' => 'Pelulus',
            'login_id' => 'pelulus-1',
            'role' => 'pelulus',
            'password' => Hash::make('password'),
        ]);

        $oldCompanyUser = User::query()->create([
            'name' => 'Syarikat Lama',
            'login_id' => 'syarikat-lama',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        $newCompanyUser = User::query()->create([
            'name' => 'Syarikat Baru',
            'login_id' => 'syarikat-baru',
            'role' => 'syarikat',
            'password' => Hash::make('password'),
        ]);

        Permohonan58A::query()->create([
            'user_id' => $oldCompanyUser->id,
            'nama' => 'Syarikat Lama',
            'no_telefon' => '0123456789',
            'email' => 'lama@example.com',
            'no_kp' => '900101-01-1234',
            'jawatan' => 'Pengurus',
            'nama_syarikat' => 'Syarikat Lama Sdn Bhd',
            'tarikh_permohonan' => '2026-07-20',
            'no_kelulusan' => 'JKDM-001',
            'no_pesanan_belian' => 'PO-001',
            'alamat' => 'Alamat Lama',
            'negeri' => 'Melaka',
            'tandatangan_nama' => 'Syarikat Lama',
            'tandatangan_no_kp' => '900101-01-1234',
            'tandatangan_jawatan' => 'Pengurus',
            'pembekal_nama' => 'Pembekal Sdn Bhd',
            'pembekal_alamat' => 'Alamat Pembekal',
            'barangs' => [],
            'attachments' => [],
            'status' => 'Dalam tindakan',
            'created_at' => '2026-07-20 10:00:00',
            'updated_at' => '2026-07-20 10:00:00',
        ]);

        Permohonan58A::query()->create([
            'user_id' => $newCompanyUser->id,
            'nama' => 'Syarikat Baru',
            'no_telefon' => '0123456789',
            'email' => 'baru@example.com',
            'no_kp' => '900101-01-1234',
            'jawatan' => 'Pengurus',
            'nama_syarikat' => 'Syarikat Baru Sdn Bhd',
            'tarikh_permohonan' => '2026-07-21',
            'no_kelulusan' => 'JKDM-002',
            'no_pesanan_belian' => 'PO-002',
            'alamat' => 'Alamat Baru',
            'negeri' => 'Melaka',
            'tandatangan_nama' => 'Syarikat Baru',
            'tandatangan_no_kp' => '900101-01-1234',
            'tandatangan_jawatan' => 'Pengurus',
            'pembekal_nama' => 'Pembekal Sdn Bhd',
            'pembekal_alamat' => 'Alamat Pembekal',
            'barangs' => [],
            'attachments' => [],
            'status' => 'Dalam tindakan',
            'created_at' => '2026-07-21 10:00:00',
            'updated_at' => '2026-07-21 10:00:00',
        ]);

        $response = $this->actingAs($pelulus)->get(route('pelulus.senarai-pengguna'));

        $response->assertOk();
        $response->assertSeeInOrder([
            'Syarikat Lama Sdn Bhd',
            'Alamat Lama',
            '<td class="px-4 py-3 text-center font-semibold text-slate-900">1</td>',
            'Syarikat Baru Sdn Bhd',
            'Alamat Baru',
            '<td class="px-4 py-3 text-center font-semibold text-slate-900">1</td>',
        ], false);
    }

    public function test_pelulus_groups_multiple_applications_for_same_company_into_one_row(): void
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
            'tarikh_permohonan' => '2026-07-20',
            'no_kelulusan' => 'JKDM-001',
            'no_pesanan_belian' => 'PO-001',
            'alamat' => 'Alamat Pertama',
            'negeri' => 'Melaka',
            'tandatangan_nama' => 'Pengguna Syarikat',
            'tandatangan_no_kp' => '900101-01-1234',
            'tandatangan_jawatan' => 'Pengurus',
            'pembekal_nama' => 'Pembekal Sdn Bhd',
            'pembekal_alamat' => 'Alamat Pembekal',
            'barangs' => [],
            'attachments' => [],
            'status' => 'Dalam tindakan',
            'created_at' => '2026-07-20 10:00:00',
            'updated_at' => '2026-07-20 10:00:00',
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
            'no_kelulusan' => 'JKDM-002',
            'no_pesanan_belian' => 'PO-002',
            'alamat' => 'Alamat Kedua',
            'negeri' => 'Melaka',
            'tandatangan_nama' => 'Pengguna Syarikat',
            'tandatangan_no_kp' => '900101-01-1234',
            'tandatangan_jawatan' => 'Pengurus',
            'pembekal_nama' => 'Pembekal Sdn Bhd',
            'pembekal_alamat' => 'Alamat Pembekal',
            'barangs' => [],
            'attachments' => [],
            'status' => 'Dalam tindakan',
            'created_at' => '2026-07-21 10:00:00',
            'updated_at' => '2026-07-21 10:00:00',
        ]);

        $response = $this->actingAs($pelulus)->get(route('pelulus.senarai-pengguna'));

        $response->assertOk();
        $response->assertSee('Alamat Pertama', false);
        $response->assertSee('Bil.Permohonan', false);
        $response->assertSee('<td class="px-4 py-3 text-center font-semibold text-slate-900">2</td>', false);
        $response->assertDontSee('Alamat Kedua', false);
    }

    public function test_pelulus_review_page_shows_kod_stesen_dropdown_options(): void
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

        $permohonan = Permohonan58A::query()->create([
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

        $response = $this->actingAs($pelulus)->get(route('pelulus.permohonan.semak', $permohonan));

        $response->assertOk();
        $response->assertSee('Sila pilih kod stesen', false);
        $response->assertSee('M10', false);
        $response->assertSee('M11', false);
    }

    public function test_pelulus_review_page_shows_verification_and_unit_review_sections(): void
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

        $permohonan = Permohonan58A::query()->create([
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
            'ulasan_pegawai_verifikasi' => 'Disemak dan disokong.',
            'nama_pegawai_verifikasi' => 'Pegawai Verifikasi',
            'tarikh_ulasan_verifikasi' => '2026-07-20',
            'tarikh_tamat_pda2_verifikasi' => '2028-07-20',
            'ulasan_ketua_unit' => 'Disahkan oleh ketua unit.',
            'nama_pegawai_ketua_unit' => 'Ketua Unit',
            'tarikh_ulasan_ketua_unit' => '2026-07-21',
            'tarikh_tamat_pda2_ketua_unit' => '2028-07-21',
        ]);

        $response = $this->actingAs($pelulus)->get(route('pelulus.permohonan.semak', $permohonan));

        $response->assertOk();
        $response->assertSee('Ulasan Pegawai Verifikasi', false);
        $response->assertSee('Ulasan Ketua Unit/Cawangan', false);
        $response->assertSee('Pegawai Verifikasi', false);
        $response->assertSee('Ketua Unit', false);
        $response->assertSee('20/07/2028', false);
        $response->assertDontSee('21/07/2028', false);
        $response->assertSee('Tarikh Tamat PDA 2', false);
        $response->assertDontSee('textarea name="ulasan_ketua_unit"', false);
        $response->assertDontSee('name="nama_pegawai_ketua_unit"', false);
        $response->assertDontSee('name="tarikh_ulasan_ketua_unit"', false);
        $response->assertDontSee('name="tarikh_tamat_pda2_ketua_unit"', false);
    }

    public function test_pelulus_application_list_shows_verification_pda2_end_date(): void
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
            'tarikh_tamat_pda2_verifikasi' => '2028-07-20',
        ]);

        $response = $this->actingAs($pelulus)->get(route('pelulus.senaraipermohonan'));

        $response->assertOk();
        $response->assertSee('20/07/2028', false);
    }
}
