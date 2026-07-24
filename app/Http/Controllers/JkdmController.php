<?php

namespace App\Http\Controllers;

use App\Models\LaporanCjp;
use App\Models\Permohonan58A;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class JkdmController extends Controller
{
    public function applications(): mixed
    {
        $query = trim((string) request()->query('q', ''));

        $permohonans = Permohonan58A::with('user')
            ->when($query !== '', function ($builder) use ($query) {
                $builder->where(function ($search) use ($query) {
                    $search->where('nama_syarikat', 'like', '%'.$query.'%')
                        ->orWhere('negeri', 'like', '%'.$query.'%')
                        ->orWhere('status', 'like', '%'.$query.'%')
                        ->orWhere('no_sijil_pengecualian', 'like', '%'.$query.'%');

                    if (preg_match('/^\d{4}$/', $query) === 1) {
                        $search->orWhereYear('tarikh_permohonan', (int) $query);
                    }

                    if (preg_match('/^(0?[1-9]|1[0-2])$/', $query) === 1) {
                        $search->orWhereMonth('tarikh_permohonan', (int) $query);
                    }
                });
            })
            ->latest()
            ->get();

        return view('jkdm.senaraipermohonan', compact('permohonans'));
    }

    public function review(Permohonan58A $permohonan): mixed
    {
        return view('jkdm.semakan-permohonan', compact('permohonan'));
    }

    public function update(Request $request, Permohonan58A $permohonan): RedirectResponse
    {
        $data = $request->validate([
            'ulasan_jkdm' => ['nullable', 'string', 'max:5000'],
            'nama_pegawai_jkdm' => ['nullable', 'string', 'max:255'],
            'tarikh_ulasan_jkdm' => ['nullable', 'date'],
            'tarikh_tamat_cga' => ['nullable', 'date'],
        ]);

        $permohonan->update($data);

        return to_route('jkdm.senaraipermohonan')->with('success', 'Semakan berjaya disimpan.');
    }

    public function printApplication(Permohonan58A $permohonan): Response
    {
        return Pdf::loadView('pdf.permohonan-58a', compact('permohonan'))
            ->setPaper('a4')
            ->download('permohonan-58a-'.$permohonan->id.'.pdf');
    }

    public function reports(): mixed
    {
        $query = trim((string) request()->query('q', ''));

        $laporans = LaporanCjp::with('user')
            ->when($query !== '', function ($builder) use ($query): void {
                $builder->where(function ($search) use ($query): void {
                    $search->where('negeri', 'like', '%'.$query.'%')
                        ->orWhere('nama_syarikat', 'like', '%'.$query.'%')
                        ->orWhere('bulan', 'like', '%'.$query.'%')
                        ->orWhereHas('user', function ($userQuery) use ($query): void {
                            $userQuery->where('login_id', 'like', '%'.$query.'%');
                        });

                    if (preg_match('/^\d{4}$/', $query) === 1) {
                        $search->orWhere('tahun', (int) $query);
                    }
                });
            })
            ->latest()
            ->get();

        return view('jkdm.senarailaporan', compact('laporans', 'query'));
    }

    public function exportReports(): StreamedResponse
    {
        $laporans = LaporanCjp::with('user')->latest()->get();

        return response()->streamDownload(function () use ($laporans): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Negeri', 'Nama Syarikat', 'Tahun', 'Bulan', 'ID Pengguna', 'Tarikh Hantar']);
            foreach ($laporans as $laporan) {
                fputcsv($handle, [$laporan->negeri, $laporan->nama_syarikat, $laporan->tahun, $laporan->bulan, $laporan->user?->login_id, $laporan->created_at?->format('d/m/Y')]);
            }
            fclose($handle);
        }, 'laporan-cjp-'.now()->format('Ymd-His').'.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
