Laravel Blade Extensions
========================

[![Build Status](https://travis-ci.org/RobinRadic/blade-extensions.svg?branch=master)](https://travis-ci.org/RobinRadic/blade-extensions)
[![Latest Stable Version](https://poser.pugx.org/radic/blade-extensions/v/stable.svg)](https://packagist.org/packages/radic/blade-extensions)
[![Total Downloads](https://poser.pugx.org/radic/blade-extensions/downloads.svg)](https://packagist.org/packages/radic/blade-extensions)
[![Latest Unstable Version](https://poser.pugx.org/radic/blade-extensions/v/unstable.svg)](https://packagist.org/packages/radic/blade-extensions)
[![License](https://poser.pugx.org/radic/blade-extensions/license.svg)](https://packagist.org/packages/radic/blade-extensions)

Version 1.2
-----------

Laravel package providing additional Blade extensions.

Implemented, tested and documentated directives:
- [@foreach](docs/foreach.md) - Provides loop data, like `$loop->index; $loop->odd`
- @break
- @continue
- @set
- @debug
- @macro
- @partial
- @block

#### Overview of most common features
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
Add to `composer.json`
```JSON
"radic/blade-extensions": "1.*"
```

Add to `app/config/app.php` to register the service provider
```php
'Radic\BladeExtensions\BladeExtensionsServiceProvider'
```

#### Configuration
Publish the configuration file
`php artisan config:publish radic/blade-extensions`

```php

return array(
    /*
     * Blacklisting of directives. These directives will not be extended. Example:
     *
     * 'blacklist' => array('foreach', 'set', 'debug')
     */
    'blacklist' => array(),

    /*
     * Prepend and append the debug output.
     */
    'debug' => array(
        /*
         * Prepend any code in front of our variable name
         *
         * The default config also checks if Kint is installed for sweet debug output.
         * Check https://github.com/raveren/kint.
         *
         */
        'prepend' => "<h1>DEBUG OUTPUT:</h1><pre><code><?php " . (class_exists('Kint') ? "Kint::dump(" : "var_dump("),

        /*
         * Append any code behind our variable name
         */
        'append' => ") ?></code></pre>"
    )
);
```

#### Testing
- Auto generated array's using [JSON Generator](http://www.json-generator.com) with `json_decode()`
- Using [Regex101](http://regex101.com) for regex creation. Each regex string has a link to it's regex101 document


#### @debug with raveren/kint
![Screenshot](http://raveren.github.com/kint/img/preview.png)

### Copyright/License
Copyright 2014 [Robin Radic](https://github.com/RobinRadic) - [MIT Licensed](http://radic.mit-license.org)