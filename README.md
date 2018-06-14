# Laravel Twig

This library integrates Twig with the standard Laravel 5 view framework.

This library is based on [TwigBridge](https://github.com/rcrowe/TwigBridge) by [Rob Crowe](https://github.com/rcrowe).

## Install

First, install the package using Composer:

```
composer require synergitech/laravel-twig
```

Next, export the configuration:

```
php artisan vendor:publish --provider="SynergiTech\Twig\TwigServiceProvider"
```

## Extensions

Once the configration is exported, you can enable third party extensions or add your own to the list of enabled extensions.

## Usage

Once the package is installed and configured to your liking, you're good to go. Start creating your templates as `.twig` files and the package will render and cache your templates.

## Todo

- Documentation throughout
- Further refactoring
- Unit testing
