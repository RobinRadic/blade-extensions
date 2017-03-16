---
title: Installation
subtitle: Getting Started
---

Installation
============

## 1. Composer
Add the `radic/blade-extensions` package to your composer.json dependencies.
```json
"require": {
    "radic/blade-extensions": "~7.0"
}
```

## 2. Laravel
Register the `BladeExtensionsServiceProvider` in your application, preferably in your `config/app.php` file.
```php
'providers' => [
    Radic\BladeExtensions\BladeExtensionsServiceProvider::class
]
```

## 3. Publish config
```sh
php artisan vendor:publish --provider=Radic\BladeExtensions\BladeExtensionsServiceProvider
```

