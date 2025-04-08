<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TempatMagangResource\Pages;
use App\Models\TempatMagang;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;

class TempatMagangResource extends Resource
{
    protected static ?string $model = TempatMagang::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationGroup = 'Users';

    public static function canAccess(): bool
    {
        return auth()->user()?->role === 'super admin';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('user_id')
                ->label('User')
                ->relationship('user', 'name')
                ->searchable()
                ->required(),

            Forms\Components\TextInput::make('nama_instansi')
                ->label('Nama Instansi')
                ->required(),

            Forms\Components\TextInput::make('alamat')
                ->required(),

            Forms\Components\TextInput::make('kontak')
                ->required(),

            Forms\Components\TextInput::make('bidang_usaha')
                ->label('Bidang Usaha')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
        Tables\Columns\TextColumn::make('user.name')->label('User')->searchable(),
            Tables\Columns\TextColumn::make('nama_instansi')->searchable(),
            Tables\Columns\TextColumn::make('alamat')->searchable()->limit(30),
            Tables\Columns\TextColumn::make('kontak')->searchable(),
            Tables\Columns\TextColumn::make('bidang_usaha')->searchable(),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->since(),
        ])
        ->filters([
            SelectFilter::make('bidang_usaha')
            ->label('Bidang Usaha')
            ->options([
                'Teknologi Informasi' => 'Teknologi Informasi',
                'Konsultan Hukum' => 'Konsultan Hukum',
                'Keuangan' => 'Keuangan',
            ]),
        Filter::make('nama_instansi')
            ->query(fn ($query, $data) => $query->where('nama_instansi', 'like', "%{$data['value']}%"))
            ->form([
                Forms\Components\TextInput::make('value')
                    ->label('Nama Instansi')
                    ->placeholder('Cari Nama Instansi'),
            ]),
        ])
        ->defaultSort('created_at', 'desc')
        ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ])
        ->headerActions([
            Action::make('Export PDF')
                ->url(route('export.mahasiswa.pdf'))
                ->openUrlInNewTab()
                ->icon('heroicon-o-document-arrow-down'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTempatMagangs::route('/'),
            'create' => Pages\CreateTempatMagang::route('/create'),
            'edit' => Pages\EditTempatMagang::route('/{record}/edit'),
        ];
    }
}
