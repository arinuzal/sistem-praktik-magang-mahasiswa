<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MahasiswaResource\Pages;
use App\Models\Mahasiswa;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Hidden;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;

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
        return $form->schema([
            auth()->user()->role === 'mahasiswa'
                ? Hidden::make('user_id')->default(auth()->id())
                : Select::make('user_id')
                    ->label('Pilih Users')
                    ->options(User::where('role', 'mahasiswa')->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                    TextInput::make('nama')
                    ->required(),
                    TextInput::make('nim')
                    ->required()
                    ->unique(ignoreRecord: true),

            Select::make('semester')
                ->options([
                    'gasal' => 'Gasal',
                    'genap' => 'Genap',
                ])
                ->required()
                ->reactive(),

                Select::make('status_dokumen')
                ->label('Status Dokumen')
                ->options([
                    'belum dikonfirmasi' => 'Belum Dikonfirmasi',
                    'disetujui' => 'Disetujui',
                    'ditolak' => 'Ditolak',
                ])
                ->required()
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

            CheckboxList::make('mata_kuliah')
                ->label('Mata Kuliah')
                ->required()
                ->options(fn (callable $get) => match ($get('semester')) {
                    'gasal' => [
                        'PP Agama' => 'PP Agama',
                        'PP Konstitusi' => 'PP Konstitusi',
                        'PP Perdata' => 'PP Perdata',
                        'PP Pidana' => 'PP Pidana',
                        'PP TUN' => 'PP TUN',
                    ],
                    'genap' => [
                        'TPK' => 'TPK',
                        'TPUU' => 'TPUU',
                        'Arbitrase dan APS' => 'Arbitrase dan APS',
                        'Teknik Pengurusan Perizinan' => 'Teknik Pengurusan Perizinan',
                    ],
                    default => [],
                })
                ->afterStateUpdated(function ($state, callable $get, callable $set) {
                    $semester = $get('semester');
                    $validOptions = match ($semester) {
                        'gasal' => ['PP Agama', 'PP Konstitusi', 'PP Perdata', 'PP Pidana', 'PP TUN'],
                        'genap' => ['TPK', 'TPUU', 'Arbitrase dan APS', 'Teknik Pengurusan Perizinan'],
                        default => [],
                    };

                    $invalid = collect($state)->diff($validOptions);
                    if ($invalid->isNotEmpty()) {
                        Notification::make()
                            ->title('Mata kuliah tidak sesuai semester!')
                            ->danger()
                            ->body('Beberapa mata kuliah tidak sesuai dengan semester yang dipilih.')
                            ->send();

                        $set('mata_kuliah', []);
                    }
                })
                ->columns(2),

            FileUpload::make('bukti_pembayaran')
                ->label('Upload Bukti Pembayaran')
                ->image()
                ->directory('bukti-pembayaran')
                ->required(),

            FileUpload::make('bukti_krs')
                ->label('Upload Bukti KRS')
                ->acceptedFileTypes(['application/pdf', 'image/*'])
                ->directory('bukti-krs')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')->label('Nama')->searchable(),
                TextColumn::make('nim')->searchable(),
                TextColumn::make('semester'),
                TextColumn::make('status_dokumen')->label('Status Dokumen')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'belum dikonfirmasi' => 'gray',
                        'disetujui' => 'success',
                        'ditolak' => 'danger',
                    }),
                TextColumn::make('status_magang')->label('Status Magang')
                    ->badge()
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

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMahasiswas::route('/'),
            'create' => Pages\CreateMahasiswa::route('/create'),
            'edit' => Pages\EditMahasiswa::route('/{record}/edit'),
        ];
    }
}
