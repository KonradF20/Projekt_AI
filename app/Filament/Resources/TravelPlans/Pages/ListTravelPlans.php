<?php

namespace App\Filament\Resources\TravelPlans\Pages;

use App\Filament\Resources\TravelPlans\TravelPlanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTravelPlans extends ListRecords
{
    protected static string $resource = TravelPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
