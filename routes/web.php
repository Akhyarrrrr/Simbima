<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\BimbinganController as AdminBimbinganController;
use App\Http\Controllers\Admin\DosenController as AdminDosenController;
use App\Http\Controllers\Admin\MahasiswaController as AdminMahasiswaController;
use App\Http\Controllers\Admin\MahasiswaImportController as AdminMahasiswaImportController;
use App\Http\Controllers\Admin\UserPasswordController as AdminUserPasswordController;
use App\Http\Controllers\BimbinganDetailController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dosen\BimbinganController as DosenBimbinganController;
use App\Http\Controllers\Dosen\BimbinganStatusController as DosenBimbinganStatusController;
use App\Http\Controllers\Dosen\DashboardController as DosenDashboardController;
use App\Http\Controllers\Dosen\PengajuanController as DosenPengajuanController;
use App\Http\Controllers\Mahasiswa\BimbinganController as MahasiswaBimbinganController;
use App\Http\Controllers\Mahasiswa\BidangMinatController as MahasiswaBidangMinatController;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboardController;
use App\Http\Controllers\Mahasiswa\PengajuanController as MahasiswaPengajuanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CatatanBimbinganController;
use App\Http\Controllers\StatistikDosenController;
use App\Http\Middleware\EnsureAdmin;
use App\Http\Middleware\EnsureDosen;
use App\Http\Middleware\EnsureMahasiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }

    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/notifications/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();

        return back();
    })->name('notifications.mark-all-read');
    Route::post('/bimbingan/{id}/catatan', [CatatanBimbinganController::class, 'store'])->name('bimbingan.catatan.store');
    Route::get('/bimbingan/{id}', [BimbinganDetailController::class, 'show'])->name('bimbingan.show');
    Route::get('/statistik/dosen', [StatistikDosenController::class, 'index'])->name('statistik.dosen');
    Route::get('/statistik/dosen/export', [StatistikDosenController::class, 'export'])->name('statistik.dosen.export');
});

Route::middleware(['auth', EnsureMahasiswa::class])
    ->prefix('mahasiswa')
    ->name('mahasiswa.')
    ->group(function () {
        Route::get('/dashboard', [MahasiswaDashboardController::class, 'index'])->name('dashboard');
        Route::patch('/bidang-minat', [MahasiswaBidangMinatController::class, 'update'])->name('bidang-minat.update');
        Route::post('/pengajuan', [MahasiswaPengajuanController::class, 'store'])->name('pengajuan.store');
        Route::delete('/pengajuan/{id}', [MahasiswaPengajuanController::class, 'destroy'])->name('pengajuan.destroy');
        Route::patch('/bimbingan/{id}', [MahasiswaBimbinganController::class, 'update'])->name('bimbingan.update');
    });

Route::middleware(['auth', EnsureDosen::class])
    ->prefix('dosen')
    ->name('dosen.')
    ->group(function () {
        Route::get('/dashboard', [DosenDashboardController::class, 'index'])->name('dashboard');
        Route::patch('/pengajuan/{id}/approve', [DosenPengajuanController::class, 'approve'])->name('pengajuan.approve');
        Route::patch('/pengajuan/{id}/reject', [DosenPengajuanController::class, 'reject'])->name('pengajuan.reject');
        Route::patch('/bimbingan/{id}/selesai', [DosenBimbinganController::class, 'markSelesai'])->name('bimbingan.selesai');
        Route::patch('/bimbingan/{id}/status', [DosenBimbinganStatusController::class, 'update'])->name('bimbingan.status.update');
        Route::patch('/bimbingan/{id}/dospem2', [DosenBimbinganController::class, 'updateDospem2'])->name('bimbingan.dospem2.update');
    });

Route::middleware(['auth', EnsureAdmin::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::patch('users/{user}/password', [AdminUserPasswordController::class, 'update'])->name('users.password.update');
        Route::patch('bimbingan/{id}/dospem2', [AdminBimbinganController::class, 'updateDospem2'])->name('bimbingan.dospem2.update');
        Route::resource('dosen', AdminDosenController::class);
        Route::get('mahasiswa/import', [AdminMahasiswaImportController::class, 'create'])->name('mahasiswa.import.create');
        Route::post('mahasiswa/import', [AdminMahasiswaImportController::class, 'store'])->name('mahasiswa.import.store');
        Route::get('mahasiswa/import/download/{filename}', [AdminMahasiswaImportController::class, 'downloadCredentials'])->name('mahasiswa.import.download');
        Route::resource('mahasiswa', AdminMahasiswaController::class);
    });

require __DIR__.'/auth.php';
