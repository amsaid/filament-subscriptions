<?php

namespace EcolePlus\FilamentSubscription\Resources\FeatureResource\Pages;

use EcolePlus\FilamentSubscription\Resources\FeatureResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListFeatures extends ListRecords
{
    protected static string $resource = FeatureResource::class;

    protected function getActions(): array
    {
        return [
            Action::make("plans")
                ->label(__("filament-subscriptions::ui.plans"))
                ->url(route("filament.admin.resources.plans.index"))
                ->color("success")
                ->icon("heroicon-o-rectangle-stack"),
            Actions\CreateAction::make()->icon("heroicon-o-rectangle-stack"),
        ];
    }
}
