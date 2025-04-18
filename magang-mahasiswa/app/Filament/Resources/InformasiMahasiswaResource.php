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
use Filament\Forms\Components\Placeholder;
use Filament\Tables\Columns\IconColumn;
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
                        TextInput::make('semester')
                            ->label('Semester')
                            ->disabled(),
                    ])->columns(2),

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

                Section::make('Nilai dan Dokumen')
                    ->schema([
                        TextInput::make('nilai_magang')
                            ->numeric()
                            ->label('Nilai Magang')
                            ->minValue(0)
                            ->maxValue(100),


                        Placeholder::make('nilai_akhir')
                            ->label('Nilai Akhir')
                            ->content(fn ($record) => $record?->penilaian?->nilai_akhir ?? '-'),

                        Placeholder::make('video_mediasi')
                            ->label('Link Video Pengurusan Perizinan')
                            ->content(function ($record) {
                                if ($record->semester !== 'genap') return 'Tidak tersedia untuk semester gasal';
                                $url = $record->video_mediasi;
                                if (!$url) return 'Belum diupload';
                                return new \Illuminate\Support\HtmlString(
                                    "<a href='{$url}' target='_blank' class='text-primary-600 hover:underline hover:text-primary-500 transition duration-200'>{$url}</a>"
                                );
                            })
                            ->visible(fn ($record) => $record?->semester === 'genap'),

                        Placeholder::make('video_penyuluhan')
                            ->label('Upload Link Laporan Penyuluhan')
                            ->content(function ($record) {
                                if ($record->semester !== 'genap') return 'Tidak tersedia untuk semester gasal';
                                $url = $record->video_penyuluhan;
                                if (!$url) return 'Belum diupload';
                                return new \Illuminate\Support\HtmlString(
                                    "<a href='{$url}' target='_blank' class='text-primary-600 hover:underline hover:text-primary-500 transition duration-200'>{$url}</a>"
                                );
                            })
                            ->visible(fn ($record) => $record?->semester === 'genap'),

                        Placeholder::make('ceklis_penyuluhan')
                            ->label('Status Penyuluhan')
                            ->content(function ($record) {
                                if ($record->semester !== 'gasal') return 'Tidak tersedia untuk semester genap';
                                return $record->ceklis_penyuluhan ? 'Sudah Ceklis' : 'Belum Ceklis';
                            })
                            ->visible(fn ($record) => $record?->semester === 'gasal'),

                        Placeholder::make('ceklis_artikel')
                            ->label('Status Artikel')
                            ->content(function ($record) {
                                if ($record->semester !== 'gasal') return 'Tidak tersedia untuk semester genap';
                                return $record->ceklis_artikel ? 'Sudah Ceklis' : 'Belum Ceklis';
                            })
                            ->visible(fn ($record) => $record?->semester === 'gasal'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable(),

                Tables\Columns\TextColumn::make('nim')
                    ->label('NIM')
                    ->searchable(),

                Tables\Columns\TextColumn::make('kelompok')
                    ->label('Kelompok'),

                Tables\Columns\TextColumn::make('semester')
                    ->label('Semester')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'gasal' => 'blue',
                        'genap' => 'green',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('nilai_magang')
                    ->label('Nilai Magang')
                    ->numeric()
                    ->color(function ($state) {
                        if ($state >= 85) return 'success';
                        if ($state >= 70) return 'warning';
                        return 'danger';
                    }),

                Tables\Columns\TextColumn::make('penilaian.nilai_akhir')
                    ->label('Nilai Akhir'),

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
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('semester')
                    ->options([
                        'gasal' => 'Gasal',
                        'genap' => 'Genap',
                    ]),

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
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('lihat_bukti_pembayaran')
                        ->label('Bukti Pembayaran')
                        ->icon('heroicon-o-banknotes')
                        ->color('info')
                        ->url(function (Mahasiswa $record) {
                            if (empty($record->bukti_pembayaran)) {
                                return null;
                            }
                            return url('storage/' . $record->bukti_pembayaran);
                        }, shouldOpenInNewTab: true)
                        ->visible(fn (Mahasiswa $record) => !empty($record->bukti_pembayaran)),

                    Tables\Actions\Action::make('lihat_bukti_krs')
                        ->label('Bukti KRS')
                        ->icon('heroicon-o-document-text')
                        ->color('info')
                        ->url(function (Mahasiswa $record) {
                            if (empty($record->bukti_krs)) {
                                return null;
                            }
                            return url('storage/' . $record->bukti_krs);
                        }, shouldOpenInNewTab: true)
                        ->visible(fn (Mahasiswa $record) => !empty($record->bukti_krs)),

                    Tables\Actions\Action::make('lihat_video_mediasi')
                        ->label('Video Pengurusan Perizinan')
                        ->icon('heroicon-o-film')
                        ->color('info')
                        ->url(function (Mahasiswa $record) {
                            return $record->video_mediasi;
                        }, shouldOpenInNewTab: true)
                        ->visible(fn (Mahasiswa $record) => !empty($record->video_mediasi) && $record->semester === 'genap'),

                    Tables\Actions\Action::make('lihat_video_penyuluhan')
                        ->label('Laporan Penyuluhan')
                        ->icon('heroicon-o-film')
                        ->color('info')
                        ->url(function (Mahasiswa $record) {
                            return $record->video_penyuluhan;
                        }, shouldOpenInNewTab: true)
                        ->visible(fn (Mahasiswa $record) => !empty($record->video_penyuluhan) && $record->semester === 'genap'),

                    Tables\Actions\Action::make('lihat_artikel')
                        ->label('Artikel')
                        ->icon('heroicon-o-newspaper')
                        ->color('info')
                        ->url(function (Mahasiswa $record) {
                            return $record->link_artikel;
                        }, shouldOpenInNewTab: true)
                        ->visible(fn (Mahasiswa $record) => !empty($record->link_artikel)),
                ])
                ->label('Dokumen')
                ->icon('heroicon-o-folder')
                ->color('gray')
                ->dropdown(),
            ])
            ->defaultSort('nama', 'asc')
            ->striped();
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
