<?php

namespace EcolePlus\FilamentSubscription\Resources\PlanFeatureResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use EcolePlus\FilamentSubscription\Resources\PlanFeatureResource;

class ListPlanFeatures extends ListRecords
{
    protected static string $resource = PlanFeatureResource::class;

    protected function getActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
