<?php

namespace EcolePlus\FilamentSubscription\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \EcolePlus\FilamentSubscription\FilamentSubscription
 */
class FilamentSubscription extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \EcolePlus\FilamentSubscription\FilamentSubscription::class;
    }
}
