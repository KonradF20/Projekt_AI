<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Imię i nazwisko')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Adres E-mail')
                    ->email()
                    ->required()
                    ->maxLength(255),

                TextInput::make('password')
                    ->label('Hasło')
                    ->password()
                    ->maxLength(255)
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create'),
            ]);
    }
}
