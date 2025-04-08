<?php

use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Route;
use Barryvdh\DomPDF\Facade\Pdf;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::get('/register', Register::class)->name('register');
    Route::get('/forgot-password', PasswordReset::class)->name('password.request');
});

Route::get('/export/mahasiswa/pdf', function () {
    $mahasiswas = Mahasiswa::all();

    $pdf = Pdf::loadView('exports.mahasiswa', compact('mahasiswas'));

    return $pdf->download('data-mahasiswa.pdf');
})->name('export.mahasiswa.pdf');
