<?php

namespace App\Filament\Resources\TravelPlans\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TravelPlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informacje o planie')
                    ->schema([
                        Hidden::make('user_id')
                            ->default(auth()->id()),

                        Hidden::make('days')
                            ->default([]),

                        TextInput::make('title')
                            ->label('Tytuł wycieczki')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('destination')
                            ->label('Cel podróży')
                            ->required()
                            ->maxLength(255),

                        FileUpload::make('image')
                            ->label('Zdjęcie (kliknij ołówek po wgraniu, by edytować)')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('travel-images')
                            ->columnSpanFull(),
                    ])
            ]);
    }
}
