<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Support\Facades\FilamentIcon;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.dashboard';

    protected static ?int $navigationSort = -2;

    protected ?string $heading = 'Dashboard';

    protected static ?string $slug = 'dashboard';

    protected static ?string $navigationLabel = 'Dashboard';

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public function getTitle(): string
    {
        return 'Dashboard';
    }

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
