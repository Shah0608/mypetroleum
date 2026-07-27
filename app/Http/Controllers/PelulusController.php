<?php

namespace App\Http\Controllers;

use App\Models\Permohonan58A;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PelulusController extends Controller
{
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
            'kod_stesen' => ['nullable', 'string', 'max:10'],
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
        return response()->view('pdf.permohonan-58a', [
            'permohonan' => $permohonan,
            'printMode' => true,
        ]);
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
