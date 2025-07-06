<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaborController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');

    Route::resource('mahasiswa', UserProfileController::class);
    Route::resource('labors', LaborController::class);

    // Route yang bisa diakses tanpa profil lengkap (melihat daftar)
    Route::get('peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');

    // Route yang WAJIB profil lengkap (membuat & menyimpan peminjaman)
    Route::middleware(['profil.lengkap'])->group(function() {
        Route::get('peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
        Route::post('peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    });

    // Route untuk Admin
    Route::middleware(['role:admin'])->group(function () {
        Route::patch('peminjaman/{peminjaman}/status', [PeminjamanController::class, 'updateStatus'])
            ->name('peminjaman.updateStatus');
    });
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
});