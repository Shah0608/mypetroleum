<?php

namespace Database\Seeders;

use App\Models\Permohonan58A;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class Permohonan58ASeeder extends Seeder
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

        $statuses = [
            'Dalam tindakan',
            'Diluluskan',
            'Tidak diluluskan',
        ];

        for ($index = 1; $index <= 20; $index++) {
            $status = $statuses[$index % 3];
            $applicationDate = Carbon::now()->subDays($index * 2);

            $payload = [
                'user_id' => $syarikatUser->id,
                'nama' => "Pemohon {$index}",
                'no_telefon' => '013-555'.str_pad((string) $index, 4, '0', STR_PAD_LEFT),
                'email' => "pemohon{$index}@example.com",
                'no_kp' => '900101-14-'.str_pad((string) $index, 4, '0', STR_PAD_LEFT),
                'jawatan' => $index % 2 === 0 ? 'Pengurus Operasi' : 'Eksekutif Pentadbiran',
                'nama_syarikat' => "Syarikat Petroleum {$index} Sdn. Bhd.",
                'no_pendaftaran_cukai' => 'CUKAI-'.str_pad((string) $index, 6, '0', STR_PAD_LEFT),
                'tarikh_permohonan' => $applicationDate->toDateString(),
                'no_kelulusan' => 'JKDM/58A/'.now()->year.'/'.str_pad((string) $index, 4, '0', STR_PAD_LEFT),
                'no_pesanan_belian' => 'PO-58A-'.str_pad((string) $index, 5, '0', STR_PAD_LEFT),
                'alamat' => "No. {$index}, Jalan Industri 58A, 43000 Kajang, Selangor",
                'negeri' => $states[($index - 1) % count($states)],
                'tandatangan_nama' => "Penandatangan {$index}",
                'tandatangan_no_kp' => '800202-08-'.str_pad((string) $index, 4, '0', STR_PAD_LEFT),
                'tandatangan_jawatan' => 'Pengarah Urusan',
                'pembekal_nama' => "Pembekal {$index} Logistics Sdn. Bhd.",
                'pembekal_alamat' => "Lot {$index}, Kawasan Perindustrian Maju, 43000 Kajang, Selangor",
                'barangs' => [
                    [
                        'perihal' => 'Diesel Marine',
                        'unit' => 'Liter',
                        'deskripsi' => 'Bahan bakar untuk operasi industri.',
                        'kuantiti' => 1000 + ($index * 25),
                        'nilai' => 5000 + ($index * 120),
                        'kawasan' => 'Semenanjung',
                    ],
                    [
                        'perihal' => 'Petrol Ron95',
                        'unit' => 'Liter',
                        'deskripsi' => 'Bahan bakar sokongan untuk ujian.',
                        'kuantiti' => 500 + ($index * 10),
                        'nilai' => 2500 + ($index * 80),
                        'kawasan' => 'Sabah dan Sarawak',
                    ],
                ],
                'attachments' => null,
                'status' => $status,
                'no_sijil_pengecualian' => $status === 'Diluluskan'
                    ? 'SJP/'.now()->year.'/'.str_pad((string) $index, 4, '0', STR_PAD_LEFT)
                    : null,
                'tarikh_diluluskan' => $status === 'Diluluskan'
                    ? $applicationDate->copy()->addDays(5)->toDateString()
                    : null,
                'tarikh_tamat' => $status === 'Diluluskan'
                    ? $applicationDate->copy()->addMonths(12)->toDateString()
                    : null,
                'sijil_pengecualian_path' => null,
                'ulasan_jkdm' => $status === 'Tidak diluluskan'
                    ? 'Dokumen sokongan belum lengkap.'
                    : ($status === 'Diluluskan' ? 'Permohonan diluluskan untuk ujian paparan.' : null),
                'nama_pegawai_jkdm' => $status === 'Diluluskan' || $status === 'Tidak diluluskan'
                    ? 'Pegawai JKDM '.$index
                    : null,
                'tarikh_ulasan_jkdm' => $status === 'Diluluskan' || $status === 'Tidak diluluskan'
                    ? $applicationDate->copy()->addDays(3)->toDateString()
                    : null,
            ];

            Permohonan58A::query()->updateOrCreate(
                ['no_pesanan_belian' => $payload['no_pesanan_belian']],
                $payload
            );
        }
    }
}
