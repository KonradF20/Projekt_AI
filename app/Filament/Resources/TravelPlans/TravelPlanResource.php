<?php

namespace App\Filament\Resources\TravelPlans;

use App\Filament\Resources\TravelPlans\Pages\CreateTravelPlan;
use App\Filament\Resources\TravelPlans\Pages\EditTravelPlan;
use App\Filament\Resources\TravelPlans\Pages\ListTravelPlans;
use App\Filament\Resources\TravelPlans\Schemas\TravelPlanForm;
use App\Filament\Resources\TravelPlans\Tables\TravelPlansTable;
use App\Models\TravelPlan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TravelPlanResource extends Resource
{
    protected static ?string $model = TravelPlan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return TravelPlanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TravelPlansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTravelPlans::route('/'),
            'create' => CreateTravelPlan::route('/create'),
            'edit' => EditTravelPlan::route('/{record}/edit'),
        ];
    }
}
