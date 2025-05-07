<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MahasiswaResource\Pages;
use App\Models\Mahasiswa;
use App\Models\TempatMagang;
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
use Illuminate\Database\Eloquent\Collection;

class MahasiswaResource extends Resource
{
    protected static ?string $model = Mahasiswa::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?int $navigationSort = 1;

    public static function canAccess(): bool
    {
        return auth()->user()?->role === 'super admin';
    }

    public static function getNavigationLabel(): string
    {
        return 'Mahasiswa';
    }

    public static function getPluralLabel(): string
    {
        return 'Mahasiswa';
    }

    public static function getSlug(): string
    {
         return 'mahasiswa';
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

                        Select::make('tempat_magang_id')
                          ->label('Tempat Magang')
                          ->options(TempatMagang::all()->pluck('nama_instansi', 'id'))
                          ->searchable()
                          ->nullable()
                          ->visible(fn () => in_array(auth()->user()->role, ['super admin'])),

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

                            Forms\Components\Toggle::make('is_luar_biasa')
                            ->label('Mahasiswa Luar Biasa')
                            ->inline(false),
                    ]),

                    Section::make('Penilaian')
                    ->schema([
                        TextInput::make('nilai_magang')
                            ->label('Nilai Magang')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffixIcon('heroicon-o-academic-cap')
                            ->visible(fn ($operation) => $operation === 'edit'),
                    ])
                    ->collapsible()
                    ->visible(fn ($operation) => $operation === 'edit' || $operation === 'view'),

                Section::make('Mata Kuliah')
                ->schema([
                    CheckboxList::make('mata_kuliah_gasal')
                        ->label('Pilih Mata Kuliah')
                        ->options([
                            'PP Agama' => 'PP Agama',
                            'PP Konstitusi' => 'PP Konstitusi',
                            'PP Perdata' => 'PP Perdata',
                            'PP Pidana' => 'PP Pidana',
                            'PP TUN' => 'PP TUN',
                        ])
                        ->columns(2)
                        ->visible(fn (Get $get) => $get('semester') === 'gasal')
                        ->afterStateHydrated(function (Set $set, $state, $record) {
                            if ($record && $record->semester === 'gasal') {
                                $mataKuliah = array_column($record->mata_kuliah ?? [], 'nama');
                                $set('mata_kuliah_gasal', $mataKuliah);
                            }
                        })
                        ->afterStateUpdated(function (Set $set, Get $get, $state) {
                            if (is_array($state)) {
                                $mataKuliahArray = array_map(function($mk) {
                                    return ['nama' => $mk, 'kelas' => null];
                                }, $state);

                                $set('mata_kuliah', $mataKuliahArray);
                            }
                        }),
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
                         $gasalMataKuliah = $get('mata_kuliah_gasal') ?? [];
                        return array_map(function($matkul) {
                            return ['nama' => $matkul, 'kelas' => null];
                            }, $gasalMataKuliah);
                          } else if ($get('semester') === 'genap') {

                        return $state ?? [];
                    }
                        return [];
                           }),
                    ])
                    ->visible(fn (Get $get) => !empty($get('semester'))),

                    ViewField::make('mata_kuliah')
                    ->label('Mata Kuliah & Kelas')
                    ->view('filament.components.mata-kuliah-kelas')
                    ->visibleOn(['view', 'edit'])
                    ->afterStateHydrated(function (Set $set, $state, $record) {
                        if ($record && $record->semester === 'gasal') {
                            $mataKuliah = array_column($record->mata_kuliah ?? [], 'nama');
                            $set('mata_kuliah_gasal', $mataKuliah);
                        }
                    }),
                    Section::make('Informasi Tambahan')
                    ->schema([
                        TextInput::make('video_mediasi')
                            ->label('Link Video Pengurusan Perizinan')
                            ->url()
                            ->columnSpanFull()
                            ->visible(fn (Get $get) => $get('semester') === 'genap')
                            ->disabled()
                            ->suffixIcon('heroicon-o-film'),

                        TextInput::make('video_penyuluhan')
                            ->label('Upload Link Laporan Penyuluhan')
                            ->url()
                            ->columnSpanFull()
                            ->visible(fn (Get $get) => $get('semester') === 'genap')
                            ->disabled()
                            ->suffixIcon('heroicon-o-film'),

                        TextInput::make('ceklis_penyuluhan_status')
                            ->label('Status Penyuluhan')
                            ->formatStateUsing(fn ($state) => $state ? 'Sudah Dilakukan' : 'Belum Dilakukan')
                            ->visible(fn (Get $get) => $get('semester') === 'gasal')
                            ->disabled()
                            ->suffixIcon(fn ($state) => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                            ->suffixIconColor(fn ($state) => $state ? 'success' : 'danger'),

                        TextInput::make('ceklis_artikel_status')
                            ->label('Status Artikel')
                            ->formatStateUsing(fn ($state) => $state ? 'Sudah Diunggah' : 'Belum Diunggah')
                            ->visible(fn (Get $get) => $get('semester') === 'gasal')
                            ->disabled()
                            ->suffixIcon(fn ($state) => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                            ->suffixIconColor(fn ($state) => $state ? 'success' : 'danger'),
                    ])
                    ->collapsible()
                    ->visibleOn('view')
                    ->afterStateHydrated(function (Set $set, $record) {
                        $set('ceklis_penyuluhan_status', $record->ceklis_penyuluhan ?? false);
                        $set('ceklis_artikel_status', $record->ceklis_artikel ?? false);
                    }),

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
            TextColumn::make('index')
                ->label('No')
                ->rowIndex()
                ->alignCenter(),

            TextColumn::make('nama')
                ->label('Nama')
                ->searchable()
                ->sortable()
                ->alignCenter()
                ->weight('medium')
                ->description(fn (Mahasiswa $record) => $record->nim)
                ->wrap(),

            TextColumn::make('semester')
                ->label('Semester')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'gasal' => 'info',
                    'genap' => 'success',
                })
                ->sortable()
                ->alignCenter(),

            Tables\Columns\TextColumn::make('kelompok')
                ->label('Kelompok')
                ->sortable()
                ->alignCenter()
                ->placeholder('Belum ada'),

            TextColumn::make('nilai_magang')
                ->label('Nilai Magang')
                ->numeric()
                ->sortable()
                ->alignCenter()
                ->color(function ($state) {
                    if ($state >= 85) return 'success';
                    if ($state >= 70) return 'warning';
                    return 'danger';
                })
                ->placeholder('Belum ada')
                ->icon(function ($state) {
                    if ($state >= 70) return 'heroicon-o-check-circle';
                    return 'heroicon-o-x-circle';
                }),

            TextColumn::make('tempatMagang.nama_instansi')
                ->label('Tempat Magang')
                ->searchable()
                ->sortable()
                ->alignCenter()
                ->wrap()
                ->placeholder('Belum ada'),

            TextColumn::make('is_luar_biasa')
                ->label('Status Mahasiswa')
                ->formatStateUsing(fn ($state): string => $state ? 'Luar Biasa' : 'Reguler')
                ->badge()
                ->color(fn (string $state): string => $state ? 'warning' : 'gray')
                ->sortable()
                ->alignCenter(),

            TextColumn::make('status_dokumen')
                ->label('Status Dokumen')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'belum dikonfirmasi' => 'gray',
                    'disetujui' => 'success',
                    'ditolak' => 'danger',
                    default => 'gray',
                })
                ->icon(fn (string $state): string => match ($state) {
                    'belum dikonfirmasi' => 'heroicon-o-clock',
                    'disetujui' => 'heroicon-o-check-circle',
                    'ditolak' => 'heroicon-o-x-circle',
                    default => 'heroicon-o-question-mark-circle',
                })
                ->sortable()
                ->alignCenter(),

            TextColumn::make('status_magang')
                ->label('Status Magang')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'belum magang' => 'gray',
                    'sedang magang' => 'warning',
                    'selesai magang' => 'success',
                    default => 'gray',
                })
                ->icon(fn (string $state): string => match ($state) {
                    'belum magang' => 'heroicon-o-academic-cap',
                    'sedang magang' => 'heroicon-o-briefcase',
                    'selesai magang' => 'heroicon-o-check-badge',
                    default => 'heroicon-o-question-mark-circle',
                })
                ->sortable()
                ->alignCenter(),
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

            Tables\Filters\SelectFilter::make('is_luar_biasa')
                ->label('Status Mahasiswa')
                ->options([
                    true => 'Luar Biasa',
                    false => 'Reguler',
                ]),
        ])
        ->actions([
            Tables\Actions\ViewAction::make()
                ->icon('heroicon-o-eye')
                ->color('primary'),

            Tables\Actions\EditAction::make()
                ->icon('heroicon-o-pencil')
                ->color('success'),

            Tables\Actions\DeleteAction::make()
                ->icon('heroicon-o-trash')
                ->color('danger'),

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
                    ->visible(fn (Mahasiswa $record) => !empty($record->video_mediasi)),

                Tables\Actions\Action::make('lihat_video_penyuluhan')
                    ->label('Laporan Penyuluhan')
                    ->icon('heroicon-o-film')
                    ->color('info')
                    ->url(function (Mahasiswa $record) {
                        return $record->video_penyuluhan;
                    }, shouldOpenInNewTab: true)
                    ->visible(fn (Mahasiswa $record) => !empty($record->video_penyuluhan)),

                Tables\Actions\Action::make('lihat_artikel')
                    ->label('Artikel')
                    ->icon('heroicon-o-newspaper')
                    ->color('info')
                    ->url(function (Mahasiswa $record) {
                        return $record->link_artikel;
                    }, shouldOpenInNewTab: true)
                    ->visible(fn (Mahasiswa $record) => !empty($record->link_artikel)),

                Tables\Actions\Action::make('lihat_artikel_pdf')
                    ->label('Artikel PDF')
                    ->icon('heroicon-o-document-text')
                    ->color('primary')
                    ->url(function (Mahasiswa $record) {
                        return Storage::url(str_replace('public/', '', $record->artikel_pdf));
                    })
                    ->openUrlInNewTab()
                    ->visible(fn (Mahasiswa $record) => !empty($record->artikel_pdf)),

                Tables\Actions\Action::make('lihat_laporan_penyuluhan_pdf')
                    ->label('Laporan Penyuluhan PDF')
                    ->icon('heroicon-o-document-text')
                    ->color('primary')
                    ->url(function (Mahasiswa $record) {
                        return Storage::url(str_replace('public/', '', $record->laporan_penyuluhan_pdf));
                    })
                    ->openUrlInNewTab()
                    ->visible(fn (Mahasiswa $record) => !empty($record->laporan_penyuluhan_pdf)),
            ])
            ->label('Dokumen')
            ->icon('heroicon-o-folder')
            ->color('gray')
            ->dropdown(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\BulkAction::make('verifyDocuments')
                    ->label('Setujui Dokumen')
                    ->icon('heroicon-o-document-check')
                    ->color('success')
                    ->action(function (Collection $records) {
                        $records->each(function ($record) {
                            $record->update([
                                'status_dokumen' => 'disetujui'
                            ]);
                        });
                    })
                    ->deselectRecordsAfterCompletion()
                    ->visible(fn (): bool => auth()->user()->role === 'super admin'),

                Tables\Actions\BulkAction::make('rejectDocuments')
                    ->label('Tolak Dokumen')
                    ->icon('heroicon-o-document-text')
                    ->color('danger')
                    ->action(function (Collection $records) {
                        $records->each(function ($record) {
                            $record->update([
                                'status_dokumen' => 'ditolak'
                            ]);
                        });
                    })
                    ->deselectRecordsAfterCompletion()
                    ->visible(fn (): bool => auth()->user()->role === 'super admin'),

                Tables\Actions\BulkAction::make('updateInternshipStatus')
                    ->label('Ubah Status Magang')
                    ->icon('heroicon-o-briefcase')
                    ->form([
                        Select::make('status_magang')
                            ->label('Status Magang Baru')
                            ->options([
                                'belum magang' => 'Belum Magang',
                                'sedang magang' => 'Sedang Magang',
                                'selesai magang' => 'Selesai Magang',
                            ])
                            ->required()
                    ])
                    ->action(function (Collection $records, array $data): void {
                        $records->each(function ($record) use ($data) {
                            $record->update([
                                'status_magang' => $data['status_magang']
                            ]);
                        });
                    })
                    ->deselectRecordsAfterCompletion()
                    ->visible(fn (): bool => in_array(auth()->user()->role, ['super admin'])),
                Tables\Actions\DeleteBulkAction::make()->label('Hapus'),
            ])
        ])
        ->defaultSort('nama', 'asc')
        ->striped();
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
