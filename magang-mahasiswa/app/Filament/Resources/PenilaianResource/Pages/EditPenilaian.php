<?php

namespace App\Filament\Resources\PenilaianResource\Pages;

use App\Filament\Resources\PenilaianResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPenilaian extends EditRecord
{
    protected static string $resource = PenilaianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
{
    $data['nilai_akhir'] = $this->hitungNilaiAkhir($data);
    return $data;
}

protected function mutateFormDataBeforeSave(array $data): array
{
    $data['nilai_akhir'] = $this->hitungNilaiAkhir($data);
    return $data;
}

private function hitungNilaiAkhir(array $data): float
{
    $nilaiMagang = $data['nilai_magang'] ?? 0;
    $nilaiVideo = $data['nilai_video_mediasi'] ?? 0;
    $nilaiPenyuluhan = $data['nilai_penyuluhan'] ?? 0;

    return round(($nilaiMagang + $nilaiVideo + $nilaiPenyuluhan) / 3, 2);
}
}
