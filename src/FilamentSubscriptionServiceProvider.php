<?php

namespace EcolePlus\FilamentSubscription;

use BladeUI\Icons\Factory;
use EcolePlus\FilamentSubscription\Commands\FilamentSubscriptionCommand;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Contracts\Container\Container;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentSubscriptionServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('filament-subscriptions')
            ->hasTranslations()
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_filament_subscriptions_table')
            ->hasCommand(FilamentSubscriptionCommand::class);
    }

    public function packageBooted(): void
    {
        FilamentAsset::register(
            [
                Css::make(
                    'filament-subscriptions-tailwindcss-styles',
                    __DIR__.'/../dist/css/style.css'
                ),
            ],
            'filament-subscriptions'
        );
    }

    public function packageRegistered(): void
    {
        $this->callAfterResolving(Factory::class, function (
            Factory $factory,
            Container $container
        ) {
            $config = $container->make('config')->get('blade-heroicons', []);

            $factory->add(
                'ecoleplus-subs-icon',
                array_merge(['path' => __DIR__.'/../resources/svg'], $config)
            );
        });
    }
}
