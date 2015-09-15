![Laravel logo](http://laravel.com/assets/img/laravel-logo.png)  Laravel Blade Extensions
========================

[![Build Status](https://img.shields.io/travis/RobinRadic/blade-extensions.svg?branch=master&style=flat-square)](https://travis-ci.org/RobinRadic/blade-extensions)
[![GitHub Version](https://img.shields.io/github/tag/robinradic/blade-extensions.svg?style=flat-square&label=version)](http://badge.fury.io/gh/robinradic%2Fblade-extensions)
[![Code Coverage](https://img.shields.io/badge/coverage-100%-green.svg?style=flat-square)](http://robin.radic.nl/blade-extensions/coverage)
[![Total Downloads](https://img.shields.io/packagist/dt/radic/blade-extensions.svg?style=flat-square)](https://packagist.org/packages/radic/blade-extensions)
[![License](http://img.shields.io/badge/license-MIT-ff69b4.svg?style=flat-square)](http://radic.mit-license.org)


| **Laravel** | ~4.2 | 5.0 | 5.1 |
|:-----------:|:----:|:---:|:----:|
| Blade extensions | [v2.2](tree/v2.2) | [v3.0](tree/v3.0) | [v6.0](tree/master) |
  
**Laravel** package providing additional Blade functionality. [**Thoroughly**](http://robin.radic.nl/blade-extensions/) documented and **100%** code coverage.


- **@set @unset** Setting and unsetting of values
- **@foreach @break @continue** Loop data and extras (similair to twig `$loop`)
- **@embed** Think of embed as combining the behaviour of include and extends. (similair to twig `embed`)
- **@debug @breakpoint** Dump values and set breakpoints in views
- **@macro** Defining and running macros
- **@markdown** (optional) Render github flavoured markdown with your preffered renderer by using the directives or view engine/compilers. (optional, requires [erusev/parsedown](https://github.com/erusev/parsedown) or [kzykhys/ciconia](https://github.com/kzykhys/Ciconia))
- **@minify** (optional) Minify inline code. Supports CSS, JS and HTML.
- **BladeString** Render blade strings using the facade `BladeString::render('my val: {{ $val }}', array('val' => 'foo'))`


## 6.0 Released
[**Rewritten and fully updated documentation.**](http://robin.radic.nl/blade-extensions)
Major improvements - Added and updated tests. 

  
###### Composer
```JSON
"radic/blade-extensions": "~5.0"
```

###### Laravel
```php
Radic\BladeExtensions\BladeExtensionsServiceProvider::class
```

[**Go to documentation website.**](http://robin.radic.nl/blade-extensions)
[**Go to git markdown docs.**](blob/master/docs/index.md)

### Copyright/License
Copyright 2015 [Robin Radic](https://github.com/RobinRadic) - [MIT Licensed](http://radic.mit-license.org) 
 
 
 
 
