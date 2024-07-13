# This is my package filament-subscriptions

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ecoleplus/filament-subs.svg?style=flat-square)](https://packagist.org/packages/ecoleplus/filament-subs)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/amsaid/filament-subscriptions/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/amsaid/filament-subscriptions/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/amsaid/filament-subscriptions/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/amsaid/filament-subscriptions/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/ecoleplus/filament-subs.svg?style=flat-square)](https://packagist.org/packages/ecoleplus/filament-subs)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us
If you like this package, consider supporting us by donating to support our development. Your support is greatly appreciated! 🙏

<a href="https://www.buymeacoffee.com/amsaid" target="_blank"><img src="https://cdn.buymeacoffee.com/buttons/v2/default-yellow.png" alt="Buy Me A Coffee" style="height: 60px !important;width: 217px !important;" ></a>

## Installation

You can install the package via composer:

```bash
composer require ecoleplus/filament-subs
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="filament-subscriptions-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-subscriptions-config"
```

This is the contents of the published config file:

```php
return [
    "currency" => " MAD",
    "model" => "App\\Models\\User",
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-subscriptions-views"
```

## Usage

```php
use EcolePlus\FilamentSubscription\Traits\PlanSubscriptions;

class User extends Authenticatable
{
    use PlanSubscriptions;
}
```
You can use the trait in any model you want as long as you have set the `model` in the config file.
## Testing

```bash
composer test
```
## Contributing

## Credits

- [Ibrahim](https://github.com/ibrahimBougaoua)
- [Said](https://github.com/amsaid)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
