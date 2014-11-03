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

- [@set @unset](docs/set.html) Setting and unsetting of values
- [@foreach @break @continue](docs/foreach.html) Loop data and extras
- [@partial @block @render](docs/partials.html) Creating view partials and blocks. Nest them, extend them, render them.
- [@macro](docs/macro.html) Defining and running macros
- [@debug](docs/debug.html) Debugging values in views
- [BladeViewTestingTrait](docs/testViews.html) enables all assert methods from your test class in your view as directives. `@assertTrue($hasIt)..`

[**Check the documentation for all features and options**](docs/.index.md)

#### Overview of some features
```php
@foreach($stuff as $key => $val)
    $loop->index;       // int, zero based
    $loop->index1;      // int, starts at 1
    $loop->revindex;    // int
    $loop->revindex1;   // int
    $loop->first;       // bool
    $loop->last;        // bool
    $loop->even;        // bool
    $loop->odd;         // bool
    $loop->length;      // int

    @break

    @continue
@endforeach

@set('newvar', 'value')
{{ $newvar }}


@debug($somearr)

@macro('settings_field')
    <div class="form-group{{ $field['errors']->first($field['slug'], ' has-error') }}">
        <label for="{{ $field['name'] }}" class="control-label col-md-3"> {{{ $field['title'] }}}</label>
        <div class="col-md-9">
            {{ $field->render() }}
            <span class="help-block">{{ $field['errors']->has($field['slug']) ? $field['errors']->first($field['slug'], ':message') : $field['help']  }}</span>
        </div>
    </div>
@endmacro

@macro('settings_field', ['form' => $form, 'field' => $field])
```

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