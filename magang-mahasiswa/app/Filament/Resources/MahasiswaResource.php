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
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

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
                    ->required(),

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

                ViewField::make('mata_kuliah')
                    ->label('Mata Kuliah & Kelas')
                    ->view('filament.components.mata-kuliah-kelas')
                    ->visibleOn(['view', 'edit']),

                ViewField::make('bukti_pembayaran')
                    ->label('Bukti Pembayaran')
                    ->view('filament.components.preview-file')
                    ->visibleOn(['view', 'edit']),

                ViewField::make('bukti_krs')
                    ->label('Bukti KRS')
                    ->view('filament.components.preview-file')
                    ->visibleOn(['view', 'edit']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')->label('Nama')->searchable(),
                TextColumn::make('nim')->searchable(),
                TextColumn::make('semester'),
                // TextColumn::make('mata_kuliah')
                //     ->label('Mata Kuliah & Kelas')
                //     ->formatStateUsing(function ($state) {
                //         $data = json_decode($state, true);
                //         if (!is_array($data)) return '-';
                //         return collect($data)
                //             ->map(fn($item) => $item['nama'] . (!empty($item['kelas']) ? " ({$item['kelas']})" : ''))
                //             ->implode(', ');
                //     }),
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
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMahasiswas::route('/'),
            'view' => Pages\ViewMahasiswa::route('/{record}'),
            'edit' => Pages\EditMahasiswa::route('/{record}/edit'),
        ];
    }
}
