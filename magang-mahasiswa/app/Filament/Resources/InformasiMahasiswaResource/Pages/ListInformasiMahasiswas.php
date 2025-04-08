<?php

namespace App\Filament\Resources\InformasiMahasiswaResource\Pages;

use App\Filament\Resources\InformasiMahasiswaResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;

class ListInformasiMahasiswas extends ListRecords
{
    protected static string $resource = InformasiMahasiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Export PDF')
                ->url(route('export.mahasiswa.pdf'))
                ->openUrlInNewTab()
                ->icon('heroicon-o-document-arrow-down'),
        ];
    }
}
