<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenilaianResource\Pages;
use App\Models\Penilaian;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Filament\Forms\Components\Select;

class PenilaianResource extends Resource
{
    protected static ?string $model = Penilaian::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Penilaian';

    public static function canAccess(): bool
    {
        return in_array(auth()->user()?->role, ['admin', 'super admin']);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('mahasiswa_id')
                ->relationship('mahasiswa', 'nama')
                ->required(),

            Forms\Components\TextInput::make('nilai_magang')
                ->numeric()
                ->required(),

                Forms\Components\TextInput::make('video_mediasi')
                ->label('Link Video Mediasi')
                ->url()
                ->required(),

            Forms\Components\TextInput::make('nilai_video_mediasi')
                ->numeric(),

                Forms\Components\TextInput::make('penyuluhan_perizinan')
                ->label('Link Penyuluhan Perizinan')
                ->url()
                ->required(),

            Forms\Components\TextInput::make('nilai_penyuluhan')
                ->numeric(),

            Forms\Components\TextInput::make('nilai_akhir')
                ->disabled()
                ->dehydrated(false)
                ->label('Nilai Akhir (otomatis)'),

                Forms\Components\Select::make('dosen_id')
                ->label('Dosen Pembimbing')
                ->options(User::where('role', 'dosen')->pluck('name', 'id'))
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mahasiswa.nama')->label('Mahasiswa'),
                Tables\Columns\TextColumn::make('nilai_magang'),
                Tables\Columns\TextColumn::make('nilai_penyuluhan'),
                Tables\Columns\TextColumn::make('nilai_akhir'),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPenilaians::route('/'),
            'create' => Pages\CreatePenilaian::route('/create'),
            'edit' => Pages\EditPenilaian::route('/{record}/edit'),
        ];
    }
}
