<?php

use App\Http\Controllers\CoaController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/coa', [CoaController::class, 'index'])->name('coa.index');
    Route::post('/logout/sb', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout.sb');
    Route::get('/coa/create', [CoaController::class, 'create'])->name('coa.create');
    Route::post('/coa', [CoaController::class, 'store'])->name('coa.store');
    Route::get('/coa/{id}/edit', [CoaController::class, 'edit'])->name('coa.edit');
    Route::put('/coa/{id}', [CoaController::class, 'update'])->name('coa.update');
    Route::delete('/coa/{id}', [CoaController::class, 'destroy'])->name('coa.destroy');
    
    Route::get('/obat', [ObatController::class, 'index'])->name('obat.index');
    Route::post('/obat', [ObatController::class, 'store'])->name('obat.store');
    Route::get('/obat/create', [ObatController::class, 'create'])->name('obat.create');
    Route::post('/obat', [ObatController::class, 'store'])->name('obat.store');
    Route::get('/obat/{id}/edit', [ObatController::class, 'edit'])->name('obat.edit');
    Route::put('/obat/{id}', [ObatController::class, 'update'])->name('obat.update');
    Route::delete('/obat/{id}', [ObatController::class, 'destroy'])->name('obat.destroy');

    Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::post('/penjualan', [ObatController::class, 'store'])->name('penjualan.store');
    Route::get('/penjualan/create', [PenjualanController::class, 'create'])->name('obat.create') ;
    Route::post('/penjualan', [PenjualanController::class, 'store'])->name('penjualan.store');

    
});


require __DIR__ . '/auth.php';
