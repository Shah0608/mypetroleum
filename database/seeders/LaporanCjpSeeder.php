<?php

namespace Database\Seeders;

use App\Models\LaporanCjp;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LaporanCjpSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $syarikatUser = User::query()
            ->where('role', 'syarikat')
            ->orderBy('id')
            ->first();

        if (! $syarikatUser) {
            return;
        }

        $states = [
            'Johor',
            'Kedah',
            'Kelantan',
            'Melaka',
            'Negeri Sembilan',
            'Pahang',
            'Penang',
            'Perak',
            'Perlis',
            'Selangor',
            'Terengganu',
            'Sabah',
            'Sarawak',
            'WP Kuala Lumpur',
            'WP Labuan',
            'WP Putrajaya',
        ];

        $months = [
            'Januari',
            'Februari',
            'Mac',
            'April',
            'Mei',
            'Jun',
            'Julai',
            'Ogos',
            'September',
            'Oktober',
            'November',
            'Disember',
        ];

        for ($index = 1; $index <= 20; $index++) {
            LaporanCjp::query()->updateOrCreate(
                [
                    'user_id' => $syarikatUser->id,
                    'tahun' => 2026,
                    'bulan' => $months[($index - 1) % count($months)],
                    'nama_syarikat' => "Syarikat Petroleum {$index} Sdn. Bhd.",
                ],
                [
                    'user_id' => $syarikatUser->id,
                    'negeri' => $states[($index - 1) % count($states)],
                    'nama_syarikat' => "Syarikat Petroleum {$index} Sdn. Bhd.",
                    'tahun' => 2026,
                    'bulan' => $months[($index - 1) % count($months)],
                    'fail_path' => $index % 4 === 0
                        ? "laporan-cjp/syarikat-petroleum-{$index}.pdf"
                        : null,
                ]
            );
        }
    }
}
