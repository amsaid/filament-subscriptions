<?php

namespace EcolePlus\FilamentSubscription\Resources\PlanFeatureResource\Pages;

use EcolePlus\FilamentSubscription\Resources\PlanFeatureResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlanFeatures extends ListRecords
{
    protected static string $resource = PlanFeatureResource::class;

    protected function getActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
