<?php

namespace EcolePlus\FilamentSubscription\Resources\PlanResource\Pages;

use EcolePlus\FilamentSubscription\Resources\PlanResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListPlans extends ListRecords
{
    protected static string $resource = PlanResource::class;

    protected function getActions(): array
    {
        return [
            Action::make("features")
                ->label(__("filament-subscriptions::ui.features"))
                ->url(route("filament.admin.resources.features.index"))
                ->color("success")
                ->icon("heroicon-o-rectangle-stack"),
            Actions\CreateAction::make()->icon("heroicon-o-rectangle-stack"),
        ];
    }
}
