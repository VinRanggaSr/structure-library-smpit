<?php

use App\Http\Controllers\Admin\AturanController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ItemBukuController;
use App\Http\Controllers\Admin\JenisDendaController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Petugas\DendaController;
use App\Http\Controllers\Petugas\PeminjamanController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'pilihPeran'])->name('pilih-peran');
Route::get('login/{peran}', [AuthController::class, 'create'])->name('login');
Route::post('login/{peran}', [AuthController::class, 'store'])->name('login.store');
Route::post('logout', [AuthController::class, 'destroy'])->name('logout');

Route::prefix('admin')->name('admin.')->middleware('contoh-pengguna:Superadmin')->group(function () {
    Route::redirect('/', '/admin/dashboard');
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::resource('buku', BukuController::class)
        ->parameters(['buku' => 'buku'])
        ->names('buku');
    Route::resource('buku.item', ItemBukuController::class)
        ->only(['store', 'update', 'destroy'])
        ->parameters(['buku' => 'buku', 'item' => 'itemBuku'])
        ->names('buku.item');

    Route::resource('kategori', KategoriController::class)->except(['create', 'edit', 'show']);
    Route::resource('siswa', SiswaController::class)->except(['create', 'edit', 'show']);
    Route::post('siswa/impor', [SiswaController::class, 'impor'])->name('siswa.impor');
    Route::resource('pengguna', PenggunaController::class)->except(['create', 'edit', 'show']);
    Route::resource('jenis-denda', JenisDendaController::class)
        ->except(['create', 'edit', 'show'])
        ->parameters(['jenis-denda' => 'jenisDenda']);
    Route::resource('aturan', AturanController::class)->except(['create', 'edit', 'show']);
});

Route::prefix('petugas')->name('petugas.')->middleware('contoh-pengguna:Penjaga')->group(function () {
    Route::redirect('/', '/petugas/peminjaman');

    Route::resource('peminjaman', PeminjamanController::class)->parameters(['peminjaman' => 'peminjaman']);
    Route::patch('peminjaman/{peminjaman}/kembalikan', [PeminjamanController::class, 'kembalikan'])
        ->name('peminjaman.kembalikan');

    Route::resource('denda', DendaController::class)->except(['create', 'edit', 'show']);
});
