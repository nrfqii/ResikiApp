<?php

use App\Http\Controllers\PesananController;
use App\Http\Controllers\MasyarakatController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\AuthController;


// Pesan
Route::get('/pesan', [PesananController::class, 'index'])->name('pesan.index')->middleware('auth');
Route::post('/pesan/store', [PesananController::class, 'store'])->name('pesan.store')->middleware('auth');
Route::get('/pesan/{id}', [PesananController::class, 'show'])->name('pesan.show')->middleware('auth');
Route::get('/riwayat-pesanan', [PesananController::class, 'riwayat'])->name('pesan.riwayat')->middleware('auth');
Route::get('/dashboard/konsumen', [MasyarakatController::class, 'dashboard'])->name('dashboard');
Route::get('/konsumen/pesanan/{id}/detail', [PesananController::class, 'showDetail'])->name('pesanan.detail');

// Ulasan
Route::get('/ulasan', [UlasanController::class, 'index'])->name('ulasan.index');
Route::post('/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');


// Route untuk Petugas
Route::get('/dashboard/petugas', [PetugasController::class, 'dashboard'])->name('petugas.dashboard');
Route::get('/petugas/pesanan', [PetugasController::class, 'pesananMasuk'])->name('petugas.pesanan');
Route::get('/petugas/riwayat', [PetugasController::class, 'riwayatPesanan'])->name('petugas.riwayat');
// Route::get('/petugas/pesanan/{id}/detail', [PetugasController::class, 'showOrderDetail'])->name('petugas.pesanan.detail');
Route::post('/petugas/pesanan/{id}/status', [PetugasController::class, 'updateStatus'])->name('petugas.pesanan.update-status');
Route::get('/pesanan/{id}/info', [PetugasController::class, 'getOrderInfo'])->name('petugas.pesanan.info');
Route::get('/petugas/pesanan/{id}/detail-json', [PetugasController::class, 'getOrderDetailsJson'])->name('petugas.pesanan.detail-json');

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Default home
Route::get('/', function () {
    if (!Auth::check())
        return redirect('/login');

    $role = Auth::user()->role;
    return redirect("/dashboard/$role");
});

// modal

Route::get('/pesanan/{id}/detail-json', [PesananController::class, 'getDetailJson'])
    ->middleware(['auth']) // pastikan user login
    ->name('pesanan.detail-json');

// tes
// Route::get('/order/{id}/detail', [PesananController::class, 'showDetail'])->name('order.detail');