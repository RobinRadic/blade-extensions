## Laravel Blade Extensions
[![Build Status](https://travis-ci.org/RobinRadic/blade-extensions.svg?branch=master)](https://travis-ci.org/RobinRadic/blade-extensions)
[![Latest Stable Version](https://poser.pugx.org/radic/blade-extensions/v/stable.svg)](https://packagist.org/packages/radic/blade-extensions)
[![Total Downloads](https://poser.pugx.org/radic/blade-extensions/downloads.svg)](https://packagist.org/packages/radic/blade-extensions)
[![Latest Unstable Version](https://poser.pugx.org/radic/blade-extensions/v/unstable.svg)](https://packagist.org/packages/radic/blade-extensions)
[![License](https://poser.pugx.org/radic/blade-extensions/license.svg)](https://packagist.org/packages/radic/blade-extensions)

Laravel package providing additional Blade extensions.

Implemented and tested directives:
- @foreach (with $loop data, like twig)
- @break
- @continue
- @set
- @debug


### Version 1.0.0beta
[View changelog and todo](https://github.com/RobinRadic/laravel-bukkit-console/blob/master/changelog.md)


#### Overview
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

#### @debug with raveren/kint
![Screenshot](http://raveren.github.com/kint/img/preview.png)

### Copyright/License
Copyright 2014 [Robin Radic](https://github.com/RobinRadic) - [MIT Licensed](http://radic.mit-license.org)