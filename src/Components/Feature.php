<?php

namespace EcolePlus\FilamentSubscription\Components;

use Filament\Forms\Components\Component;
use Illuminate\Contracts\View\View;

class Feature extends Component
{
    public function render(): View
    {
        return view('filament-subscriptions::components.feature');
    }
}
