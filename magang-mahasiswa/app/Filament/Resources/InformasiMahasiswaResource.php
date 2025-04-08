<?php

namespace App\Filament\Resources;

use App\Models\Mahasiswa;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use App\Filament\Resources\InformasiMahasiswaResource\Pages;

class InformasiMahasiswaResource extends Resource
{
    protected static ?string $model = Mahasiswa::class;
    protected static ?string $navigationLabel = 'Informasi Mahasiswa';
    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static ?string $navigationGroup = 'Data Mahasiswa';

    protected static string $resource = InformasiMahasiswaResource::class;

    public static function canAccess(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Section::make('Identitas Mahasiswa')
                    ->schema([
                        TextInput::make('nama')->disabled(),
                        TextInput::make('nim')->disabled(),
                        TextInput::make('kelompok')->disabled(),
                    ])->columns(3),

                Section::make('Status & Dokumen')
                    ->schema([
                        Select::make('status_dokumen')
                            ->label('Status Dokumen')
                            ->options([
                                'belum dikonfirmasi' => 'Belum Dikonfirmasi',
                                'disetujui' => 'Disetujui',
                                'ditolak' => 'Ditolak',
                            ])
                            ->required(),

                        Select::make('status_magang')
                            ->label('Status Magang')
                            ->options([
                                'belum magang' => 'Belum Magang',
                                'sedang magang' => 'Sedang Magang',
                                'selesai magang' => 'Selesai Magang',
                            ])
                            ->required(),
                    ])->columns(2),

                Section::make('Nilai Magang')
                    ->schema([
                        TextInput::make('nilai_magang')
                            ->numeric()
                            ->label('Nilai Magang')
                            ->required(),
                    ])->columns(2),

                    Section::make('Nilai dan Dokumen')
                    ->schema([
                        TextInput::make('nilai_magang')
                            ->numeric()
                            ->label('Nilai Magang')
                            ->required(),

                        Forms\Components\Placeholder::make('nilai_akhir')
                            ->label('Nilai Akhir')
                            ->content(fn ($record) => $record?->penilaian?->nilai_akhir ?? '-'),

                        Forms\Components\Placeholder::make('video_mediasi')
                            ->label('Video Mediasi')
                            ->content(function ($record) {
                                $url = $record?->penilaian?->video_mediasi;
                                if (!$url) return '-';
                                return new \Illuminate\Support\HtmlString(
                                    "<a href='{$url}' target='_blank' class='text-primary-600 hover:underline hover:text-primary-500 transition duration-200'>{$url}</a>"
                                );
                            }),

                        Forms\Components\Placeholder::make('penyuluhan_perizinan')
                            ->label('Penyuluhan Perizinan')
                            ->content(function ($record) {
                                $url = $record?->penilaian?->penyuluhan_perizinan;
                                if (!$url) return '-';
                                return new \Illuminate\Support\HtmlString(
                                    "<a href='{$url}' target='_blank' class='text-primary-600 hover:underline hover:text-primary-500 transition duration-200'>{$url}</a>"
                                );
                            }),
                    ])->columns(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('nim')->label('NIM')->searchable(),
                Tables\Columns\TextColumn::make('kelompok')->label('Kelompok'),

                Tables\Columns\TextColumn::make('status_dokumen')
                    ->label('Status Dokumen')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'disetujui' => 'success',
                        'ditolak' => 'danger',
                        'belum dikonfirmasi' => 'gray',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('status_magang')
                    ->label('Status Magang')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'belum magang' => 'gray',
                        'sedang magang' => 'warning',
                        'selesai magang' => 'success',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('nilai_magang')->label('Nilai Magang'),
                Tables\Columns\TextColumn::make('penilaian.nilai_akhir')->label('Nilai Akhir'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_dokumen')
                    ->options([
                        'belum dikonfirmasi' => 'Belum Dikonfirmasi',
                        'disetujui' => 'Disetujui',
                        'ditolak' => 'Ditolak',
                    ]),
                Tables\Filters\SelectFilter::make('status_magang')
                    ->options([
                        'belum magang' => 'Belum Magang',
                        'sedang magang' => 'Sedang Magang',
                        'selesai magang' => 'Selesai Magang',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInformasiMahasiswas::route('/'),
            'edit' => Pages\EditInformasiMahasiswa::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->role === 'admin';
    }
}
