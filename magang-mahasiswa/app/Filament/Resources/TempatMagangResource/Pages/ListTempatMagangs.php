<?php

namespace App\Filament\Resources\TempatMagangResource\Pages;

use App\Filament\Resources\TempatMagangResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTempatMagangs extends ListRecords
{
    protected static string $resource = TempatMagangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
