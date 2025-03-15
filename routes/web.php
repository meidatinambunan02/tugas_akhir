<?php

// Import semua controller yang digunakan dalam routing
use App\Http\Controllers\CoaController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LaporanPenjualanController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiLainController;
use App\Models\TransaksiLain;
use Illuminate\Support\Facades\Route;

// ====================================
// Route untuk halaman utama (login)
// ====================================
Route::get('/', function () {
    return view('auth.login'); // Menampilkan halaman login
});

// ====================================
// Group route dengan middleware 'auth' dan 'verified'
// Hanya bisa diakses jika pengguna sudah login dan email terverifikasi
// ====================================
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// ====================================
// Group route dengan middleware 'auth'
// Semua route di dalam group ini memerlukan autentikasi
// ====================================
Route::middleware('auth')->group(function () {

    // ====================================
    // Route COA (Chart of Account)
    // ====================================
    Route::get('/coa', [CoaController::class, 'index'])->name('coa.index'); // Menampilkan daftar COA
    Route::get('/coa/create', [CoaController::class, 'create'])->name('coa.create'); // Form tambah COA
    Route::post('/coa', [CoaController::class, 'store'])->name('coa.store'); // Menyimpan data COA baru
    Route::get('/coa/{id}/edit', [CoaController::class, 'edit'])->name('coa.edit'); // Form edit COA
    Route::put('/coa/{id}', [CoaController::class, 'update'])->name('coa.update'); // Mengupdate data COA
    Route::delete('/coa/{id}', [CoaController::class, 'destroy'])->name('coa.destroy'); // Menghapus data COA

    // ====================================
    // Route untuk logout
    // ====================================
    Route::post('/logout/sb', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout.sb'); // Proses logout pengguna

    // ====================================
    // Route Obat
    // ====================================
    Route::get('/obat', [ObatController::class, 'index'])->name('obat.index'); // Menampilkan daftar obat
    Route::get('/obat/create', [ObatController::class, 'create'])->name('obat.create'); // Form tambah obat
    Route::post('/obat', [ObatController::class, 'store'])->name('obat.store'); // Menyimpan data obat baru
    Route::get('/obat/{id}/edit', [ObatController::class, 'edit'])->name('obat.edit'); // Form edit obat
    Route::put('/obat/{id}', [ObatController::class, 'update'])->name('obat.update'); // Mengupdate data obat
    Route::delete('/obat/{id}', [ObatController::class, 'destroy'])->name('obat.destroy'); // Menghapus data obat

    // ====================================
    // Route Penjualan
    // ====================================
    Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index'); // Menampilkan daftar penjualan
    Route::get('/penjualan/create', [PenjualanController::class, 'create'])->name('penjualan.create'); // Form tambah penjualan
    Route::post('/penjualan', [PenjualanController::class, 'store'])->name('penjualan.store'); // Menyimpan data penjualan baru
    Route::get('/penjualan/{id}', [PenjualanController::class, 'show'])->name('penjualan.show'); // Menampilkan detail penjualan
    Route::get('/penjualan/{id}/edit', [PenjualanController::class, 'edit'])->name('penjualan.edit'); // Form edit penjualan
    Route::put('/penjualan/{id}', [PenjualanController::class, 'update'])->name('penjualan.update'); // Mengupdate data penjualan
    Route::delete('/penjualan/{id}', [PenjualanController::class, 'destroy'])->name('penjualan.destroy'); // Menghapus data penjualan
    Route::post('/penjualan/add-to-cart', [PenjualanController::class, 'addToCart'])->name('penjualan.addToCart'); // Menambahkan item ke keranjang

    // ====================================
    // Route Pelanggan
    // ====================================
    Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index'); // Menampilkan daftar pelanggan
    Route::get('/pelanggan/create', [PelangganController::class, 'create'])->name('pelanggan.create'); // Form tambah pelanggan
    Route::post('/pelanggan', [PelangganController::class, 'store'])->name('pelanggan.store'); // Menyimpan data pelanggan baru
    Route::get('/pelanggan/{id}', [PelangganController::class, 'show'])->name('pelanggan.show'); // Menampilkan detail pelanggan
    Route::get('/pelanggan/{id}/edit', [PelangganController::class, 'edit'])->name('pelanggan.edit'); // Form edit pelanggan
    Route::put('/pelanggan/{id}', [PelangganController::class, 'update'])->name('pelanggan.update'); // Mengupdate data pelanggan
    Route::delete('/pelanggan/{id}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy'); // Menghapus data pelanggan

    // ====================================
    // Route Laporan
    // ====================================
    Route::get('/laporan/laba-rugi', [LaporanController::class, 'labaRugi'])->name('laporan.laba-rugi'); // Menampilkan laporan laba rugi
    Route::get('/laporan/laba-rugi/export', [LaporanController::class, 'exportLabaRugi'])->name('laporan.laba-rugi.export'); // Export laporan laba rugi
    Route::get('/laporan/penjualan', [LaporanPenjualanController::class, 'index'])->name('laporan.penjualan'); // Menampilkan laporan penjualan
    Route::get('/laporan/penjualan/export', [LaporanPenjualanController::class, 'export'])->name('laporan.penjualan.export'); // Export laporan penjualan

    // ====================================
    // Route Jurnal
    // ====================================
    Route::get('/jurnal', [JurnalController::class, 'index'])->name('jurnal.index'); // Menampilkan daftar jurnal umum
    Route::get('/jurnal/buku-besar', [JurnalController::class, 'bukuBesar'])->name('jurnal.buku-besar'); // Menampilkan buku besar

    // ====================================
    // Route Transaksi Lain
    // ====================================
    Route::get('/transaksi/lain', [TransaksiLainController::class, 'index'])->name('transaksi.index'); // Menampilkan daftar transaksi lain
    Route::post('/transaksi/lain', [TransaksiLainController::class, 'store'])->name('transaksi-lain.store'); // Menyimpan data transaksi lain

});

// ====================================
// Route untuk autentikasi
// ====================================
require __DIR__ . '/auth.php'; // Mengimpor route default untuk login, register, dll.
