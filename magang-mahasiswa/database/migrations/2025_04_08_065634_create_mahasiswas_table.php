<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama');
            $table->string('nim')->unique();
            $table->string('semester');
            $table->json('mata_kuliah');
            $table->string('bukti_pembayaran');
            $table->string('bukti_krs');
            $table->string('status_dokumen')->default('belum dikonfirmasi');
            $table->string('status_magang')->default('belum magang');
            $table->float('nilai_magang')->nullable();
            $table->float('kelompok')->nullable();
            $table->string('video_mediasi')->nullable();
            $table->string('video_penyuluhan')->nullable();
            $table->boolean('ceklis_penyuluhan')->default(false);
            $table->boolean('ceklis_artikel')->default(false);
            $table->boolean('is_luar_biasa')->default(false);
            $table->string('link_artikel')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
