![Laravel logo](http://laravel.com/assets/img/laravel-logo.png)  Laravel Blade Extensions
========================

[![Build Status](https://img.shields.io/travis/RobinRadic/blade-extensions.svg?branch=master&style=flat-square)](https://travis-ci.org/RobinRadic/blade-extensions)
[![GitHub Version](https://img.shields.io/github/tag/robinradic/blade-extensions.svg?style=flat-square&label=version)](http://badge.fury.io/gh/robinradic%2Fblade-extensions)
[![Code Coverage](https://img.shields.io/badge/coverage-100%-green.svg?style=flat-square)](http://robin.radic.nl/blade-extensions/coverage)
[![Total Downloads](https://img.shields.io/packagist/dt/radic/blade-extensions.svg?style=flat-square)](https://packagist.org/packages/radic/blade-extensions)
[![License](http://img.shields.io/badge/license-MIT-ff69b4.svg?style=flat-square)](http://radic.mit-license.org)

[![Goto Documentation](http://img.shields.io/badge/goto-docs-orange.svg?style=flat-square)](http://docs.radic.nl/blade-extensions)
[![Goto API Documentation](https://img.shields.io/badge/goto-api--docs-orange.svg?style=flat-square)](http://radic.nl:8080/job/blade-extensions/PHPDOX_Documentation/)
[![Goto Repository](http://img.shields.io/badge/goto-repo-orange.svg?style=flat-square)](https://github.com/robinradic/blade-extensions)


| **Laravel** | ~4.2 | 5.0 | 5.1 |
|:-----------:|:----:|:---:|:----:|
| Blade extensions | [v2.2](tree/v2.2) | [v3.0](tree/v3.0) | [v4.1](tree/master) |
  
**Laravel** package providing additional Blade functionality. [**Thoroughly**](http://docs.radic.nl/blade-extensions/) documented and **100%** code coverage.


- **@set @unset** Setting and unsetting of values
- **@foreach @break @continue** Loop data and extras (similair to twig `$loop`)
- **@embed** Think of embed as combining the behaviour of include and extends. (similair to twig `embed`)
- ~~**@partial @block @render** Creating view partials and blocks. Nest them, extend them, render them.~~ deprecated and will not be included in the next major version. Instead, use @embed
- **@debug @breakpoint** Dump values and set breakpoints in views
- **@macro** Defining and running macros (optional, requires [laravelcollective/html](https://github.com/erusev/parsedown))
- **@markdown** Render github flavoured markdown with your preffered renderer by using the directives or view engine/compilers. (optional, requires [erusev/parsedown](https://github.com/erusev/parsedown) or [kzykhys/ciconia](https://github.com/kzykhys/Ciconia))
- **BladeString** Render blade strings using the facade `BladeString::render('my val: {{ $val }}', array('val' => 'foo'))`

## My other Laravel packages
| Package | Description | |
|----|----|----|
| [Themes](https://github.com/laradic/themes) | L5 Theme package, providing multi-theme inherited cascading support. Works with PHP, Blade, Twig, etc. Includes asset management (Dependable assets or asset groups, caching, minification, etc), navigation & breadcrumb helpers and more. | [doc](http://docs.radic.nl/themes) |
| [Blade Extensions](https://github.com/radic/blade-extensions) | A collection of usefull Laravel blade extensions, like $loop data in foreach, view partials, etc | [doc](http://docs.radic.nl/blade-extensions) |


#### Installation  
###### Requirements
```JSON
"PHP": ">=5.5.9",
"illuminate/support": "~5.0"
```
  
###### Recommended
```JSON
"laravelcollective/html": "~5.0",
"raveren/kint": ">=0.9.1",
"erusev/parsedown": "~1.5"
```
  
  
###### Composer
```JSON
"radic/blade-extensions": "~4.0"
```

###### Laravel
```php
Radic\BladeExtensions\BladeExtensionsServiceProvider::class
```


#### Some examples

[**Check the documentation for all features and options**](http://docs.radic.nl/blade-extensions/)

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

    @foreach($other as $name => $age)
        $loop->parent->odd;
        @foreach($friends as $foo => $bar)
            $loop->parent->index;
            $loop->parent->parentLoop->index;
        @endforeach
    @endforeach  
    
    @break

    @continue
@endforeach

@set('newvar', 'value')
{{ $newvar }}
@unset('newvar')
@unset($newvar)


@debug($somearr)

@breakpoint

@markdown
# Some markdown code
** with some bold text too **
@endmarkdown

// including markdown files is also possible, the markdown will be converted to html. 
// Exclude the file extension of the markdown file, similair to blade.php files
@include('path/to/markdown/file')

// Beside @include, View::make('path/to/markdown/file')->render() will also work (though it would be better to use the Markdown facade / markdown ioc binding 
```

#### @embed example
**partials/box.blade.php**
```php
<div class="box @yield('box-class', 'box-style-light')">
    <header>
        <h3>@yield('title')</h3>
    </header>
    <section class="@yield('section-class')">
        @yield('content')
    </section>
</div>
```

**index.blade.php**
```php
@extends('layouts/default')

@section('content')
    
    <h1>Haai</h1>
    
    @embed('partials/box')
        @section('title', 'Box title')
        @section('content')
            Box content
        @stop
    @endembed

    <p>This is some text</p>

    @embed('partials/box')
        @section('title', 'Box2 title')
        @section('content')
            Box2 content
        @stop
    @endembed
@stop
```

### Copyright/License
Copyright 2015 [Robin Radic](https://github.com/RobinRadic) - [MIT Licensed](http://radic.mit-license.org) 
 
 
 
 
