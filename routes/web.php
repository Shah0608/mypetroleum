<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\JkdmController;
use App\Http\Controllers\PelulusController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Syarikat\LaporanCjpController;
use App\Http\Controllers\Syarikat\Permohonan58AController;
use App\Models\LaporanCjp;
use App\Models\Permohonan58A;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return match (auth()->user()->role) {
            'admin' => redirect()->route('admin.utama'),
            'jkdm' => redirect()->route('jkdm.utama'),
            'pelulus' => redirect()->route('pelulus.utama'),
            default => redirect()->route('syarikat.utama'),
        };
    }

    return view('main');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return match (auth()->user()->role) {
            'admin' => redirect()->route('admin.utama'),
            'jkdm' => redirect()->route('jkdm.utama'),
            'pelulus' => redirect()->route('pelulus.utama'),
            default => redirect()->route('syarikat.utama'),
        };
    })->name('dashboard');

    // Haluan Syarikat
    Route::get('/syarikat/utama', function () {
        return view('syarikat.utama', [
            'jumlahPermohonan' => Permohonan58A::query()
                ->where('user_id', auth()->id())
                ->count(),
        ]);
    })->middleware('role:syarikat')->name('syarikat.utama');
    Route::get('/syarikat/permohonan-58a', [Permohonan58AController::class, 'create'])
        ->middleware('role:syarikat')->name('syarikat.permohonan-58a');
    Route::post('/syarikat/permohonan-58a', [Permohonan58AController::class, 'store'])
        ->middleware('role:syarikat')->name('syarikat.permohonan-58a.store');
    Route::view('/syarikat/laporan-cj', 'syarikat.laporan-cj')->middleware('role:syarikat')->name('syarikat.laporan-cj');
    Route::post('/syarikat/laporan-cj', [LaporanCjpController::class, 'store'])->middleware('role:syarikat')->name('syarikat.laporan-cj.store');
    Route::get('/syarikat/senarailaporan', function (Request $request) {
        $query = trim((string) $request->query('q', ''));

        $laporans = LaporanCjp::query()
            ->where('user_id', $request->user()->id)
            ->when($query !== '', function ($builder) use ($query): void {
                $builder->where(function ($search) use ($query): void {
                    $search->where('negeri', 'like', '%'.$query.'%')
                        ->orWhere('nama_syarikat', 'like', '%'.$query.'%')
                        ->orWhere('bulan', 'like', '%'.$query.'%');

                    if (preg_match('/^\d{4}$/', $query) === 1) {
                        $search->orWhere('tahun', (int) $query);
                    }
                });
            })
            ->latest()
            ->get();

        return view('syarikat.senarailaporan', compact('laporans', 'query'));
    })->middleware('role:syarikat')->name('syarikat.senarailaporan');
    Route::get('/syarikat/senaraipermohonan', [Permohonan58AController::class, 'index'])
        ->middleware('role:syarikat')->name('syarikat.senaraipermohonan');
    Route::get('/syarikat/permohonan-58a/{id}/attachment/{index}', [Permohonan58AController::class, 'downloadAttachment'])
        ->middleware('role:syarikat')->name('syarikat.permohonan-58a.attachment');

    // Haluan JKDM
    Route::get('/jkdm/utama', function () {
        return view('jkdm.utama', [
            'jumlahPermohonan' => Permohonan58A::query()->count(),
        ]);
    })->middleware('role:jkdm')->name('jkdm.utama');
    Route::get('/jkdm/senarailaporan', [JkdmController::class, 'reports'])->middleware('role:jkdm')->name('jkdm.senarailaporan');
    Route::get('/jkdm/senarailaporan/export', [JkdmController::class, 'exportReports'])->middleware('role:jkdm')->name('jkdm.senarailaporan.export');
    Route::get('/jkdm/senaraipermohonan', [JkdmController::class, 'applications'])->middleware('role:jkdm')->name('jkdm.senaraipermohonan');
    Route::get('/jkdm/senaraipermohonan/{permohonan}/semak', [JkdmController::class, 'review'])->middleware('role:jkdm')->name('jkdm.permohonan.semak');
    Route::put('/jkdm/senaraipermohonan/{permohonan}', [JkdmController::class, 'update'])->middleware('role:jkdm')->name('jkdm.permohonan.update');
    Route::get('/jkdm/senaraipermohonan/{permohonan}/pdf', [JkdmController::class, 'printApplication'])->middleware('role:jkdm')->name('jkdm.permohonan.pdf');

    // Haluan Pelulus
    Route::get('/pelulus/utama', function () {
        return view('pelulus.utama', [
            'jumlahPermohonan' => Permohonan58A::query()->count(),
        ]);
    })->middleware('role:pelulus')->name('pelulus.utama');
    Route::get('/pelulus/senaraipermohonan', [PelulusController::class, 'applications'])->middleware('role:pelulus')->name('pelulus.senaraipermohonan');
    Route::get('/pelulus/senaraipermohonan/{permohonan}/semak', [PelulusController::class, 'review'])->middleware('role:pelulus')->name('pelulus.permohonan.semak');
    Route::put('/pelulus/senaraipermohonan/{permohonan}', [PelulusController::class, 'update'])->middleware('role:pelulus')->name('pelulus.permohonan.update');
    Route::get('/pelulus/senaraipermohonan/{permohonan}/pdf', [PelulusController::class, 'printApplication'])->middleware('role:pelulus')->name('pelulus.permohonan.pdf');

    // Haluan Admin
    Route::get('/admin/utama', function () {
        return view('admin.utama', [
            'jumlahPermohonan' => Permohonan58A::query()->count(),
        ]);
    })->middleware('role:admin')->name('admin.utama');
    Route::get('/admin/uruspengguna', [AdminController::class, 'users'])->middleware('role:admin')->name('admin.uruspengguna');
    Route::get('/admin/tambahpengguna', [AdminController::class, 'createUser'])->middleware('role:admin')->name('admin.tambahpengguna');
    Route::post('/admin/tambahpengguna', [AdminController::class, 'storeUser'])->middleware('role:admin')->name('admin.pengguna.store');
    Route::get('/admin/pengguna/{user}/edit', [AdminController::class, 'editUser'])->middleware('role:admin')->name('admin.pengguna.edit');
    Route::put('/admin/pengguna/{user}', [AdminController::class, 'updateUser'])->middleware('role:admin')->name('admin.pengguna.update');
    Route::delete('/admin/pengguna/{user}', [AdminController::class, 'destroyUser'])->middleware('role:admin')->name('admin.pengguna.destroy');
    Route::get('/admin/senarailaporan', [AdminController::class, 'reports'])->middleware('role:admin')->name('admin.senarailaporan');
    Route::get('/admin/senarailaporan/export', [AdminController::class, 'exportReports'])->middleware('role:admin')->name('admin.senarailaporan.export');
    Route::delete('/admin/senarailaporan/{laporan}', [AdminController::class, 'destroyReport'])->middleware('role:admin')->name('admin.laporan.destroy');
    Route::get('/admin/senaraipermohonan', [AdminController::class, 'applications'])->middleware('role:admin')->name('admin.senaraipermohonan');
    Route::get('/admin/senaraipermohonan/{permohonan}/semak', [AdminController::class, 'reviewApplication'])->middleware('role:admin')->name('admin.permohonan.semak');
    Route::put('/admin/senaraipermohonan/{permohonan}', [AdminController::class, 'updateApplication'])->middleware('role:admin')->name('admin.permohonan.update');
    Route::get('/admin/senaraipermohonan/{permohonan}/pdf', [AdminController::class, 'printApplication'])->middleware('role:admin')->name('admin.permohonan.pdf');
    Route::delete('/admin/senaraipermohonan/{permohonan}', [AdminController::class, 'destroyApplication'])->middleware('role:admin')->name('admin.permohonan.destroy');
});

require __DIR__.'/auth.php';

// Static pages for MyPetroleum
Route::view('/about', 'about')->name('about');
Route::view('/panduan-58a', 'panduan-58a')->name('panduan.58a');
Route::view('/manual', 'manual')->name('manual');
Route::view('/contact', 'contact')->name('contact');
