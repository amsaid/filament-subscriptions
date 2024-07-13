<?php

namespace EcolePlus\FilamentSubscription\Resources\PlanResource\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use EcolePlus\FilamentSubscription\Resources\PlanResource;

class CreatePlan extends CreateRecord
{
    protected static string $resource = PlanResource::class;

    protected function getActions(): array
    {
        return [
            Action::make('plans')
                ->label(__('ui.plans'))
                ->url(route('filament.admin.resources.plans.index'))
                ->color('success')
                ->icon('heroicon-o-rectangle-stack'),
        ];
    }
}
