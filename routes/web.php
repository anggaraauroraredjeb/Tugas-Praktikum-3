<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;

Route::get('/form', [DataController::class, 'form']);
Route::post('/proses', [DataController::class, 'proses']);
Route::get('/laporan/buat', [LaporanController::class, 'create'])->name('laporans.create');
Route::post('/laporan', [LaporanController::class, 'store'])->name('laporans.store');

Route::middleware('auth')->group(function () {
	Route::get('/', [LaporanController::class, 'index'])->name('home');
	Route::resource('laporan', LaporanController::class)
		->only(['index', 'show', 'edit', 'update', 'destroy'])
		->names([
			'index' => 'laporans.index',
			'show' => 'laporans.show',
			'edit' => 'laporans.edit',
			'update' => 'laporans.update',
			'destroy' => 'laporans.destroy',
		]);
	Route::get('/profil', [ProfileController::class, 'show'])->name('profile');
});

require __DIR__.'/auth.php';


