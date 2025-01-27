<?php

use App\Http\Controllers\CoaController;
use App\Http\Controllers\ObatController;
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

});


require __DIR__ . '/auth.php';
