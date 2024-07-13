<?php

namespace EcolePlus\FilamentSubscription\Pages;

use EcolePlus\FilamentSubscription\Models\Feature;
use EcolePlus\FilamentSubscription\Models\Plan;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class PlansPage extends Page
{
    protected static ?string $navigationIcon = 'ecoleplus-subs-icon-plan';

    protected static string $view = 'filament-subscriptions::pages.plans-page';

    public $plans = [];

    public $features = [];

    public function mount()
    {
        $this->getAllPlans();
        $this->getAllFeatures();
    }

    public function getAllPlans()
    {
        $this->plans = Plan::get();
    }

    public function getAllFeatures()
    {
        $this->features = Feature::get();
    }

    public static function getNavigationGroup(): ?string
    {
        return __('ui.manage_subscriptions');
    }

    public static function getNavigationLabel(): string
    {
        return __('ui.plans');
    }

    public function switchPlan($plan_id)
    {
        if (
            app(config('filament-subscriptions.model'))
                ->planSubscriptions()
                ->count() != 0
        ) {
            app(config('filament-subscriptions.model'))
                ->subscription()
                ->cancellation();
        }

        $plan = Plan::find($plan_id);
        $subscription = app(
            config('filament-subscriptions.model')
        )->newSubscription($plan);

        Notification::make()
            ->title(
                __('ui.switched_to').
                    ' '.
                    $subscription->name.
                    ' '.
                    __('ui.plan_successfully')
            )
            ->success()
            ->send();

        return redirect()->route(
            'filament.admin.pages.manage-subscription-page'
        );
    }

    protected function getActions(): array
    {
        return [
            Action::make('manage-subscription')
                ->label(__('ui.manage_subscription'))
                ->url(route('filament.admin.pages.manage-subscription-page'))
                ->color('success')
                ->icon('heroicon-o-rectangle-stack'),
        ];
    }
}
