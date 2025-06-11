<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pesananController;
use App\Http\Controllers\profilController;
use App\Http\Controllers\validasiVerif;
use App\Http\Controllers\VerifikasiUser;

Route::get('/testing', function () {
    return view('testing');
})->name('testing');

Route::get('/cek',  [KendaraanController::class, 'cekKetersediaan'])->name('cek');

Route::get('/bantuanDukungan', function () {
    return view('bantuandukungan');
})->name('bantuanDukungan');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/submitRegister', [AuthController::class, 'submitRegister'])->name('submitRegister');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/submitLogin', [AuthController::class, 'submitLogin'])->name('submitLogin');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [VerifikasiUser::class, 'beranda'])->name('beranda');

Route::get('/pesanan/disabled-dates/{kendaraanId}/{excludePesananId}', [PesananController::class, 'getDisabledDates']);

Route::middleware('auth', 'pengguna')->group(function () {
    //pengguna

    Route::get('/pilihan', [KendaraanController::class, 'pilihan'])->name('pilihan');
    Route::get('/pilihanMotor', [KendaraanController::class, 'pilihanMotor'])->name('pilihanMotor');
    Route::get('/kendaraan/{id}', [KendaraanController::class, 'detail'])->name('kendaraan.detail');

    Route::get('/pesanan/checkout/{id}', [pesananController::class, 'checkout'])->name('pesanan.checkout');
    Route::post('/pesanan/submit/{id}', [pesananController::class, 'submit'])->name('pesanan.submit');
    Route::get('/pesanan/belumDibayar', [pesananController::class, 'belumDibayar'])->name('pesanan.belumDibayar');
    Route::get('/pesanan/order/{id}', [PesananController::class, 'order'])->name('pesanan.order');
    Route::get('/pesanan/diProses', [pesananController::class, 'diProses'])->name('pesanan.diProses');
    Route::get('/pesanan/diKirim', [pesananController::class, 'diKirim'])->name('pesanan.diKirim');
    Route::get('/pesanan/map/{id}', [pesananController::class, 'map'])->name('pesanan.map');
    Route::get('/pesanan/diPakai', [pesananController::class, 'diPakai'])->name('pesanan.diPakai');
    Route::put('/pesanan/tambahDurasi/{id}', [PesananController::class, 'tambahDurasi'])->name('pesanan.tambahDurasi');
    Route::put('/pesanan/selesai/{id}', [PesananController::class, 'updateSelesai'])->name('pesanan.selesai');
    Route::get('/pesanan/riwayat', [pesananController::class, 'riwayat'])->name('pesanan.riwayat');
    Route::get('/pesanan/detail/{id}', [pesananController::class, 'penggunaDetail'])->name('pesanan.penggunaDetail');

    Route::get('/profil', [ProfilController::class, 'checkProfil'])->name('profil.tampil');
    Route::get('/profil/tambah', [ProfilController::class, 'tambah'])->name('profil.tambah');
    Route::post('/profil/submit', [ProfilController::class, 'submit'])->name('profil.submit');
    Route::get('/profil/edit/{id}', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::post('/profil/update/{id}', [ProfilController::class, 'update'])->name('profil.update');
    Route::get('/profil/delete/{id}', [ProfilController::class, 'delete'])->name('profil.delete');

    Route::get('/Verifikasi/User', [VerifikasiUser::class, 'index'])->name('verifikasi.index');
    Route::post('/Verifikasi/User', [VerifikasiUser::class, 'store'])->name('verifikasi.store');
    Route::get('/Verifikasi/edit/{id}', [VerifikasiUser::class, 'edit'])->name('verifikasi.edit');
    Route::put('/Verifikasi/update/{id}', [VerifikasiUser::class, 'update'])->name('verifikasi.update');
});

Route::middleware('auth', 'admin')->group(function () {
    //admin

    Route::get('/admin/dashboard', [DashboardAdminController::class, 'jumlah'])->name('admin.dashboard');

    Route::get('/kendaraan', [KendaraanController::class, 'tampil'])->name('kendaraan.tampil');
    Route::get('/kendaraan/tambah', function () {
        return view('admin/kendaraan/tambah');
    })->name('kendaraan.tambah');
    Route::post('/kendaraan/submit', [KendaraanController::class, 'submit'])->name('kendaraan.submit');
    Route::get('/kendaraan/edit/{id}', [KendaraanController::class, 'edit'])->name('kendaraan.edit');
    Route::post('/kendaraan/update/{id}', [KendaraanController::class, 'update'])->name('kendaraan.update');
    Route::post('/kendaraan/delete/{id}', [KendaraanController::class, 'delete'])->name('kendaraan.delete');

    Route::get('/admin/pesananData', [pesananController::class, 'tampil'])->name('pesanan.data');
    Route::put('admin/pesanan/updateStatus/{id}', [pesananController::class, 'updateStatus'])->name('pesanan.updateStatus');
    Route::get('/admin/pesanan/detail/{id}', [pesananController::class, 'detail'])->name('pesanan.detail');

    Route::get('admin/validasi', [validasiVerif::class, 'index'])->name('validasi.verifikasi');
    Route::get('admin/validasi/{id}', [validasiVerif::class, 'show'])->name('validasi.verifikasi.detail');
    Route::put('admin/validasi/{id}', [validasiVerif::class, 'update'])->name('validasi.verifikasi.update');

    Route::get('/admin/usersData', [AuthController::class, 'tampil'])->name('users.tampil');
    Route::get('/admin/user_detail/{id}', [AuthController::class, 'userDetail'])->name('users.detail');

    Route::get('/admin/finance', [FinanceController::class, 'dashboard'])->name('finance.dashboard');
    Route::get('/admin/dataPesanan', [FinanceController::class, 'dataPesanan'])->name('finance.dataPesanan');
});
