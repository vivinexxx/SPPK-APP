<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\AnalisisController;
use App\Http\Controllers\SearchController;
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
    Route::put('/data/{id_data}', [DataController::class, 'update'])->name('data.update');
    Route::delete('/data/{id_data}', [DataController::class, 'destroy'])->name('data.destroy'); // Menghapus data
    Route::put('/data/{id_data}', [DataController::class, 'update'])->name('data.update');

    // rute untuk analisis
    Route::get('/analisis', [AnalisisController::class, 'index'])->name('analisis.index'); // Menampilkan data

    // Rute untuk Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/search', [SearchController::class, 'index'])->name('search.index');
    Route::post('/search/result', [SearchController::class, 'searchResult'])->name('search.result');
// Route untuk hasil pencarian
Route::get('/keputusan', [SearchController::class, 'searchResult'])->name('keputusan.result');
});

// Memuat file autentikasi
require __DIR__ . '/auth.php';