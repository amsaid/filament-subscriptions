<?php

namespace EcolePlus\FilamentSubscription\Pages;

use Carbon\Carbon;
use EcolePlus\FilamentSubscription\Models\Feature;
use EcolePlus\FilamentSubscription\Models\PlanSubscription;
use Filament\Actions\Action;
use Filament\Pages\Page;

class ManageSubscriptionPage extends Page
{
    protected static ?string $navigationIcon = "ecoleplusicon-subscription";

    protected static string $view = "filament-subscriptions::pages.manage-subscription-page";

    public $subscription_id;

    public $saw_it = false;

    public $message;

    public $subscriptions = [];

    public $name;

    public $price;

    public $period;

    public $description;

    public $isTrial;

    public $isPaid;

    public $features;

    public function mount()
    {
        $this->getSubscribedPlan();
        $this->getAllFeatures();
        $this->getAllSubscriptions();
    }

    public function getAllFeatures()
    {
        $this->features = Feature::all();
    }

    public function getAllSubscriptions()
    {
        $this->subscriptions = app(config("filament-subscriptions.model"))
            ->planSubscriptions()
            ->latest()
            ->get();
    }

    public static function getNavigationGroup(): ?string
    {
        return __("filament-subscriptions::ui.manage_subscriptions");
    }

    public static function getNavigationLabel(): string
    {
        return __("filament-subscriptions::ui.manage_subscriptions");
    }

    public function getSubscribedPlan()
    {
        $subscription = app(config("filament-subscriptions.model"))
            ->planSubscriptions()
            ->latest()
            ->first();
        if ($subscription) {
            $this->subscription_id = $subscription->id;
            $this->name = $subscription->name;
            $this->price = $subscription->price;
            $this->description = $subscription->plan->description;
            $this->period = $subscription->plan->period;
            $this->isTrial = $subscription->isFreeSubscription();
            $this->isPaid = $subscription->is_paid;

            if ($subscription->saw_it) {
                $this->saw_it = true;
            }

            if ($this->isPaid || $this->isTrial) {
                $this->message =
                    __(
                        "filament-subscriptions::ui.the_currently_active_subscription"
                    ) .
                    " " .
                    $this->name;
            } else {
                $this->message = __(
                    "ui.your_plan_subscription_has_created_successfully"
                );
            }
        }
    }

    public function sawIt()
    {
        $subscription = PlanSubscription::find($this->subscription_id);
        if ($subscription) {
            $subscription->saw_it = Carbon::now();
            $subscription->save();
            $this->saw_it = true;
        }
    }

    protected function getActions(): array
    {
        return [
            Action::make("upgrade")
                ->label(__("filament-subscriptions::ui.upgrade_plan"))
                ->url(route("filament.admin.pages.plans-page"))
                ->color("success")
                ->icon("heroicon-o-rectangle-stack"),
        ];
    }
}
