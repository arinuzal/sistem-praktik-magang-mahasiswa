<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;


class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?int $navigationSort = 0;

    public static function getNavigationLabel(): string
    {
       return 'User';
    }

    public static function getPluralLabel(): string
    {
        return 'User';
    }

    public static function getSlug(): string
    {
         return 'user';
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->role === 'super admin';
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->role === 'super admin';
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->role === 'super admin';
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->role === 'super admin';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->required()
                ->maxLength(255),

            TextInput::make('email')
                ->email()
                ->required()
                ->unique(ignoreRecord: true),

            TextInput::make('password')
                ->password()
                ->required(fn ($livewire) => $livewire instanceof Pages\CreateUser)
                ->dehydrated(fn ($state) => filled($state))
                ->same('passwordConfirmation'),

            TextInput::make('passwordConfirmation')
                ->password()
                ->required(fn ($livewire) => $livewire instanceof Pages\CreateUser)
                ->dehydrated(false),

            Select::make('role')
                ->options([
                    'super admin' => 'Super Admin',
                    'admin' => 'Admin',
                    'tempat magang' => 'Tempat Magang',
                    'mahasiswa' => 'Mahasiswa',
                    'dosen' => 'Dosen'
                ])
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('role')->badge()->searchable(),
                TextColumn::make('created_at')->dateTime()->label('Dibuat'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
               ->label('Filter Role')
               ->options([
                'super admin' => 'Super Admin',
                'admin' => 'Admin',
                'tempat magang' => 'Tempat Magang',
                'mahasiswa' => 'Mahasiswa',
                'dosen' => 'Dosen'
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
