<?php

namespace App\Filament\Resources\InformasiMahasiswaResource\Pages;

use App\Filament\Resources\InformasiMahasiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInformasiMahasiswa extends EditRecord
{
    protected static string $resource = InformasiMahasiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

}
