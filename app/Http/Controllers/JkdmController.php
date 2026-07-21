<?php

namespace App\Http\Controllers;

use App\Models\LaporanCjp;
use App\Models\Permohonan58A;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class JkdmController extends Controller
{
    public function applications(): mixed
    {
        return view('jkdm.senaraipermohonan', ['permohonans' => Permohonan58A::with('user')->latest()->get()]);
    }

    public function review(Permohonan58A $permohonan): mixed
    {
        return view('jkdm.semakan-permohonan', compact('permohonan'));
    }

    public function update(Request $request, Permohonan58A $permohonan): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:Dalam tindakan,Diluluskan,Tidak diluluskan'],
            'no_sijil_pengecualian' => ['nullable', 'string', 'max:100'],
            'tarikh_diluluskan' => ['nullable', 'date'],
            'tarikh_tamat' => ['nullable', 'date', 'after_or_equal:tarikh_diluluskan'],
            'ulasan_jkdm' => ['nullable', 'string', 'max:5000'],
            'nama_pegawai_jkdm' => ['nullable', 'string', 'max:255'],
            'tarikh_ulasan_jkdm' => ['nullable', 'date'],
            'sijil_pengecualian' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        if ($request->hasFile('sijil_pengecualian')) {
            $data['sijil_pengecualian_path'] = $request->file('sijil_pengecualian')->store('sijil-pengecualian', 'public');
        }
        unset($data['sijil_pengecualian']);
        $permohonan->update($data);

        return to_route('jkdm.senaraipermohonan')->with('success', 'Semakan berjaya disimpan.');
    }

    public function reports(): mixed
    {
        return view('jkdm.senarailaporan', ['laporans' => LaporanCjp::with('user')->latest()->get()]);
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
