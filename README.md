Laravel Blade Extensions
========================

[![Build Status](https://travis-ci.org/RobinRadic/blade-extensions.svg?branch=master)](https://travis-ci.org/RobinRadic/blade-extensions)
[![Latest Stable Version](https://poser.pugx.org/radic/blade-extensions/v/stable.svg)](https://packagist.org/packages/radic/blade-extensions)
[![Total Downloads](https://poser.pugx.org/radic/blade-extensions/downloads.svg)](https://packagist.org/packages/radic/blade-extensions)
[![Latest Unstable Version](https://poser.pugx.org/radic/blade-extensions/v/unstable.svg)](https://packagist.org/packages/radic/blade-extensions)
[![License](https://poser.pugx.org/radic/blade-extensions/license.svg)](https://packagist.org/packages/radic/blade-extensions)

Version 1.2
-----------

Laravel package providing additional Blade functionality.

- **@set @unset** Setting and unsetting of values
- **@foreach @break @continue** Loop data and extras
- **@partial @block @render** Creating view partials and blocks. Nest them, extend them, render them.
- **@macro** Defining and running macros
- **@debug** Debugging values in views
- **BladeViewTestingTrait** enables all assert methods from your test class in your view as directives. `@assertTrue($hasIt)..`

[**Check the documentation for all features and options**](http://robinradic.github.io/blade-extensions/)

#### Requirements
- PHP > 5.3
- Laravel > 4.0
- (optional) raveren/kint > 0.9.1

#### Installation
You probably know what to do with these:
```JSON
"radic/blade-extensions": "1.*"
```
```php
'Radic\BladeExtensions\BladeExtensionsServiceProvider'
```

### Copyright/License
Copyright 2014 [Robin Radic](https://github.com/RobinRadic) - [MIT Licensed](http://radic.mit-license.org)
