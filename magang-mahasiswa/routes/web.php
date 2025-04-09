<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\TempatMagangController;
use Illuminate\Support\Facades\Route;
use App\Models\Mahasiswa;
use Barryvdh\DomPDF\Facade\Pdf;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/pendaftaran-mahasiswa', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
    Route::post('/pendaftaran-mahasiswa', [MahasiswaController::class, 'store'])->name('mahasiswa.store');

    Route::middleware(['check.pendaftaran.mahasiswa'])->group(function () {
        Route::get('/dashboard/mahasiswa', [MahasiswaController::class, 'dashboard'])->name('mahasiswa.dashboard');
    });
});

Route::post('/mahasiswa/set-luar-biasa', [MahasiswaController::class, 'setSebagaiLuarBiasa'])->name('mahasiswa.setLuarBiasa');
Route::post('/mahasiswa/luar-biasa/upload-artikel', [MahasiswaController::class, 'uploadLinkArtikel'])->name('mahasiswa.uploadLinkArtikel');

Route::post('/mahasiswa/ceklis', [MahasiswaController::class, 'updateCeklis'])->name('mahasiswa.updateCeklis');
Route::get('/sertifikat', [MahasiswaController::class, 'generateSertifikat'])->name('mahasiswa.cetak-sertifikat');
Route::post('/mahasiswa/upload-video', [MahasiswaController::class, 'uploadVideo'])->name('mahasiswa.upload.video');

Route::middleware(['auth'])->group(function () {
    Route::get('/tempat-magang/mahasiswa', [TempatMagangController::class, 'mahasiswaMagang'])->name('tempatMagang.mahasiswa');
    Route::get('/tempat-magang/mahasiswa/export', [TempatMagangController::class, 'exportPdf'])->name('mahasiswa.export.pdf');
});

Route::get('/export/mahasiswa/pdf', function () {
    $mahasiswas = Mahasiswa::all();

    $pdf = Pdf::loadView('exports.mahasiswa', compact('mahasiswas'));

    return $pdf->download('data-mahasiswa.pdf');
})->name('export.mahasiswa.pdf');

require __DIR__.'/auth.php';
