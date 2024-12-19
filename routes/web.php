<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DataController;
use Illuminate\Support\Facades\Route;

/*
|----------------------------------------------------------------------
| Web Routes
|----------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them
| will be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Rute Dashboard (Hanya dapat diakses oleh pengguna yang terautentikasi)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Rute yang membutuhkan autentikasi pengguna
Route::middleware('auth')->group(function () {

    // Rute untuk Kelola Data
    Route::get('/data', [DataController::class, 'index'])->name('data.index'); // Menampilkan data
    Route::get('/data/create', [DataController::class, 'create'])->name('data.create'); // Menampilkan form tambah data
    Route::post('/data', [DataController::class, 'store'])->name('data.store'); // Menyimpan data
    Route::get('/data/{id_data}/edit', [DataController::class, 'edit'])->name('data.update');

    Route::patch('/data/{id_data}', [DataController::class, 'update'])->name('data.update'); // Mengupdate data
    Route::delete('/data/{id_data}', [DataController::class, 'destroy'])->name('data.destroy'); // Menghapus data

    // Rute untuk Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Memuat file autentikasi
require __DIR__ . '/auth.php';