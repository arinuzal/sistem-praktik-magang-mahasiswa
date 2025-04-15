<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenilaianResource\Pages;
use App\Models\Penilaian;
use App\Models\User;
use App\Models\Mahasiswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

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
                ->label('Mahasiswa (NIM)')
                ->relationship('mahasiswa', 'nim')
                ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->nim} - {$record->nama}")
                ->searchable(['nim', 'nama'])
                ->required()
                ->live()
                ->afterStateUpdated(function ($state, Set $set) {
                    if (!$state) {
                        $set('video_mediasi', null);
                        $set('penyuluhan_perizinan', null);
                        return;
                    }

                    $mahasiswa = Mahasiswa::find($state);
                    if ($mahasiswa) {
                        $set('video_mediasi', $mahasiswa->video_mediasi);
                        $set('penyuluhan_perizinan', $mahasiswa->video_penyuluhan);
                    }
                }),

            Forms\Components\TextInput::make('nilai_magang')
                ->numeric()
                ->minValue(0)
                ->maxValue(100)
                ->required(),

            Forms\Components\TextInput::make('video_mediasi')
                ->label('Link Video Mediasi')
                ->columnSpanFull()
                ->disabled()
                ->reactive()
                ->afterStateHydrated(function ($state, $record, Set $set) {
                    if ($record && $record->mahasiswa) {
                        $set('video_mediasi', $record->mahasiswa->video_mediasi);
                    }
                }),

            Forms\Components\TextInput::make('nilai_video_mediasi')
                ->numeric()
                ->minValue(0)
                ->maxValue(100),

            Forms\Components\TextInput::make('penyuluhan_perizinan')
                ->label('Link Penyuluhan Perizinan')
                ->columnSpanFull()
                ->disabled()
                ->reactive()
                ->afterStateHydrated(function ($state, $record, Set $set) {
                    if ($record && $record->mahasiswa) {
                        $set('penyuluhan_perizinan', $record->mahasiswa->video_penyuluhan);
                    }
                }),

            Forms\Components\TextInput::make('nilai_penyuluhan')
                ->numeric()
                ->minValue(0)
                ->maxValue(100),

            Forms\Components\TextInput::make('nilai_akhir')
                ->numeric()
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
                Tables\Columns\TextColumn::make('mahasiswa.nim')->label('NIM')->searchable(),
                Tables\Columns\TextColumn::make('mahasiswa.nama')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('nilai_magang')->label('Nilai Magang'),
                Tables\Columns\TextColumn::make('nilai_penyuluhan')->label('Nilai Penyuluhan'),
                Tables\Columns\TextColumn::make('nilai_akhir')->label('Nilai Akhir'),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y')->label('Tanggal'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
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
