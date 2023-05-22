# Laravel Model Setting

[![Latest Version on Packagist](https://img.shields.io/packagist/v/farzai/laravel-model-settings.svg?style=flat-square)](https://packagist.org/packages/farzai/laravel-model-settings)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/farzai/laravel-model-settings/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/farzai/laravel-model-settings/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/farzai/laravel-model-settings/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/farzai/laravel-model-settings/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/farzai/laravel-model-settings.svg?style=flat-square)](https://packagist.org/packages/farzai/laravel-model-settings)

Welcome to Laravel Model Settings, a powerful PHP library that allows you to manage settings for your models. This package is a simple yet effective tool that helps you dynamically configure your models in a Laravel application.

## Installation

You can install the package via composer:

```bash
composer require farzai/laravel-model-settings
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-model-settings-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-model-settings-config"
```

This is the contents of the published config file:

```php
// config/model-settings.php
return [
    'model' => \Farzai\ModelSettings\Model::class,
];
```

## Usage

```php
use Farzai\ModelSettings\Facades\Setting;
use App\Models\Post;

// Create a setting for a model
Setting::for(Post::class)->set('default-status', 'draft');

// Get a setting for a model
Setting::for(Post::class)->get('default-status');

// Get a setting for a model or return a default value
Setting::for(Post::class)->get('default-status', 'published');
```

Or you can use without model

```php
use Farzai\ModelSettings\Facades\Setting;

// Create a setting
Setting::set('default-status', 'draft');

// Get a setting
Setting::get('default-status');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [parsilver](https://github.com/parsilver)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
