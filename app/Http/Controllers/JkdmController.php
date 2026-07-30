<?php

namespace App\Http\Controllers;

use App\Models\LaporanCjp;
use App\Models\Permohonan58A;
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

        $approvalNotifications = Permohonan58A::query()
            ->where('status', 'Diluluskan')
            ->whereNotNull('no_sijil_pengecualian')
            ->whereNull('jkdm_notified_at')
            ->latest('updated_at')
            ->get(['id', 'nama_syarikat', 'no_sijil_pengecualian']);

        if ($approvalNotifications->isNotEmpty()) {
            Permohonan58A::query()
                ->whereKey($approvalNotifications->modelKeys())
                ->update(['jkdm_notified_at' => now()]);
        }

        return view('jkdm.senaraipermohonan', compact('permohonans', 'approvalNotifications'));
    }

    public function review(Permohonan58A $permohonan): mixed
    {
        return view('jkdm.semakan-permohonan', compact('permohonan'));
    }

    public function ketuaHome(): mixed
    {
        $jumlahPermohonan = Permohonan58A::query()->count();
        $jumlahLaporanCjp = LaporanCjp::query()->count();

        return view('ketua.utama', compact('jumlahPermohonan', 'jumlahLaporanCjp'));
    }

    public function ketuaApplications(): mixed
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

        return view('ketua.senaraipermohonan', compact('permohonans'));
    }

    public function ketuaReports(): mixed
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

        return view('ketua.senarailaporan', compact('laporans', 'query'));
    }

    public function ketuaReview(Permohonan58A $permohonan): mixed
    {
        return view('ketua.semakan-permohonan', compact('permohonan'));
    }

    public function ketuaPreviewApplication(Permohonan58A $permohonan): mixed
    {
        return view('pdf.permohonan-58a', [
            'permohonan' => $permohonan,
            'previewMode' => true,
            'downloadUrl' => route('ketua.permohonan.pdf', $permohonan),
            'backUrl' => route('ketua.permohonan.semak', $permohonan),
        ]);
    }

    public function ketuaUpdate(Request $request, Permohonan58A $permohonan): RedirectResponse
    {
        $role = $request->user()?->role;
        abort_unless($role === 'ketua_unit_jkdm', 403, 'Hanya Ketua Unit boleh mengemas kini bahagian ini.');

        $data = $request->validate([
            'review_section' => ['required', 'in:ketua_unit'],
            'ulasan_ketua_unit' => ['nullable', 'string', 'max:5000'],
            'nama_pegawai_ketua_unit' => ['nullable', 'string', 'max:255'],
            'tarikh_ulasan_ketua_unit' => ['nullable', 'date'],
            'tarikh_tamat_pda2_ketua_unit' => ['nullable', 'date'],
        ]);

        unset($data['review_section']);
        $permohonan->update($data);

        return to_route('ketua.senaraipermohonan')->with('success', 'Semakan berjaya disimpan.');
    }

    public function ketuaPrintApplication(Permohonan58A $permohonan): Response
    {
        return response()->view('pdf.permohonan-58a', [
            'permohonan' => $permohonan,
            'printMode' => true,
        ]);
    }

    public function previewApplication(Permohonan58A $permohonan): mixed
    {
        return view('pdf.permohonan-58a', [
            'permohonan' => $permohonan,
            'previewMode' => true,
            'downloadUrl' => route('jkdm.permohonan.pdf', $permohonan),
            'backUrl' => route('jkdm.permohonan.semak', $permohonan),
        ]);
    }

    public function update(Request $request, Permohonan58A $permohonan): RedirectResponse
    {
        $role = $request->user()?->role;
        abort_unless(in_array($role, ['jkdm', 'ketua_unit_jkdm'], true), 403, 'Hanya pegawai JKDM boleh mengemas kini semakan.');

        $section = $request->string('review_section')->toString();

        if ($section === 'verifikasi') {
            abort_unless($role === 'jkdm', 403, 'Hanya pegawai JKDM boleh mengemas kini bahagian ini.');

            $data = $request->validate([
                'review_section' => ['required', 'in:verifikasi'],
                'ulasan_pegawai_verifikasi' => ['nullable', 'string', 'max:5000'],
                'nama_pegawai_verifikasi' => ['nullable', 'string', 'max:255'],
                'tarikh_ulasan_verifikasi' => ['nullable', 'date'],
                'tarikh_tamat_pda2_verifikasi' => ['nullable', 'date'],
            ]);

            unset($data['review_section']);
            $permohonan->update($data);
        } elseif ($section === 'ketua_unit') {
            abort_unless(in_array($role, ['jkdm', 'ketua_unit_jkdm'], true), 403, 'Hanya pegawai JKDM atau Ketua Unit boleh mengemas kini bahagian ini.');

            $data = $request->validate([
                'review_section' => ['required', 'in:ketua_unit'],
                'ulasan_ketua_unit' => ['nullable', 'string', 'max:5000'],
                'nama_pegawai_ketua_unit' => ['nullable', 'string', 'max:255'],
                'tarikh_ulasan_ketua_unit' => ['nullable', 'date'],
                'tarikh_tamat_pda2_ketua_unit' => ['nullable', 'date'],
            ]);

            unset($data['review_section']);
            $permohonan->update($data);
        }

        return to_route('jkdm.senaraipermohonan')->with('success', 'Semakan berjaya disimpan.');
    }

    public function printApplication(Permohonan58A $permohonan): Response
    {
        return response()->view('pdf.permohonan-58a', [
            'permohonan' => $permohonan,
            'printMode' => true,
        ]);
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
