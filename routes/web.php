<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;

Route::get('/', function () {
    return view('login');
});
// login auth
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('/logout',  [AuthController::class, 'logout'])->name('logout');
// redirect login
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::get('/petugas/dashboard', function () {
    return view('petugas.dashboard');
})->name('petugas.dashboard');

// redirect admin
Route::get('/admin/barang', function () {
    return view('admin.barang');
})->name('barang');

Route::get('/admin/member', function () {
    return view('admin.member');
})->name('member');

Route::get('/admin/petugas', function () {
    return view('admin.petugas');
})->name('petugas');

Route::get('/admin/laporan', function () {
    return view('admin.laporan');
})->name('laporan');

Route::get('/jual', [PetugasController::class, 'jual'])->name('jual');
Route::post('/updateHarga', [PetugasController::class, 'updateHarga'])->name('updateHarga');


// dashboard
Route::get('/petugas/dashboard', [PetugasController::class, 'dashboard'])->name('petugas.dashboard');
Route::post('/petugas/dashboard', [PetugasController::class, 'store'])->name('insert_member');
// Route::post('/petugas/dashboard', [PetugasController::class, 'member'])->name('member_view');
Route::post('/cari_barang', [PetugasController::class, 'cari_barang'])->name('cari_barang');
Route::post('/ambil_barang', [PetugasController::class, 'ambil_barang'])->name('ambil_barang');
Route::post('/tambahData', [PetugasController::class, 'tambahData'])->name('tambahData');
Route::post('/hapus', [BarangController::class, 'destroy'])->name('hapus_barang');



// barang
Route::get('/admin/barang', [BarangController::class, 'index'])->name('barang');
Route::post('/admin/barang', [BarangController::class, 'store'])->name('tambah_barang');
Route::post('admin/barang/delete', [BarangController::class, 'destroy'])->name('hapus_barang');
Route::put('admin/barang/{id}', [BarangController::class, 'update'])->name('update_barang');
Route::get('/export_excel', [BarangController::class, 'export'])->name('export_excel');
Route::get('/cetak-pdf', [BarangController::class, 'cetak_pdf'])->name('cetak_pdf');



// member
Route::get('/admin/member', [MemberController::class, 'index'])->name('member');
Route::post('/admin/member', [MemberController::class, 'store'])->name('tambah_member');
Route::post('admin/member/delete', [MemberController::class, 'destroy'])->name('hapus_member');
Route::put('admin/member/{id_member}', [MemberController::class, 'update'])->name('update_member');
Route::post('admin/member/update-diskon', [MemberController::class, 'updateDiskon'])->name('update_diskon_member');

// petugas
Route::get('/admin/petugas', [UserController::class, 'index'])->name('petugas');
Route::post('/admin/petugas', [UserController::class, 'store'])->name('tambah_petugas');
Route::post('admin/petugas/delete', [UserController::class, 'destroy'])->name('hapus_petugas');
Route::put('admin/petugas/{id_petugas}', [UserController::class, 'update'])->name('update_petugas');

// laporan
Route::get('/admin/laporan', [LaporanController::class, 'index'])->name('laporan');

