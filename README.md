![Laravel logo](http://laravel.com/assets/img/laravel-logo.png)  Laravel Blade Extensions
========================

[![Build Status](https://img.shields.io/travis/RobinRadic/blade-extensions.svg?branch=master&style=flat-square)](https://travis-ci.org/RobinRadic/blade-extensions)
[![GitHub Version](https://img.shields.io/github/tag/robinradic/blade-extensions.svg?style=flat-square&label=version)](http://badge.fury.io/gh/robinradic%2Fblade-extensions)
[![Code Coverage](https://img.shields.io/badge/coverage-100%-green.svg?style=flat-square)](http://robin.radic.nl/blade-extensions/coverage)
[![Total Downloads](https://img.shields.io/packagist/dt/radic/blade-extensions.svg?style=flat-square)](https://packagist.org/packages/radic/blade-extensions)
[![License](http://img.shields.io/badge/license-MIT-ff69b4.svg?style=flat-square)](http://radic.mit-license.org)

A _Laravel_ package providing additional Blade functionality. 

**Compatible with all Laravel 5.* versions.**

The package follows the FIG standards PSR-1, PSR-2, and PSR-4 to ensure a high level of interoperability between shared PHP code.

**Version 7.0**
- [**Documentation**](http://robin.radic.nl/blade-extensions) (or alternatively read it [**here**](docs/index.md) on github)
- [**Upgrade guide & Changelog**](http://robin.radic.nl/blade-extensions/changelog-upgrade-guide.html)

### Features
- Compatible with [all Laravel 5 versions](https://travis-ci.org/RobinRadic/blade-extensions)
- **20+** Configurable, extendable, replaceable, testable directives.
- Compile Blade strings **with** variables `BladeExtensions::compileString($string, array $vars = [])`

#### Directives
All directives can be disabled, extended or replaced.
- [@set / @unset](docs/directives/index.md) Setting and unsetting of values
- [@breakpoint / @debug / @dump](docs/directives/index.md) Dump values and set breakpoints in views
- [@foreach / @break / @continue](docs/directives/index.md) Loop data and extras (similair to twig `$loop`)
- [@embed](docs/directives/index.md) Think of embed as combining the behaviour of include and extends. (similair to twig `embed`)
- [@minify / @endminify](docs/directives/index.md)  Minify inline code. Supports CSS, JS and HTML.
- [@macro / @endmacro/ @macrodef](docs/directives/index.md) Defining and running macros
- [@markdown/ @endmarkdown](docs/directives/index.md)
- [@spaceless / @endspaceless](docs/directives/index.md)
- and more...
`

### Installation

#### 1. Composer
```JSON
"radic/blade-extensions": "~7.0"
```

#### 2. Laravel
```php
Radic\BladeExtensions\BladeExtensionsServiceProvider::class
```

#### 3. Console
```bash
php artisan publish --tag=config --provider="Radic\BladeExtensions\BladeExtensionsServiceProvider"
```

### Contribute 
...

### Copyright/License
Copyright 2015 [Robin Radic](https://github.com/RobinRadic) - [MIT Licensed](http://radic.mit-license.org) 
 
 
 
 
