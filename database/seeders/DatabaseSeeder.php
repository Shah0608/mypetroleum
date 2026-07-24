<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Syarikat Test ABC',
                'login_id' => '731215055544',
                'role' => 'syarikat',
            ],
            [
                'name' => 'Pegawai JKDM',
                'login_id' => '731215055544',
                'role' => 'jkdm',
            ],
            [
                'name' => 'Admin Sistem',
                'login_id' => '731215055544',
                'role' => 'admin',
            ],
            [
                'name' => 'Pelulus',
                'login_id' => '731215055544',
                'role' => 'pelulus',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['login_id' => $user['login_id'], 'role' => $user['role']],
                $user + ['password' => 'kastam']
            );
        }

        $this->call([
            Permohonan58ASeeder::class,
            LaporanCjpSeeder::class,
        ]);
    }
}
