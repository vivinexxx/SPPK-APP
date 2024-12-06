<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DataController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Route untuk Kelola Sistem
    Route::get('/data', [DataController::class, 'index'])->name('data.index');
    Route::post('/data', [DataController::class, 'store'])->name('data.store');    
    Route::post('/data', [DataController::class, 'create'])->name('data.create');
    Route::get('/data/{id_data}/edit', [DataController::class, 'edit'])->name('data.edit');
    Route::patch('/data/{id_data}', [DataController::class, 'update'])->name('data.update');
    Route::delete('/data/{id_data}', [DataController::class, 'destroy'])->name('data.destroy');

    // Route untuk Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
