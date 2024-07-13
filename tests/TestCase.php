<?php

namespace EcolePlus\FilamentSubscription\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use EcolePlus\FilamentSubscription\FilamentSubscriptionServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn(
                string $modelName
            ) => "EcolePlus\\FilamentSubscription\\Database\\Factories\\" .
                class_basename($modelName) .
                "Factory"
        );
    }

    protected function getPackageProviders($app)
    {
        return [FilamentSubscriptionServiceProvider::class];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set("database.default", "testing");

        /*
        $migration = include __DIR__.'/../database/migrations/create_filament-subscriptions_table.php.stub';
        $migration->up();
        */
    }
}
