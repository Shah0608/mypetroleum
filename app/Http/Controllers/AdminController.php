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
        $query = trim((string) request()->query('q', ''));

        $users = User::query()
            ->when($query !== '', function ($builder) use ($query): void {
                $builder->where(function ($search) use ($query): void {
                    $search->where('name', 'like', '%'.$query.'%')
                        ->orWhere('login_id', 'like', '%'.$query.'%')
                        ->orWhere('role', 'like', '%'.$query.'%');
                });
            })
            ->latest()
            ->get();

        return view('admin.uruspengguna', compact('users', 'query'));
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
        $query = trim((string) request()->query('q', ''));

        $permohonans = Permohonan58A::with('user')
            ->when($query !== '', function ($builder) use ($query): void {
                $builder->where(function ($search) use ($query): void {
                    $search->where('nama_syarikat', 'like', '%'.$query.'%')
                        ->orWhere('negeri', 'like', '%'.$query.'%')
                        ->orWhere('status', 'like', '%'.$query.'%')
                        ->orWhere('no_sijil_pengecualian', 'like', '%'.$query.'%')
                        ->orWhere('no_pesanan_belian', 'like', '%'.$query.'%')
                        ->orWhereHas('user', function ($userQuery) use ($query): void {
                            $userQuery->where('login_id', 'like', '%'.$query.'%');
                        });

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

        return view('admin.senaraipermohonan', compact('permohonans', 'query'));
    }

    public function reviewApplication(Permohonan58A $permohonan): mixed
    {
        return view('admin.semakan-permohonan', compact('permohonan'));
    }

    public function updateApplication(Request $request, Permohonan58A $permohonan): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['nullable', 'string', 'max:255'],
            'no_telefon' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'no_kp' => ['nullable', 'string', 'max:50'],
            'jawatan' => ['nullable', 'string', 'max:255'],
            'nama_syarikat' => ['nullable', 'string', 'max:255'],
            'no_pendaftaran_cukai' => ['nullable', 'string', 'max:255'],
            'tarikh_permohonan' => ['nullable', 'date'],
            'no_kelulusan' => ['nullable', 'string', 'max:255'],
            'no_pesanan_belian' => ['nullable', 'string', 'max:255'],
            'alamat' => ['nullable', 'string'],
            'negeri' => ['nullable', 'string', 'max:255'],
            'tandatangan_nama' => ['nullable', 'string', 'max:255'],
            'tandatangan_no_kp' => ['nullable', 'string', 'max:50'],
            'tandatangan_jawatan' => ['nullable', 'string', 'max:255'],
            'pembekal_nama' => ['nullable', 'string', 'max:255'],
            'pembekal_alamat' => ['nullable', 'string'],
            'kod_tarif' => ['array'],
            'kod_tarif.*' => ['nullable', 'string'],
            'perihal_barang' => ['array'],
            'perihal_barang.*' => ['nullable', 'string'],
            'unit' => ['array'],
            'unit.*' => ['nullable', 'string'],
            'deskripsi' => ['array'],
            'deskripsi.*' => ['nullable', 'string'],
            'kuantiti' => ['array'],
            'kuantiti.*' => ['nullable', 'numeric'],
            'nilai' => ['array'],
            'nilai.*' => ['nullable', 'numeric'],
            'kawasan' => ['array'],
            'kawasan.*' => ['nullable', 'string'],
            'status' => ['required', 'in:Dalam tindakan,Diluluskan,Tidak diluluskan'],
            'no_sijil_pengecualian' => ['nullable', 'string', 'max:100'],
            'tarikh_diluluskan' => ['nullable', 'date'],
            'tarikh_tamat' => ['nullable', 'date', 'after_or_equal:tarikh_diluluskan'],
            'ulasan_jkdm' => ['nullable', 'string', 'max:5000'],
            'nama_pegawai_jkdm' => ['nullable', 'string', 'max:255'],
            'tarikh_ulasan_jkdm' => ['nullable', 'date'],
            'sijil_pengecualian' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $barangs = [];
        foreach ($request->input('kod_tarif', []) as $index => $kodTarif) {
            if (blank($kodTarif) && blank($request->input("perihal_barang.$index"))) {
                continue;
            }

            $barangs[] = [
                'kod_tarif' => $kodTarif,
                'perihal' => $request->input("perihal_barang.$index"),
                'unit' => $request->input("unit.$index"),
                'deskripsi' => $request->input("deskripsi.$index"),
                'kuantiti' => $request->input("kuantiti.$index"),
                'nilai' => $request->input("nilai.$index"),
                'kawasan' => $request->input("kawasan.$index"),
            ];
        }

        $data['barangs'] = $barangs;

        if ($request->hasFile('sijil_pengecualian')) {
            $data['sijil_pengecualian_path'] = $request->file('sijil_pengecualian')->store('sijil-pengecualian', 'public');
        }

        unset($data['kod_tarif'], $data['perihal_barang'], $data['unit'], $data['deskripsi'], $data['kuantiti'], $data['nilai'], $data['kawasan']);
        unset($data['sijil_pengecualian']);
        $permohonan->update($data);

        return to_route('admin.senaraipermohonan')->with('success', 'Semakan berjaya disimpan.');
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

        return view('admin.senarailaporan', compact('laporans', 'query'));
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
