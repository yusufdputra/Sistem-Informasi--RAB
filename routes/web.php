<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\CetakController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\RabController;
use App\Http\Controllers\RabTempController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\SuplierController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'auth'])->name('/');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// admin

Route::group(['middleware' => ['role:admin']], function () {
    // user management

    Route::get('/user', [UserManagementController::class, 'index'])->name('user.index');
    Route::POST('/user/store', [UserManagementController::class, 'store'])->name('user.store');
    Route::get('/user/edit/{id}', [UserManagementController::class, 'edit'])->name('user/edit');
    Route::POST('/user/edit', [UserManagementController::class, 'update'])->name('user.update');
    Route::post('/user/hapus', [UserManagementController::class, 'hapus'])->name('user.hapus');
    Route::post('/user/resetpw', [UserManagementController::class, 'resetpw'])->name('user.resetpw');

    // kelola kategori
    Route::post('/kategori/store', [KategoriController::class, 'store'])->name('kategori.store');
    Route::POST('/kategori/edit', [KategoriController::class, 'update'])->name('kategori.update');
    Route::POST('/kategori/hapus/', [KategoriController::class, 'hapus'])->name('kategori.hapus');

    // kelola barang
    Route::post('/barang/store', [BarangController::class, 'store'])->name('barang.store');
    Route::get('/barang/edit/{id}', [BarangController::class, 'edit'])->name('barang/edit');
    Route::POST('/barang/update/', [BarangController::class, 'update'])->name('barang.update');
    Route::POST('/barang/hapus/', [BarangController::class, 'hapus'])->name('barang.hapus');

    // kelola suplier
    Route::post('/suplier/store', [SuplierController::class, 'store'])->name('suplier.store');
    Route::get('/suplier/edit/{id}', [SuplierController::class, 'edit'])->name('suplier/edit');
    Route::POST('/suplier/update/', [SuplierController::class, 'update'])->name('suplier.update');
    Route::POST('/suplier/hapus/', [SuplierController::class, 'hapus'])->name('suplier.hapus');

    // kelola rab
    Route::get('/rab', [RabController::class, 'index'])->name('rab.index');
    Route::get('/rab/edit/{id}', [RabController::class, 'edit'])->name('rab.edit');

    Route::get('/rab/selesai/{id}', [RabController::class, 'selesai'])->name('rab.selesai');
    Route::post('/rab/acc', [RabController::class, 'acc'])->name('rab.acc');
    Route::POST('/rab/delete/', [RabController::class, 'hapus'])->name('rab.delete');



    // kelola edit rab
    Route::POST('/rab/edit/selesai/', [RabController::class, 'editSelesai'])->name('rab.edit.selesai');
    Route::POST('/rab/edit/update/', [RabController::class, 'editUpdate'])->name('rab.edit.update');
    Route::post('/rab/edit/store', [RabController::class, 'editStore'])->name('rab.edit.store');
    Route::POST('/rab/hapus/', [RabController::class, 'editHapus'])->name('rab.edit.hapus');

    // kelola rab temp
    Route::get('/rabtemp', [RabTempController::class, 'index'])->name('rabtemp.index');
    Route::post('/rabtemp/store', [RabTempController::class, 'store'])->name('rabtemp.store');
    Route::get('/rabtemp/edit/{id}', [RabTempController::class, 'edit'])->name('rabtemp/edit');
    Route::POST('/rabtemp/update/', [RabTempController::class, 'update'])->name('rabtemp.update');
    Route::POST('/rabtemp/hapus/', [RabTempController::class, 'hapus'])->name('rabtemp.hapus');
    Route::POST('/rabtemp/selesai/', [RabTempController::class, 'selesai'])->name('rabtemp.selesai');

    // kelola ajax
    Route::get('/GetBarangByKategori/{id}', [AjaxController::class, 'GetBarangByKategori'])->name('GetBarangByKategori');
    Route::get('/GetSuplierByNamaBarang/{nama}', [AjaxController::class, 'GetSuplierByNamaBarang'])->name('GetSuplierByNamaBarang');
    Route::get('/GetBarangById/{id}', [AjaxController::class, 'GetBarangById'])->name('GetBarangById');
});

Route::group(['middleware' => ['role:admin|pimpinan']], function () {
    // kelola kategori
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');

    // kelola barang
    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');

    // kelola suplier
    Route::get('/suplier', [SuplierController::class, 'index'])->name('suplier.index');

    // kelola riwayat rab
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');

    // detail rab
    Route::get('/rab/detail/{id}', [RabController::class, 'detail'])->name('rab.detail');

    // kelola cetak
    Route::get('/rab/cetak/{id}', [CetakController::class, 'cetakItemRab'])->name('rab.cetak');
    Route::get('/rab/cetakPO', [CetakController::class, 'cetakPO'])->name('rab.cetakPO');
    Route::get('/rab/cetakDO/{id}', [CetakController::class, 'cetakDO'])->name('rab.cetakDO');
});
