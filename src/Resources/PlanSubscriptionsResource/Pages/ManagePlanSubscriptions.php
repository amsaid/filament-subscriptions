<?php

namespace EcolePlus\FilamentSubscription\Resources\PlanSubscriptionsResource\Pages;

use EcolePlus\FilamentSubscription\Models\PlanSubscription;
use EcolePlus\FilamentSubscription\Resources\PlanSubscriptionsResource;
use EcolePlus\FilamentSubscription\Widgets\SubscriptionsOverview;
use Filament\Actions\Action;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Builder;

class ManagePlanSubscriptions extends ManageRecords
{
    protected static string $resource = PlanSubscriptionsResource::class;

    protected function getActions(): array
    {
        return [
            Action::make("plans")
                ->label(__("filament-subscriptions::ui.plans"))
                ->url(route("filament.admin.resources.plans.index"))
                ->color("success")
                ->icon("heroicon-o-rectangle-stack"),
            Action::make("features")
                ->label(__("filament-subscriptions::ui.features"))
                ->url(route("filament.admin.resources.features.index"))
                ->color("success")
                ->icon("heroicon-o-rectangle-stack"),
        ];
    }

    protected function getTableQuery(): Builder
    {
        return PlanSubscription::query()->latest();
    }

    protected function getHeaderWidgets(): array
    {
        return [SubscriptionsOverview::class];
    }
}
