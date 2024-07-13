<?php

namespace EcolePlus\FilamentSubscription\Components;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Component;

class Feature extends Component
{
    public function render(): View
    {
        return view("filament-subscriptions::components.feature");
    }
}
