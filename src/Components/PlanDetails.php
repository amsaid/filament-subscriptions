<?php

namespace EcolePlus\FilamentSubscription\Components;

use Filament\Forms\Components\Component;
use Illuminate\Contracts\View\View;
class PlanDetails extends Component
{
    public $name;

    public $features;

    public function mount()
    {
    }

    public function render(): View
    {
        return view("filament-subscriptions::components.plan-details");
    }
}
