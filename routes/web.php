<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\BarangJadiController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DetailPenjualanController;
use App\Http\Controllers\DetailBarangController;
use App\Http\Controllers\DetailPembelianController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Rute untuk halaman utama (index)
Route::get('/', [PageController::class, 'index'])->name('index');

// Rute untuk Autentikasi (Breeze)
require __DIR__.'/auth.php';

// Grup rute yang memerlukan autentikasi
Route::middleware(['auth', 'verified'])->group(function () {
    // Rute untuk halaman home
    Route::get('/home', [PageController::class, 'home'])->name('home');
    Route::get('/dashboard', [PageController::class, 'home'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ===============================================
    //           USER MANAGEMENT (ADMIN ONLY)
    // ===============================================
    Route::resource('users', UserController::class)->middleware('role:admin');

    // ===============================================
    //           1. MASTER DATA (Resourceful)
    // ===============================================
    // Admin: Akses penuh ke semua master data
    // Cashier: Tidak punya akses ke Bahan Baku, Pegawai, Supplier
    Route::group(['middleware' => 'role:admin'], function () {
        Route::resource('bahanbaku', BahanBakuController::class);
        Route::resource('pegawai', PegawaiController::class);
        Route::resource('supplier', SupplierController::class);
    });

    // Admin & Cashier: CRUD access untuk Pelanggan & Kendaraan (MUST BE BEFORE wildcard routes)
    Route::group(['middleware' => 'role:admin,cashier'], function () {
        Route::get('pelanggan/create', [PelangganController::class, 'create'])->name('pelanggan.create');
        Route::post('pelanggan', [PelangganController::class, 'store'])->name('pelanggan.store');
        Route::get('pelanggan/{idpelanggan}/edit', [PelangganController::class, 'edit'])->name('pelanggan.edit');
        Route::put('pelanggan/{idpelanggan}', [PelangganController::class, 'update'])->name('pelanggan.update');
        Route::delete('pelanggan/{idpelanggan}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');

        Route::get('kendaraan/create', [KendaraanController::class, 'create'])->name('kendaraan.create');
        Route::post('kendaraan', [KendaraanController::class, 'store'])->name('kendaraan.store');
        Route::get('kendaraan/{nopol}/edit', [KendaraanController::class, 'edit'])->name('kendaraan.edit');
        Route::put('kendaraan/{nopol}', [KendaraanController::class, 'update'])->name('kendaraan.update');
        Route::delete('kendaraan/{nopol}', [KendaraanController::class, 'destroy'])->name('kendaraan.destroy');
    });

    // Admin & Cashier: Index dan Show untuk Pelanggan & Kendaraan - AFTER specific routes
    Route::group(['middleware' => 'role:admin,cashier'], function () {
        Route::get('pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');
        Route::get('pelanggan/{idpelanggan}', [PelangganController::class, 'show'])->name('pelanggan.show');
        Route::get('kendaraan', [KendaraanController::class, 'index'])->name('kendaraan.index');
        Route::get('kendaraan/{nopol}', [KendaraanController::class, 'show'])->name('kendaraan.show');
    });

    // ===============================================
    //           2. BARANG JADI & KOMPOSISI
    // ===============================================
    // Admin & Cashier: CRUD access untuk Barang Jadi (MUST BE BEFORE wildcard routes)
    Route::group(['middleware' => 'role:admin,cashier'], function () {
        Route::get('barangjadi/create', [BarangJadiController::class, 'create'])->name('barangjadi.create');
        Route::post('barangjadi', [BarangJadiController::class, 'store'])->name('barangjadi.store');
        Route::get('barangjadi/{kodejadi}/edit', [BarangJadiController::class, 'edit'])->name('barangjadi.edit');
        Route::put('barangjadi/{kodejadi}', [BarangJadiController::class, 'update'])->name('barangjadi.update');
        Route::delete('barangjadi/{kodejadi}', [BarangJadiController::class, 'destroy'])->name('barangjadi.destroy');
        Route::get('barangjadi/{kodejadi}/cetak', [BarangJadiController::class, 'cetakKomposisi'])->name('barangjadi.cetak');
    });

    // Admin & Cashier: Index dan Show untuk Barang Jadi - AFTER specific routes
    Route::group(['middleware' => 'role:admin,cashier'], function () {
        Route::get('barangjadi', [BarangJadiController::class, 'index'])->name('barangjadi.index');
        Route::get('barangjadi/{kodejadi}', [BarangJadiController::class, 'show'])->name('barangjadi.show');
    });

    // Admin Only: Detail Barang Jadi (Komposisi Bahan Baku)
    Route::prefix('barangjadi/{kodejadi}')->middleware('role:admin')->group(function () {
        Route::get('detail/create', [DetailBarangController::class, 'create'])->name('barangjadi.detail.create');
        Route::post('detail', [DetailBarangController::class, 'store'])->name('barangjadi.detail.store');
        Route::get('detail/{kodebaku}/edit', [DetailBarangController::class, 'edit'])->name('barangjadi.detail.edit');
        Route::put('detail/{kodebaku}', [DetailBarangController::class, 'update'])->name('barangjadi.detail.update');
        Route::delete('detail/{kodebaku}', [DetailBarangController::class, 'destroy'])->name('barangjadi.detail.destroy');
    });

    // ===============================================
    //           3. TRANSAKSI PENJUALAN
    // ===============================================
    // Admin & Cashier: CRUD access untuk Penjualan
    Route::group(['middleware' => 'role:admin,cashier'], function () {
        Route::resource('penjualan', PenjualanController::class);
        Route::get('/penjualan/{penjualan}/cetak', [PenjualanController::class, 'cetak'])->name('penjualan.cetak');
        
        // Rute Nested untuk Detail Penjualan
        Route::prefix('penjualan/{penjualan}')->group(function () {
            Route::get('/detail/create', [DetailPenjualanController::class, 'create'])->name('penjualan.detail.create');
            Route::post('/detail', [DetailPenjualanController::class, 'store'])->name('penjualan.detail.store'); 
            Route::get('detail/{kodejadi}/edit', [DetailPenjualanController::class, 'edit'])->name('penjualan.detail.edit'); 
            Route::put('detail/{kodejadi}', [DetailPenjualanController::class, 'update'])->name('penjualan.detail.update'); 
            Route::delete('/detail/{kodejadi}', [DetailPenjualanController::class, 'destroy'])->name('penjualan.detail.destroy');
        });
    });

    // ===============================================
    //           4. TRANSAKSI PEMBELIAN (ADMIN ONLY)
    // ===============================================
    Route::group(['middleware' => 'role:admin'], function () {
        Route::resource('pembelian', PembelianController::class);
        Route::get('/pembelian/{pembelian}/cetak', [PembelianController::class, 'cetak'])->name('pembelian.cetak');
        
        // Rute Nested untuk Detail Pembelian
        Route::prefix('pembelian/{pembelian}')->group(function () {
            Route::get('/detail/create', [DetailPembelianController::class, 'create'])->name('pembelian.detail.create');
            Route::post('/detail', [DetailPembelianController::class, 'store'])->name('pembelian.detail.store'); 
            Route::get('detail/{kodebaku}/edit', [DetailPembelianController::class, 'edit'])->name('pembelian.detail.edit'); 
            Route::put('detail/{kodebaku}', [DetailPembelianController::class, 'update'])->name('pembelian.detail.update'); 
            Route::delete('/detail/{kodebaku}', [DetailPembelianController::class, 'destroy'])->name('pembelian.detail.destroy');
        });
    });
});

