<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;

Route::get('/form', [DataController::class, 'form']);
Route::post('/proses', [DataController::class, 'proses']);

Route::get('/laporan', [\App\Http\Controllers\LaporanController::class, 'index'])->name('laporans.index');
Route::get('/laporan/buat', [\App\Http\Controllers\LaporanController::class, 'create'])->name('laporans.create');
Route::post('/laporan', [\App\Http\Controllers\LaporanController::class, 'store'])->name('laporans.store');
Route::get('/laporan/{id}', [\App\Http\Controllers\LaporanController::class, 'show'])->whereNumber('id')->name('laporans.show');

    
