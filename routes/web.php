<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KlubController;
use App\Http\Controllers\PemainController;
use App\Http\Controllers\PertandinganController;
use App\Http\Controllers\PertandinganStatistikController;
use App\Http\Controllers\KlasemenController;
use App\Http\Controllers\LigaController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\NewsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ===================================================
// == RUTE PUBLIK (Bisa diakses oleh semua orang) ==
// ===================================================
Route::get('/', function () {
    return view('welcome');
});

Route::get('/klasemen', [KlasemenController::class, 'index'])->name('klasemen.index');

// Rute untuk MENAMPILKAN daftar (method index)
Route::get('/klub', [KlubController::class, 'index'])->name('klub.index');
Route::get('/pemain', [PemainController::class, 'index'])->name('pemain.index');
Route::get('/pertandingan', [PertandinganController::class, 'index'])->name('pertandingan.index');
Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::get('/', [NewsController::class, 'index'])->name('welcome');

// ===================================================
// == RUTE ADMIN (Hanya bisa diakses setelah login) ==
// ===================================================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD Penuh untuk Liga
    Route::resource('liga', LigaController::class);

    // Rute untuk MENGELOLA (Create, Store, Edit, Update, Destroy) Klub & Pemain
    Route::resource('klub', KlubController::class)->except(['index']);
    Route::resource('pemain', PemainController::class)->except(['index']);

    // Rute untuk MENGELOLA Pertandingan & Statistik
    Route::get('/pertandingan/create', [PertandinganController::class, 'create'])->name('pertandingan.create');
    Route::post('/pertandingan', [PertandinganController::class, 'store'])->name('pertandingan.store');
    Route::delete('/pertandingan/{pertandingan}', [PertandinganController::class, 'destroy'])->name('pertandingan.destroy');
    Route::get('/pertandingan/{pertandingan}/statistik', [PertandinganStatistikController::class, 'edit'])->name('pertandingan.statistik.edit');
    Route::put('/pertandingan/{pertandingan}/statistik', [PertandinganStatistikController::class, 'update'])->name('pertandingan.statistik.update');
});


require __DIR__.'/auth.php';