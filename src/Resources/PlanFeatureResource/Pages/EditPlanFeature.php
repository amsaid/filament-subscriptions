<?php

namespace EcolePlus\FilamentSubscription\Resources\PlanFeatureResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use EcolePlus\FilamentSubscription\Resources\PlanFeatureResource;

class EditPlanFeature extends EditRecord
{
    protected static string $resource = PlanFeatureResource::class;

    protected function getActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
