<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\TempatMagangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InternshipController;
use Illuminate\Support\Facades\Route;
use App\Models\Mahasiswa;
use Barryvdh\DomPDF\Facade\Pdf;



Route::get('/', [HomeController::class, 'home'])->name('home');

Route::prefix('praktik-profesional')->group(function () {
    Route::get('/ganjil', [InternshipController::class, 'odd'])->name('internship.odd');
    Route::get('/genap', [InternshipController::class, 'even'])->name('internship.even');
});

Route::middleware(['auth', 'role.strict'])->group(function () {
    Route::get('/dashboard', function () {
        return view('home');
    })->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// MAHASISWA
Route::middleware(['auth', 'role.strict:mahasiswa', 'prevent.back.history'])->group(function () {
    Route::middleware(['mahasiswa.already.registered'])->group(function () {
        Route::get('/pendaftaran-mahasiswa', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
        Route::post('/pendaftaran-mahasiswa', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
    });

    Route::middleware(['check.pendaftaran.mahasiswa'])->group(function () {
        Route::get('/dashboard/mahasiswa', [MahasiswaController::class, 'dashboard'])->name('mahasiswa.dashboard');

        Route::post('/mahasiswa/set-luar-biasa', [MahasiswaController::class, 'setSebagaiLuarBiasa'])->name('mahasiswa.setLuarBiasa');
        Route::post('/mahasiswa/luar-biasa/upload-artikel', [MahasiswaController::class, 'uploadLinkArtikel'])->name('mahasiswa.uploadLinkArtikel');
        Route::post('/mahasiswa/ceklis', [MahasiswaController::class, 'updateCeklis'])->name('mahasiswa.updateCeklis');
        Route::get('/sertifikat', [MahasiswaController::class, 'generateSertifikat'])->name('mahasiswa.cetak-sertifikat');
        Route::post('/mahasiswa/upload-video', [MahasiswaController::class, 'uploadVideo'])->name('mahasiswa.upload.video');
        Route::post('/mahasiswa/upload-pdf', [MahasiswaController::class, 'uploadPdf'])->name('mahasiswa.upload.pdf');
    });
});

// TEMPAT MAGANG
Route::middleware(['auth', 'role.strict:tempat magang', 'prevent.back.history'])->group(function () {
    Route::get('/tempat-magang/mahasiswa', [TempatMagangController::class, 'mahasiswaMagang'])->name('tempatMagang.mahasiswa');
    Route::get('/tempat-magang/mahasiswa/export', [TempatMagangController::class, 'exportPdf'])->name('mahasiswa.export.pdf');
});

// EXPORT DATA MAHASISWA
Route::middleware(['auth', 'role.strict:admin,super admin'])->group(function () {
    Route::get('/export/mahasiswa/pdf', function () {
        $mahasiswas = Mahasiswa::all();
        $pdf = Pdf::loadView('exports.mahasiswa', compact('mahasiswas'));
        return $pdf->download('data-mahasiswa.pdf');
    })->name('export.mahasiswa.pdf');
});

require __DIR__.'/auth.php';
