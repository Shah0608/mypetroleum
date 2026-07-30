<?php

namespace App\Http\Controllers;

use App\Models\Permohonan58A;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PelulusController extends Controller
{
    /**
     * @return array<string, string>
     */
    private function stationOptions(): array
    {
        return [
            'M10' => 'M10 - Melaka',
            'N10' => 'N10 - Seremban',
            'N11' => 'N11 - Port Dickson',
            'P11' => 'P11 - Georgetown',
            'P13' => 'P13 - Seberang Jaya',
            'R10' => 'R10 - Kangar',
            'S10' => 'S10 - Kota Kinabalu',
            'T10' => 'T10 - Kuala Terengganu',
            'T13' => 'T13 - Kemaman',
            'W10' => 'W10 - Kuala Lumpur',
            'W24' => 'W24 - KLIA CD',
            'A10' => 'A10 - Ipoh',
            'A11' => 'A11 - Taiping',
            'B10' => 'B10 - Port Klang',
            'B16' => 'B16 - Subang (OPA)',
            'C10' => 'C10 - Kuantan',
            'C11' => 'C11 - Bentong',
            'D10' => 'D10 - Kota Bahru',
            'E10' => 'E10 - Labuan',
            'J11' => 'J11 - Batu Pahat',
            'J12' => 'J12 - Kluang',
            'J13' => 'J13 - Muar',
            'J31' => 'J31 - Johor Bahru',
            'K10' => 'K10 - Alor Setar',
            'Y58' => 'Y58 - Bintulu',
            'Y60' => 'Y60 - Kuching',
        ];
    }

    public function users(): mixed
    {
        $query = trim((string) request()->query('q', ''));

        $allPermohonans = Permohonan58A::query()
            ->select(['id', 'user_id', 'nama_syarikat', 'alamat'])
            ->orderBy('created_at')
            ->orderBy('id')
            ->get();

        $penggunas = $allPermohonans
            ->groupBy(function (Permohonan58A $permohonan): string {
                return mb_strtolower(trim((string) $permohonan->nama_syarikat));
            })
            ->map(function ($companyPermohonans): object {
                $firstPermohonan = $companyPermohonans->first();

                return (object) [
                    'nama_syarikat' => $firstPermohonan?->nama_syarikat,
                    'alamat' => $firstPermohonan?->alamat,
                    'bilangan_permohonan' => $companyPermohonans->count(),
                    'first_created_at' => $companyPermohonans->min('created_at'),
                ];
            })
            ->sortBy('first_created_at')
            ->values()
            ->when($query !== '', function ($collection) use ($query) {
                return $collection->filter(function ($company) use ($query): bool {
                    return str_contains(strtolower((string) $company->nama_syarikat), strtolower($query))
                        || str_contains(strtolower((string) $company->alamat), strtolower($query));
                })->values();
            });

        return view('pelulus.senarai-pengguna', compact('penggunas', 'query'));
    }

    public function applications(): mixed
    {
        $query = trim((string) request()->query('q', ''));

        $permohonans = Permohonan58A::with('user')
            ->when($query !== '', function ($builder) use ($query): void {
                $builder->where(function ($search) use ($query): void {
                    $search->where('nama_syarikat', 'like', '%'.$query.'%')
                        ->orWhere('negeri', 'like', '%'.$query.'%')
                        ->orWhere('status', 'like', '%'.$query.'%')
                        ->orWhere('no_sijil_pengecualian', 'like', '%'.$query.'%')
                        ->orWhere('no_pesanan_belian', 'like', '%'.$query.'%');

                    if (preg_match('/^\d{4}$/', $query) === 1) {
                        $search->orWhereYear('tarikh_permohonan', (int) $query)
                            ->orWhereYear('tarikh_diluluskan', (int) $query);
                    }

                    if (preg_match('/^(0?[1-9]|1[0-2])$/', $query) === 1) {
                        $search->orWhereMonth('tarikh_permohonan', (int) $query)
                            ->orWhereMonth('tarikh_diluluskan', (int) $query);
                    }
                });
            })
            ->latest()
            ->get();

        return view('pelulus.senaraipermohonan', compact('permohonans', 'query'));
    }

    public function review(Permohonan58A $permohonan): mixed
    {
        return view('pelulus.semakan-permohonan', compact('permohonan'));
    }

    public function previewApplication(Permohonan58A $permohonan): mixed
    {
        return view('pdf.permohonan-58a', [
            'permohonan' => $permohonan,
            'previewMode' => true,
            'downloadUrl' => route('pelulus.permohonan.pdf', $permohonan),
            'backUrl' => route('pelulus.permohonan.semak', $permohonan),
        ]);
    }

    public function update(Request $request, Permohonan58A $permohonan): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:Dalam tindakan,Diluluskan,Tidak diluluskan'],
            'tarikh_diluluskan' => ['nullable', 'date'],
            'kod_stesen' => ['nullable', 'string', 'in:'.implode(',', array_keys($this->stationOptions()))],
            'no_daftar_sijil' => ['nullable', 'string', 'max:20'],
        ]);

        $wasApproved = $permohonan->status === 'Diluluskan';
        $data['tarikh_tamat'] = $permohonan->tarikh_tamat_cga;
        $data['no_sijil_pengecualian'] = $this->formatCertificateNumber($permohonan, $data);

        if (! $wasApproved && $data['status'] === 'Diluluskan') {
            $data['jkdm_notified_at'] = null;
        }

        unset($data['kod_stesen'], $data['no_daftar_sijil']);
        $permohonan->update($data);

        return to_route('pelulus.senaraipermohonan')->with('success', 'Keputusan berjaya disimpan.');
    }

    public function printApplication(Permohonan58A $permohonan): Response
    {
        return Pdf::loadView('pdf.permohonan-58a', [
            'permohonan' => $permohonan,
        ])->setPaper('a4')->download('permohonan-58a-'.$permohonan->id.'.pdf');
    }

    /**
     * @param  array{tarikh_diluluskan?: string|null, kod_stesen?: string|null, no_daftar_sijil?: string|null}  $data
     */
    private function formatCertificateNumber(Permohonan58A $permohonan, array $data): ?string
    {
        if (blank($data['kod_stesen'] ?? null) && blank($data['no_daftar_sijil'] ?? null)) {
            return $permohonan->no_sijil_pengecualian;
        }

        $yearMonth = filled($data['tarikh_diluluskan'] ?? null)
            ? date('ym', strtotime((string) $data['tarikh_diluluskan']))
            : now()->format('ym');

        $registrationNumber = filled($data['no_daftar_sijil'] ?? null)
            ? str_pad((string) $data['no_daftar_sijil'], 4, '0', STR_PAD_LEFT)
            : str_pad((string) $permohonan->id, 4, '0', STR_PAD_LEFT);

        return strtoupper((string) $data['kod_stesen']).'-58A-'.$yearMonth.'-'.$registrationNumber;
    }
}
