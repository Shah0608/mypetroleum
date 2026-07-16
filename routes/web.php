<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return match (auth()->user()->role) {
            'admin' => redirect()->route('admin.utama'),
            'jkdm' => redirect()->route('jkdm.utama'),
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

    // Haluan Dashboard Syarikat
    Route::get('/syarikat/dashboard', [DashboardController::class, 'syarikat'])
        ->middleware('role:syarikat')->name('syarikat.dashboard');
    Route::view('/syarikat/utama', 'syarikat.utama')->middleware('role:syarikat')->name('syarikat.utama');
    Route::get('/syarikat/permohonan-58a', [App\Http\Controllers\Syarikat\Permohonan58AController::class, 'create'])
        ->middleware('role:syarikat')->name('syarikat.permohonan-58a');
    Route::post('/syarikat/permohonan-58a', [App\Http\Controllers\Syarikat\Permohonan58AController::class, 'store'])
        ->middleware('role:syarikat')->name('syarikat.permohonan-58a.store');
    Route::view('/syarikat/laporan-cj', 'syarikat.laporan-cj')->middleware('role:syarikat')->name('syarikat.laporan-cj');
    Route::view('/syarikat/senarailaporan', 'syarikat.senarailaporan')->middleware('role:syarikat')->name('syarikat.senarailaporan');
    Route::get('/syarikat/senaraipermohonan', [App\Http\Controllers\Syarikat\Permohonan58AController::class, 'index'])
        ->middleware('role:syarikat')->name('syarikat.senaraipermohonan');
    Route::get('/syarikat/permohonan-58a/{id}/attachment/{index}', [App\Http\Controllers\Syarikat\Permohonan58AController::class, 'downloadAttachment'])
        ->middleware('role:syarikat')->name('syarikat.permohonan-58a.attachment');

    // Haluan Dashboard JKDM
    Route::get('/jkdm/dashboard', [DashboardController::class, 'jkdm'])
        ->middleware('role:jkdm')->name('jkdm.dashboard');
    Route::view('/jkdm/utama', 'jkdm.utama')->middleware('role:jkdm')->name('jkdm.utama');
    Route::view('/jkdm/senarailaporan', 'jkdm.senarailaporan')->middleware('role:jkdm')->name('jkdm.senarailaporan');
    Route::view('/jkdm/senaraipermohonan', 'jkdm.senaraipermohonan')->middleware('role:jkdm')->name('jkdm.senaraipermohonan');

    // Haluan Dashboard Admin
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->middleware('role:admin')->name('admin.dashboard');
    Route::view('/admin/utama', 'admin.utama')->middleware('role:admin')->name('admin.utama');
    Route::view('/admin/uruspengguna', 'admin.uruspengguna')->middleware('role:admin')->name('admin.uruspengguna');
    Route::view('/admin/tambahpengguna', 'admin.tambahpengguna')->middleware('role:admin')->name('admin.tambahpengguna');
    Route::view('/admin/senarailaporan', 'admin.senarailaporan')->middleware('role:admin')->name('admin.senarailaporan');
    Route::view('/admin/senaraipermohonan', 'admin.senaraipermohonan')->middleware('role:admin')->name('admin.senaraipermohonan');
});

require __DIR__.'/auth.php';

// Static pages for MyPetroleum
Route::view('/about', 'about')->name('about');
Route::view('/panduan-58a', 'panduan-58a')->name('panduan.58a');
Route::view('/manual', 'manual')->name('manual');
Route::view('/contact', 'contact')->name('contact');
