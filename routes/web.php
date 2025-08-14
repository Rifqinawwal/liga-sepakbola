<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KlubController;
use App\Http\Controllers\PemainController;
use App\Http\Controllers\PertandinganController;
use App\Http\Controllers\PertandinganStatistikController;
use App\Http\Controllers\KlasemenController;
use App\Http\Controllers\LigaController;

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

// Route untuk halaman utama dan klasemen (bisa diakses publik)
Route::get('/', function () {
    return view('welcome');
});

Route::get('/klasemen', [KlasemenController::class, 'index'])->name('klasemen.index');


// Route yang memerlukan login
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Route untuk profil pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route untuk CRUD Klub & Pemain
    Route::resource('klub', KlubController::class);
    Route::resource('pemain', PemainController::class);

    // Route untuk Manajemen Jadwal Pertandingan
    Route::get('/pertandingan', [PertandinganController::class, 'index'])->name('pertandingan.index');
    Route::get('/pertandingan/create', [PertandinganController::class, 'create'])->name('pertandingan.create');
    Route::post('/pertandingan', [PertandinganController::class, 'store'])->name('pertandingan.store');
    Route::delete('/pertandingan/{pertandingan}', [PertandinganController::class, 'destroy'])->name('pertandingan.destroy');

    // Route untuk Halaman Statistik Terpusat
    Route::get('/pertandingan/{pertandingan}/statistik', [PertandinganStatistikController::class, 'edit'])->name('pertandingan.statistik.edit');
    Route::put('/pertandingan/{pertandingan}/statistik', [PertandinganStatistikController::class, 'update'])->name('pertandingan.statistik.update');

    Route::resource('liga', LigaController::class);
});


require __DIR__.'/auth.php';