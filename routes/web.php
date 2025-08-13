<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KlubController;
use App\Http\Controllers\PemainController;
use App\Http\Controllers\PertandinganController;
use App\Http\Controllers\PertandinganStatistikController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('klub', KlubController::class);
    Route::resource('pemain', PemainController::class);
    Route::delete('/pertandingan/{pertandingan}', [PertandinganController::class, 'destroy'])->name('pertandingan.destroy');
    Route::post('/pertandingan', [PertandinganController::class, 'store'])->name('pertandingan.store');
    Route::get('/pertandingan/create', [PertandinganController::class, 'create'])->name('pertandingan.create');
    Route::get('/pertandingan', [PertandinganController::class, 'index'])->name('pertandingan.index');
    Route::post('/pertandingan/{pertandingan}/kartu', [PertandinganStatistikController::class, 'storeKartu'])->name('pertandingan.statistik.storeKartu');
    Route::delete('/kartu/{kartu}', [PertandinganStatistikController::class, 'destroyKartu'])->name('pertandingan.statistik.destroyKartu');

    Route::get('/pertandingan/{pertandingan}/statistik', [PertandinganStatistikController::class, 'edit'])->name('pertandingan.statistik.edit');
    Route::put('/pertandingan/{pertandingan}/skor', [PertandinganStatistikController::class, 'updateSkor'])->name('pertandingan.statistik.updateSkor');
    Route::post('/pertandingan/{pertandingan}/gol', [PertandinganStatistikController::class, 'storeGol'])->name('pertandingan.statistik.storeGol');
    Route::delete('/gol/{gol}', [PertandinganStatistikController::class, 'destroyGol'])->name('pertandingan.statistik.destroyGol');
});

require __DIR__.'/auth.php';
