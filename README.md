![Laravel logo](http://laravel.com/assets/img/laravel-logo.png)  Laravel Blade Extensions
========================

[![Build Status](https://img.shields.io/travis/RobinRadic/blade-extensions.svg?branch=master&style=flat-square)](https://travis-ci.org/RobinRadic/blade-extensions)
[![GitHub Version](https://img.shields.io/github/tag/robinradic/blade-extensions.svg?style=flat-square&label=version)](http://badge.fury.io/gh/robinradic%2Fblade-extensions)
[![Code Coverage](https://img.shields.io/badge/coverage-100%-green.svg?style=flat-square)](http://robin.radic.nl/blade-extensions/coverage)
[![Total Downloads](https://img.shields.io/packagist/dt/radic/blade-extensions.svg?style=flat-square)](https://packagist.org/packages/radic/blade-extensions)
[![License](http://img.shields.io/badge/license-MIT-ff69b4.svg?style=flat-square)](http://radic.mit-license.org)


|   **Laravel**    |       ~4.2        |         5.*         |
|:----------------:|:------------------|:-------------------:|
| Blade extensions | [v2.2](tree/v2.2) | [v7.*](tree/master) |
  

The package follows the FIG standards PSR-1, PSR-2, and PSR-4 to ensure a high level of interoperability between shared PHP code.

A **Laravel** package providing additional Blade functionality. [**Thoroughly**](http://robin.radic.nl/blade-extensions/) documented and **100%** code coverage.

## Version 7.0
- [**Go to documentation website.**](http://robin.radic.nl/blade-extensions)
- [**Go to git markdown docs.**](blob/master/docs/index.md)
- [**Upgrade guide & Changelog**](http://robin.radic.nl/blade-extensions/changelog-upgrade-guide.html)
- [**Test coverage.**](http://robin.radic.nl/blade-extensions/coverage)

Blade Extensions version 7 comes with a lot of improvements compared to the previous version.
This version is compatible with all Laravel 5.* versions.

We have seen Laravel 5 implementing a lot of what Blade Extensions has to offer, namely:
- $loop inside @foreach (5.2)
- component system, like @embeds. (5.4)

## Contribute (directives)
If you have written any fancy directives, contribute them!

## Development
- The `ServiceProvider` adds the directives configuration into the `DirectiveRegistry`
- The `Hooker` adds all directives from the `DirectiveRegistry` to the `BladeCompiler`
- Directives sometimes use 'helpers', contained in the `HelperRepository`


###### Composer
```JSON
"radic/blade-extensions": "~7.0"
```

###### Laravel
```php
Radic\BladeExtensions\BladeExtensionsServiceProvider::class
```

### Copyright/License
Copyright 2015 [Robin Radic](https://github.com/RobinRadic) - [MIT Licensed](http://radic.mit-license.org) 
 
 
 
 
