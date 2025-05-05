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
use Illuminate\Support\Facades\DB;
use Filament\Tables\Columns\TextColumn;

class PenilaianResource extends Resource
{
    protected static ?string $model = Penilaian::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Penilaian';

    public static function canAccess(): bool
    {
        return in_array(auth()->user()?->role, ['admin', 'super admin']);
    }

    public static function getNavigationLabel(): string
    {
       return 'Penilaian Mahasiswa';
    }

    public static function getPluralLabel(): string
    {
        return 'Penilaian';
    }

    public static function getSlug(): string
    {
         return 'penilaian-mahasiswa';
    }

    public static function getNavigationGroup(): string
    {
        return 'Penilaian';
    }

    public static function form(Form $form): Form
    {
        $isEditMode = $form->getOperation() === 'edit';
        $record = $form->getRecord();

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
                        $set('nilai_magang', null);
                        return;
                    }

                    $mahasiswa = Mahasiswa::find($state);
                    if ($mahasiswa) {
                        $set('video_mediasi', $mahasiswa->video_mediasi);
                        $set('penyuluhan_perizinan', $mahasiswa->video_penyuluhan);
                        $set('nilai_magang', $mahasiswa->nilai_magang);
                    }
                }),

            Forms\Components\TextInput::make('nilai_magang')
                ->label('Nilai Magang')
                ->numeric()
                ->minValue(0)
                ->maxValue(100)
                ->required()
                ->disabled(fn () => !$isEditMode)
                ->dehydrated(true)
                ->afterStateHydrated(function ($state, $record, Set $set) {
                    if ($record && $record->mahasiswa_id) {
                        $mahasiswa = Mahasiswa::find($record->mahasiswa_id);
                        if ($mahasiswa) {
                            $set('nilai_magang', $mahasiswa->nilai_magang);
                        }
                    }
                })
                ->live(onBlur: true)
                ->afterStateUpdated(function ($state, $record, Set $set) {
                    if ($record && $record->mahasiswa_id) {
                        DB::table('mahasiswas')
                            ->where('id', $record->mahasiswa_id)
                            ->update(['nilai_magang' => $state]);
                    }
                }),

            Forms\Components\TextInput::make('nilai_mediasi')
                ->label('Nilai Mediasi')
                ->numeric()
                ->minValue(0)
                ->maxValue(100)
                ->required(),

            Forms\Components\TextInput::make('video_mediasi')
                ->label('Link Video Pengurusan Perizinan')
                ->url()
                ->columnSpanFull()
                ->reactive()
                ->disabled(fn () => !$isEditMode)
                ->afterStateHydrated(function ($state, $record, Set $set) {
                    if ($record && $record->mahasiswa_id) {
                        $mahasiswa = Mahasiswa::find($record->mahasiswa_id);
                        if ($mahasiswa) {
                            $set('video_mediasi', $mahasiswa->video_mediasi);
                        }
                    }
                })
                ->afterStateUpdated(function ($state, $record, Set $set) {
                    if ($record && $record->mahasiswa_id) {
                        DB::table('mahasiswas')
                            ->where('id', $record->mahasiswa_id)
                            ->update(['video_mediasi' => $state]);
                    }
                }),

            Forms\Components\TextInput::make('nilai_video_mediasi')
                ->label('Nilai Video Pengurusan Perizinan')
                ->numeric()
                ->minValue(0)
                ->maxValue(100)
                ->required(),

            Forms\Components\TextInput::make('penyuluhan_perizinan')
                ->label('Upload Link Laporan Penyuluhan')
                ->url()
                ->columnSpanFull()
                ->reactive()
                ->disabled(fn () => !$isEditMode)
                ->afterStateHydrated(function ($state, $record, Set $set) {
                    if ($record && $record->mahasiswa_id) {
                        $mahasiswa = Mahasiswa::find($record->mahasiswa_id);
                        if ($mahasiswa) {
                            $set('penyuluhan_perizinan', $mahasiswa->video_penyuluhan);
                        }
                    }
                })
                ->afterStateUpdated(function ($state, $record, Set $set) {
                    if ($record && $record->mahasiswa_id) {
                        DB::table('mahasiswas')
                            ->where('id', $record->mahasiswa_id)
                            ->update(['video_penyuluhan' => $state]);
                    }
                }),

            Forms\Components\TextInput::make('nilai_penyuluhan')
                ->label('Nilai Laporan Penyuluhan')
                ->numeric()
                ->minValue(0)
                ->maxValue(100)
                ->required(),

            Forms\Components\TextInput::make('nilai_akhir')
                ->label('Nilai Akhir (otomatis)')
                ->numeric()
                ->disabled()
                ->dehydrated(false),

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
                TextColumn::make('index')
                ->label('No')
                ->rowIndex()
                ->alignCenter(),
                Tables\Columns\TextColumn::make('mahasiswa.nim')->label('NIM')->searchable()->sortable()->alignCenter(),
                Tables\Columns\TextColumn::make('mahasiswa.nama')->label('Nama')->searchable()->sortable()->alignCenter(),
                Tables\Columns\TextColumn::make('mahasiswa.nilai_magang')
                    ->label('Nilai Magang')
                    ->sortable()
                    ->alignCenter()
                    ->getStateUsing(function ($record) {
                        if ($record->mahasiswa_id) {
                            $mahasiswa = Mahasiswa::find($record->mahasiswa_id);
                            return $mahasiswa ? $mahasiswa->nilai_magang : null;
                        }
                        return null;
                    })
                    ->color(function ($state) {
                        if ($state >= 85) return 'success';
                        if ($state >= 70) return 'warning';
                        return 'danger';
                    })
                    ->icon(function ($state) {
                        if ($state >= 70) return 'heroicon-o-check-circle';
                        return 'heroicon-o-x-circle';
                    })
                    ->placeholder('Belum ada'),
                TextColumn::make('created_at')->dateTime()->label('Dibuat')->sortable()->alignCenter(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->before(function ($action, $record) {
                        if ($record && $record->mahasiswa) {
                            $record->mahasiswa->refresh();
                        }
                    }),
                Tables\Actions\EditAction::make()
                    ->before(function ($action, $record) {
                        if ($record && $record->mahasiswa) {
                            $record->mahasiswa->refresh();
                        }
                    })
                    ->after(function (Penilaian $record) {
                        if ($record->mahasiswa) {
                            $record->mahasiswa->refresh();
                        }
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->label('Hapus'),
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
