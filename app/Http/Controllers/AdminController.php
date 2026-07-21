<?php

namespace App\Http\Controllers;

use App\Models\LaporanCjp;
use App\Models\Permohonan58A;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    public function users(): mixed
    {
        return view('admin.uruspengguna', ['users' => User::latest()->get()]);
    }

    public function createUser(): mixed
    {
        return view('admin.tambahpengguna');
    }

    public function storeUser(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'login_id' => ['required', 'string', 'max:255', 'unique:users,login_id'],
            'role' => ['required', 'in:syarikat,jkdm,admin'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        $data['password'] = Hash::make($data['password']);
        User::create($data);

        return to_route('admin.uruspengguna')->with('success', 'Pengguna berjaya ditambah.');
    }

    public function editUser(User $user): mixed
    {
        return view('admin.tambahpengguna', compact('user'));
    }

    public function updateUser(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'login_id' => ['required', 'string', 'max:255', 'unique:users,login_id,'.$user->id],
            'role' => ['required', 'in:syarikat,jkdm,admin'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);
        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }
        $user->update($data);

        return to_route('admin.uruspengguna')->with('success', 'Pengguna berjaya dikemaskini.');
    }

    public function destroyUser(User $user): RedirectResponse
    {
        abort_if($user->is(auth()->user()), 422, 'Akaun sendiri tidak boleh dipadam.');
        $user->delete();

        return to_route('admin.uruspengguna')->with('success', 'Pengguna berjaya dipadam.');
    }

    public function applications(): mixed
    {
        return view('admin.senaraipermohonan', ['permohonans' => Permohonan58A::with('user')->latest()->get()]);
    }

    public function reviewApplication(Permohonan58A $permohonan): mixed
    {
        return view('admin.semakan-permohonan', compact('permohonan'));
    }

    public function updateApplication(Request $request, Permohonan58A $permohonan): RedirectResponse
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

        return to_route('admin.senaraipermohonan')->with('success', 'Semakan berjaya disimpan.');
    }

    public function reports(): mixed
    {
        return view('admin.senarailaporan', ['laporans' => LaporanCjp::with('user')->latest()->get()]);
    }

    public function exportReports(): StreamedResponse
    {
        $laporans = LaporanCjp::with('user')->latest()->get();

        return response()->streamDownload(function () use ($laporans): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Negeri', 'Nama Syarikat', 'Tahun', 'Bulan', 'ID Pengguna', 'Tarikh Hantar']);

            foreach ($laporans as $laporan) {
                fputcsv($handle, [
                    $laporan->negeri,
                    $laporan->nama_syarikat,
                    $laporan->tahun,
                    $laporan->bulan,
                    $laporan->user?->login_id,
                    $laporan->created_at?->format('d/m/Y'),
                ]);
            }

            fclose($handle);
        }, 'laporan-cjp-admin-'.now()->format('Ymd-His').'.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function destroyApplication(Permohonan58A $permohonan): RedirectResponse
    {
        $permohonan->delete();

        return back()->with('success', 'Permohonan berjaya dipadam.');
    }

    public function destroyReport(LaporanCjp $laporan): RedirectResponse
    {
        $laporan->delete();

        return back()->with('success', 'Laporan berjaya dipadam.');
    }
}
