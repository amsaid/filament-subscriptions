<?php

namespace EcolePlus\FilamentSubscription\Widgets;

use Carbon\Carbon;
use EcolePlus\FilamentSubscription\Models\PlanSubscription;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class SubscriptionsOverview extends BaseWidget
{
    protected int|string|array $columnSpan = "full";

    protected function getCards(): array
    {
        $profit_today = PlanSubscription::whereDate(
            "created_at",
            Carbon::now()->today()
        )->sum("price");

        $profit_today_data = Trend::model(PlanSubscription::class)
            ->between(start: now()->subDay(), end: now())
            ->perDay()
            ->count();

        $profit_today_arr = [];

        foreach (
            $profit_today_data->map(fn(TrendValue $value) => $value->aggregate)
            as $key => $item
        ) {
            $profit_today_arr[] = $item;
        }

        $profit_last_week = PlanSubscription::whereDate(
            "created_at",
            Carbon::now()->subDays(7)
        )->sum("price");

        $profit_last_week_data = Trend::model(PlanSubscription::class)
            ->between(start: now()->subWeek(), end: now())
            ->perDay()
            ->count();

        $profit_last_week_arr = [];

        foreach (
            $profit_last_week_data->map(
                fn(TrendValue $value) => $value->aggregate
            )
            as $key => $item
        ) {
            $profit_last_week_arr[] = $item;
        }

        $profit_last_month = PlanSubscription::whereDate(
            "created_at",
            Carbon::now()->subMonth()
        )->sum("price");

        $profit_last_month_data = Trend::model(PlanSubscription::class)
            ->between(start: now()->subMonth(), end: now())
            ->perDay()
            ->count();

        $profit_last_month_arr = [];

        foreach (
            $profit_last_month_data->map(
                fn(TrendValue $value) => $value->aggregate
            )
            as $key => $item
        ) {
            $profit_last_month_arr[] = $item;
        }

        $profit_last_year = PlanSubscription::whereDate(
            "created_at",
            Carbon::now()->subYear()
        )->sum("price");

        $profit_last_year_data = Trend::model(PlanSubscription::class)
            ->between(start: now()->subYear(), end: now())
            ->perDay()
            ->count();

        $profit_last_year_arr = [];

        foreach (
            $profit_last_year_data->map(
                fn(TrendValue $value) => $value->aggregate
            )
            as $key => $item
        ) {
            $profit_last_year_arr[] = $item;
        }

        $currency =
            __("filament-panels::layout.direction") === "rtl"
                ? "دج"
                : config("filament-subscriptions.currency");

        return [
            Stat::make(
                __("filament-subscriptions::ui.today"),
                $profit_today . $currency
            )
                ->description(__("filament-subscriptions::ui.profit_today"))
                ->descriptionIcon("heroicon-o-rectangle-stack")
                ->chart($profit_today_arr)
                ->color("success"),
            Stat::make(
                __("filament-subscriptions::ui.last_week"),
                $profit_last_week . $currency
            )
                ->description(__("filament-subscriptions::ui.profit_last_week"))
                ->descriptionIcon("heroicon-o-rectangle-stack")
                ->chart($profit_last_week_arr)
                ->color("success"),
            Stat::make(
                __("filament-subscriptions::ui.last_month"),
                $profit_last_month . $currency
            )
                ->description(
                    __("filament-subscriptions::ui.profit_last_month")
                )
                ->descriptionIcon("heroicon-o-rectangle-stack")
                ->chart($profit_last_month_arr)
                ->color("success"),
            Stat::make(
                __("filament-subscriptions::ui.last_year"),
                $profit_last_year . $currency
            )
                ->description(__("filament-subscriptions::ui.profit_last_year"))
                ->descriptionIcon("heroicon-o-rectangle-stack")
                ->chart($profit_last_year_arr)
                ->color("success"),
        ];
    }
}
