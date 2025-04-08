<?php

namespace App\Filament\Resources\TempatMagangResource\Pages;

use App\Filament\Resources\TempatMagangResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTempatMagang extends EditRecord
{
    protected static string $resource = TempatMagangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
