Laravel Blade Extensions
========================

[![Build Status](https://travis-ci.org/RobinRadic/blade-extensions.svg?branch=master)](https://travis-ci.org/RobinRadic/blade-extensions)
[![GitHub version](https://badge.fury.io/gh/robinradic%2Fblade-extensions.svg)](http://badge.fury.io/gh/robinradic%2Fblade-extensions)
[![Goto documentation](http://img.shields.io/badge/goto-documentation-orange.svg)](http://robinradic.github.io/blade-extensions)
[![Goto repository](http://img.shields.io/badge/goto-repository-orange.svg)](https://github.com/robinradic/blade-extensions)
[![License](http://img.shields.io/badge/license-MIT-blue.svg)](http://radic.mit-license.org)

Version 2.0
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
- PHP > 5.4
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
