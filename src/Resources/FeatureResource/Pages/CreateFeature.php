<?php

namespace IbrahimBougaoua\FilamentSubscription\Resources\FeatureResource\Pages;

use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use IbrahimBougaoua\FilamentSubscription\Resources\FeatureResource;

class CreateFeature extends CreateRecord
{
    protected static string $resource = FeatureResource::class;
    
    protected function getActions(): array
    {
        return [
            Action::make('features')
                ->label('Features')
                ->url(route('filament.resources.features.index'))
                ->color('success')
                ->icon('heroicon-o-tag'),
        ];
    }
}
