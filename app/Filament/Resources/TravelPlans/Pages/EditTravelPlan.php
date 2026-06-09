<?php

namespace App\Filament\Resources\TravelPlans\Pages;

use App\Filament\Resources\TravelPlans\TravelPlanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTravelPlan extends EditRecord
{
    protected static string $resource = TravelPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
