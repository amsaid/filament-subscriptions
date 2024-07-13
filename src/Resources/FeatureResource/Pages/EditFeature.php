<?php

namespace EcolePlus\FilamentSubscription\Resources\FeatureResource\Pages;

use EcolePlus\FilamentSubscription\Resources\FeatureResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditFeature extends EditRecord
{
    protected static string $resource = FeatureResource::class;

    protected function getActions(): array
    {
        return [
            Action::make('features')
                ->label(__('ui.features'))
                ->url(route('filament.admin.resources.features.index'))
                ->color('success')
                ->icon('heroicon-o-rectangle-stack'),
            Actions\DeleteAction::make()->icon('heroicon-o-rectangle-stack'),
        ];
    }
}
