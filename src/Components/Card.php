<?php

namespace EcolePlus\FilamentSubscription\Components;

use Filament\Forms\Components\Component;
use Illuminate\Contracts\View\View;

class Card extends Component
{
    public function render(): View
    {
        return view('filament-subscriptions::components.card');
    }
}
