<?php

namespace EcolePlus\FilamentSubscription;

use EcolePlus\FilamentSubscription\Pages\ManageSubscriptionPage;
use EcolePlus\FilamentSubscription\Pages\PlansPage;
use EcolePlus\FilamentSubscription\Resources\FeatureResource;
use EcolePlus\FilamentSubscription\Resources\PlanResource;
use EcolePlus\FilamentSubscription\Resources\PlanSubscriptionsResource;
use EcolePlus\FilamentSubscription\Widgets\SubscriptionsOverview;
use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentSubscriptionPlugin implements Plugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'filament-subscriptions';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                PlanResource::class,
                FeatureResource::class,
                PlanSubscriptionsResource::class,
            ])
            ->pages([ManageSubscriptionPage::class, PlansPage::class])
            ->widgets([SubscriptionsOverview::class]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
