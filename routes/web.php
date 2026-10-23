<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;

Route::middleware('guest')->group(function () {
	Route::get('/register', [RegisterController::class, 'create'])->name('register');
	Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
	Route::get('/login', [LoginController::class, 'create'])->name('login');
	Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

Route::get('/form', [DataController::class, 'form']);
Route::post('/proses', [DataController::class, 'proses']);
Route::get('/laporan/buat', [\App\Http\Controllers\LaporanController::class, 'create'])->name('laporans.create');
Route::post('/laporan', [\App\Http\Controllers\LaporanController::class, 'store'])->name('laporans.store');

Route::middleware('auth')->group(function () {
	Route::get('/', [\App\Http\Controllers\LaporanController::class, 'index'])->name('home');
	Route::get('/laporan', [\App\Http\Controllers\LaporanController::class, 'index'])->name('laporans.index');
	Route::get('/laporan/{id}', [\App\Http\Controllers\LaporanController::class, 'show'])->whereNumber('id')->name('laporans.show');
	Route::get('/profil', [ProfileController::class, 'show'])->name('profile');
});


