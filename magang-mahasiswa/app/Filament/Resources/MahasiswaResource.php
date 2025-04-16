<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MahasiswaResource\Pages;
use App\Models\Mahasiswa;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Facades\Storage;

class MahasiswaResource extends Resource
{
    protected static ?string $model = Mahasiswa::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?int $navigationSort = 1;

    public static function canAccess(): bool
    {
        return auth()->user()?->role === 'super admin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Mahasiswa')
                    ->schema([
                        auth()->user()->role === 'mahasiswa'
                            ? Hidden::make('user_id')->default(auth()->id())
                            : Select::make('user_id')
                                ->label('Pilih User')
                                ->options(User::where('role', 'mahasiswa')->pluck('name', 'id'))
                                ->searchable()
                                ->required(),

                        TextInput::make('nama')->required(),
                        TextInput::make('nim')->required()->unique(ignoreRecord: true),

                        Select::make('semester')
                            ->options([
                                'gasal' => 'Gasal',
                                'genap' => 'Genap',
                            ])
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn (Set $set) => $set('mata_kuliah', [])),

                        Select::make('status_dokumen')
                            ->label('Status Dokumen')
                            ->options([
                                'belum dikonfirmasi' => 'Belum Dikonfirmasi',
                                'disetujui' => 'Disetujui',
                                'ditolak' => 'Ditolak',
                            ])
                            ->default('belum dikonfirmasi')
                            ->visible(fn () => in_array(auth()->user()->role, ['super admin'])),

                        Select::make('status_magang')
                            ->label('Status Magang')
                            ->options([
                                'belum magang' => 'Belum Magang',
                                'sedang magang' => 'Sedang Magang',
                                'selesai magang' => 'Selesai Magang',
                            ])
                            ->default('belum magang')
                            ->visible(fn () => in_array(auth()->user()->role, ['admin', 'super admin'])),
                    ]),

                Section::make('Mata Kuliah')
                    ->schema([
                        CheckboxList::make('mata_kuliah')
                            ->label('Pilih Mata Kuliah')
                            ->options([
                                'PP Agama' => 'PP Agama',
                                'PP Konstitusi' => 'PP Konstitusi',
                                'PP Perdata' => 'PP Perdata',
                                'PP Pidana' => 'PP Pidana',
                                'PP TUN' => 'PP TUN',
                            ])
                            ->columns(2)
                            ->visible(fn (Get $get) => $get('semester') === 'gasal'),

                        Grid::make()
                            ->schema([
                                Select::make('mata_kuliah_teknik_pengurusan_perizinan')
                                    ->label('Teknik Pengurusan Perizinan')
                                    ->options(['A' => 'Kelas A'])
                                    ->afterStateUpdated(function (Set $set, Get $get) {
                                        $currentMataKuliah = array_filter($get('mata_kuliah') ?? [], function($item) {
                                            return !isset($item['nama']) ||
                                                  $item['nama'] !== 'Teknik Pengurusan Perizinan';
                                        });

                                        if ($selected = $get('mata_kuliah_teknik_pengurusan_perizinan')) {
                                            $currentMataKuliah[] = [
                                                'nama' => 'Teknik Pengurusan Perizinan',
                                                'kelas' => $selected
                                            ];
                                        }

                                        $set('mata_kuliah', array_values($currentMataKuliah));
                                    }),

                                Select::make('mata_kuliah_teknik_pembuatan_perundangan')
                                    ->label('Teknik Pembuatan Perundang-Undangan')
                                    ->options([
                                        'A' => 'Kelas A',
                                        'B' => 'Kelas B',
                                        'C' => 'Kelas C',
                                        'D' => 'Kelas D',
                                        'E' => 'Kelas E',
                                        'F' => 'Kelas F',
                                        'G' => 'Kelas G',
                                        'H' => 'Kelas H',
                                        'I' => 'Kelas I',
                                        'J' => 'Kelas J',
                                        'K' => 'Kelas K',
                                        'L' => 'Kelas L',
                                    ])
                                    ->afterStateUpdated(function (Set $set, Get $get) {
                                        $currentMataKuliah = array_filter($get('mata_kuliah') ?? [], function($item) {
                                            return !isset($item['nama']) ||
                                                  $item['nama'] !== 'Teknik Pembuatan Perundang-Undangan';
                                        });

                                        if ($selected = $get('mata_kuliah_teknik_pembuatan_perundangan')) {
                                            $currentMataKuliah[] = [
                                                'nama' => 'Teknik Pembuatan Perundang-Undangan',
                                                'kelas' => $selected
                                            ];
                                        }

                                        $set('mata_kuliah', array_values($currentMataKuliah));
                                    }),

                                Select::make('mata_kuliah_teknik_pembuatan_kontrak')
                                    ->label('Teknik Pembuatan Kontrak')
                                    ->options([
                                        'A' => 'Kelas A',
                                        'B' => 'Kelas B',
                                        'C' => 'Kelas C',
                                        'D' => 'Kelas D',
                                        'E' => 'Kelas E',
                                        'F' => 'Kelas F',
                                        'G' => 'Kelas G',
                                        'H' => 'Kelas H',
                                        'I' => 'Kelas I',
                                    ])
                                    ->afterStateUpdated(function (Set $set, Get $get) {
                                        $currentMataKuliah = array_filter($get('mata_kuliah') ?? [], function($item) {
                                            return !isset($item['nama']) ||
                                                  $item['nama'] !== 'Teknik Pembuatan Kontrak';
                                        });

                                        if ($selected = $get('mata_kuliah_teknik_pembuatan_kontrak')) {
                                            $currentMataKuliah[] = [
                                                'nama' => 'Teknik Pembuatan Kontrak',
                                                'kelas' => $selected
                                            ];
                                        }

                                        $set('mata_kuliah', array_values($currentMataKuliah));
                                    }),

                                Select::make('mata_kuliah_penanganan_perkara_konstitusi')
                                    ->label('Penanganan Perkara Konstitusi')
                                    ->options(['A' => 'Kelas A'])
                                    ->afterStateUpdated(function (Set $set, Get $get) {
                                        $currentMataKuliah = array_filter($get('mata_kuliah') ?? [], function($item) {
                                            return !isset($item['nama']) ||
                                                  $item['nama'] !== 'Penanganan Perkara Konstitusi';
                                        });

                                        if ($selected = $get('mata_kuliah_penanganan_perkara_konstitusi')) {
                                            $currentMataKuliah[] = [
                                                'nama' => 'Penanganan Perkara Konstitusi',
                                                'kelas' => $selected
                                            ];
                                        }

                                        $set('mata_kuliah', array_values($currentMataKuliah));
                                    }),

                                Select::make('mata_kuliah_arbitrase')
                                    ->label('Arbitrase dan Alternatif Penyelesaian Sengketa')
                                    ->options([
                                        'A' => 'Kelas A',
                                        'B' => 'Kelas B',
                                        'C' => 'Kelas C',
                                        'D' => 'Kelas D',
                                        'E' => 'Kelas E',
                                        'F' => 'Kelas F',
                                        'G' => 'Kelas G',
                                        'H' => 'Kelas H',
                                        'I' => 'Kelas I',
                                    ])
                                    ->afterStateUpdated(function (Set $set, Get $get) {
                                        $currentMataKuliah = array_filter($get('mata_kuliah') ?? [], function($item) {
                                            return !isset($item['nama']) ||
                                                  $item['nama'] !== 'Arbitrase dan Alternatif Penyelesaian Sengketa';
                                        });

                                        if ($selected = $get('mata_kuliah_arbitrase')) {
                                            $currentMataKuliah[] = [
                                                'nama' => 'Arbitrase dan Alternatif Penyelesaian Sengketa',
                                                'kelas' => $selected
                                            ];
                                        }

                                        $set('mata_kuliah', array_values($currentMataKuliah));
                                    }),
                            ])
                            ->columns(2)
                            ->visible(fn (Get $get) => $get('semester') === 'genap'),

                        Hidden::make('mata_kuliah')
                            ->default([])
                            ->dehydrateStateUsing(function ($state, Get $get) {
                                if ($get('semester') === 'gasal') {
                                    return array_map(function($matkul) {
                                        return ['nama' => $matkul, 'kelas' => null];
                                    }, $state);
                                }
                                return $state;
                            }),
                    ])
                    ->visible(fn (Get $get) => !empty($get('semester'))),

                ViewField::make('mata_kuliah')
                    ->label('Mata Kuliah & Kelas')
                    ->view('filament.components.mata-kuliah-kelas')
                    ->visibleOn(['view', 'edit']),

                Section::make('Dokumen')
                    ->schema([
                        Forms\Components\FileUpload::make('bukti_pembayaran')
                            ->label('Upload Bukti Pembayaran')
                            ->required()
                            ->disk('public')
                            ->directory('bukti_pembayaran')
                            ->visibility('public')
                            ->downloadable()
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                            ->maxSize(5120)
                            ->visible(fn ($record) => $record === null),

                        Forms\Components\FileUpload::make('bukti_krs')
                            ->label('Upload Bukti KRS')
                            ->required()
                            ->disk('public')
                            ->directory('bukti_krs')
                            ->visibility('public')
                            ->downloadable()
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                            ->maxSize(5120)
                            ->visible(fn ($record) => $record === null),
                    ])
                    ->visible(fn ($operation) => $operation === 'create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')->label('Nama')->searchable(),
                TextColumn::make('nim')->searchable(),
                TextColumn::make('semester'),
                TextColumn::make('status_dokumen')
                    ->badge()
                    ->label('Status Dokumen')
                    ->color(fn ($state) => match ($state) {
                        'belum dikonfirmasi' => 'gray',
                        'disetujui' => 'success',
                        'ditolak' => 'danger',
                    }),
                TextColumn::make('status_magang')
                    ->badge()
                    ->label('Status Magang')
                    ->color(fn ($state) => match ($state) {
                        'belum magang' => 'gray',
                        'sedang magang' => 'warning',
                        'selesai magang' => 'success',
                    }),
                TextColumn::make('bukti_pembayaran')
                    ->label('Bukti Pembayaran')
                    ->formatStateUsing(fn ($state) => $state ? 'Tersedia' : 'Belum upload')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'danger'),
                TextColumn::make('bukti_krs')
                    ->label('Bukti KRS')
                    ->formatStateUsing(fn ($state) => $state ? 'Tersedia' : 'Belum upload')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'danger'),
                TextColumn::make('created_at')->dateTime()->label('Dibuat'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('semester')
                    ->label('Semester')
                    ->options([
                        'gasal' => 'Gasal',
                        'genap' => 'Genap',
                    ]),
                Tables\Filters\SelectFilter::make('status_dokumen')
                    ->label('Status Dokumen')
                    ->options([
                        'belum dikonfirmasi' => 'Belum Dikonfirmasi',
                        'disetujui' => 'Disetujui',
                        'ditolak' => 'Ditolak',
                    ]),
                Tables\Filters\SelectFilter::make('status_magang')
                    ->label('Status Magang')
                    ->options([
                        'belum magang' => 'Belum Magang',
                        'sedang magang' => 'Sedang Magang',
                        'selesai magang' => 'Selesai Magang',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('lihat_bukti_pembayaran')
                    ->label('Lihat Bukti Pembayaran')
                    ->icon('heroicon-o-document')
                    ->url(function (Mahasiswa $record) {
                        if (empty($record->bukti_pembayaran)) {
                            return null;
                        }

                        return url('storage/' . $record->bukti_pembayaran);
                    }, shouldOpenInNewTab: true)
                    ->visible(fn (Mahasiswa $record) => !empty($record->bukti_pembayaran)),

                Tables\Actions\Action::make('lihat_bukti_krs')
                    ->label('Lihat Bukti KRS')
                    ->icon('heroicon-o-document')
                    ->url(function (Mahasiswa $record) {
                        if (empty($record->bukti_krs)) {
                            return null;
                        }

                        return url('storage/' . $record->bukti_krs);
                    }, shouldOpenInNewTab: true)
                    ->visible(fn (Mahasiswa $record) => !empty($record->bukti_krs)),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMahasiswas::route('/'),
            'create' => Pages\CreateMahasiswa::route('/create'),
            'view' => Pages\ViewMahasiswa::route('/{record}'),
            'edit' => Pages\EditMahasiswa::route('/{record}/edit'),
        ];
    }
}
