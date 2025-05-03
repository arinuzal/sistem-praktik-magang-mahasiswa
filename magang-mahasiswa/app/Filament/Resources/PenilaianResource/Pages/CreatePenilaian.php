<?php

namespace App\Filament\Resources\PenilaianResource\Pages;

use App\Filament\Resources\PenilaianResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Mail\NilaiPraktikMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class CreatePenilaian extends CreateRecord
{
    protected static string $resource = PenilaianResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['nilai_akhir'] = $this->hitungNilaiAkhir($data);
        return $data;
    }

    private function hitungNilaiAkhir(array $data): float
    {
        $nilaiMagang = $data['nilai_magang'] ?? 0;
        $nilaiMediasi = $data['nilai_mediasi'] ?? 0;
        $nilaiVideo = $data['nilai_video_mediasi'] ?? 0;
        $nilaiPenyuluhan = $data['nilai_penyuluhan'] ?? 0;

        return round(($nilaiMagang + $nilaiMediasi + $nilaiVideo + $nilaiPenyuluhan) / 4, 2);
    }

    protected function afterCreate(): void
    {
        $penilaian = $this->record;
        if (!$penilaian->dosen_id) {
            \Log::warning('dosen_id kosong saat pengisian penilaian ID: ' . $penilaian->id);
        }
        $dosen = User::find($penilaian->dosen_id);
        if ($dosen && $dosen->email) {
            Mail::to($dosen->email)->send(new NilaiPraktikMail($penilaian));
        }
    }
}
