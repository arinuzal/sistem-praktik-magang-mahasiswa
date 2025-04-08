<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\PasswordReset\RequestPasswordReset;

class PasswordReset extends RequestPasswordReset
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('email')
                    ->label('Email Terdaftar')
                    ->email()
                    ->required()
                    ->autocomplete('email'),
            ]);
    }
}
