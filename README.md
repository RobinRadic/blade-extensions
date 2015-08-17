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
| Blade extensions | [v2.2](tree/v2.2) | [v3.0](tree/v3.0) | [v5.0](tree/master) |
  
**Laravel** package providing additional Blade functionality. [**Thoroughly**](http://docs.radic.nl/blade-extensions/) documented and **100%** code coverage.


- **@set @unset** Setting and unsetting of values
- **@foreach @break @continue** Loop data and extras (similair to twig `$loop`)
- **@embed** Think of embed as combining the behaviour of include and extends. (similair to twig `embed`)
- **@debug @breakpoint** Dump values and set breakpoints in views
- **@macro** (optional) Defining and running macros (requires [laravelcollective/html](https://github.com/erusev/parsedown))
- **@markdown** (optional) Render github flavoured markdown with your preffered renderer by using the directives or view engine/compilers. (optional, requires [erusev/parsedown](https://github.com/erusev/parsedown) or [kzykhys/ciconia](https://github.com/kzykhys/Ciconia))
- **@minify** (optional) Minify inline code. Supports CSS, JS and HTML.
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
"caffeinated/beverage": "~3.0"
```
  
###### Suggested
```JSON
"raveren/kint":             "Improved @debug output (1.0.*)",
"laravelcollective/html":   "Enables the use of @macro directives (~5.0)",
"erusev/parsedown":         "Enables the use of @markdown directives (~1.5)",
"matthiasmullie/minify":    "Enables the use of @minify directives (~1.3)"
```
  
  
###### Composer
```JSON
"radic/blade-extensions": "~5.0"
```

###### Laravel
```php
Radic\BladeExtensions\BladeExtensionsServiceProvider::class
```


#### Examples


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

// xdebug_break breakpoints (configurable) to debug compiled views. Sweet? YES!
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

#### Inline minification
Adding `"matthiasmullie/minify": "~1.3"` will automaticly enable the `@minify` directive.

###### Javascript
```php
<script>
    @minify('js')
    var exampleJavascript = {
        this: 'that',
        foo: 'bar',
        doit: function(){
            console.log('yesss');
        }
    };
    @endminify
</script>
```

###### CSS
```php
<style type="text/css">
    @minify('css')      
    a.bg-primary:hover,
    a.bg-primary:focus {
      background-color: #286090;
    }
    
    .bg-success {
      background-color: #dff0d8;
    }
    
    a.bg-success:hover,
    a.bg-success:focus {
      background-color: #c1e2b3;
    }
    @endminify
</style>
```

###### HTML
```php
@minify('html')
<div class="block-loading">
    <div id="block-loader">
        <div class="loader loader-block"></div>
    </div>
    <div class="i-want-this-to-have-a-loader block-loader-content">

    </div>
</div>
@endminify
```


#### Lot of @embed examples
Notice that the following examples aren't really consistent with yield/variable usage, which is intended for showcase.

**components/box.blade.php**
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

**components/tabs.blade.php**
```php
<div class="tabbable {{ isset($boxed) && $boxed === true ? 'tabs-boxed' :' ' }} tabs-@yield('side', 'left')">

    <ul class="nav nav-tabs">
        @foreach($tabs as $id => $tab)
            <li class="{{ isset($tab['active']) && $tab['active'] === true ? 'active' : '' }}" >
                <a data-toggle="tab" href="#{{ $id }}" aria-expanded="true">
                    @if(isset($tab['icon']))
                    <i class="tab-icon fa {{ $tab['icon'] }}"></i>
                    @endif
                    @if(isset($tab['text']))
                        {{ $tab['text'] }}
                    @endif
                </a>
            </li>
        @endforeach
    </ul>
    <div class="tab-content">
        @foreach($tabs as $id => $tab)
            <div id="{{ $id }}" class="tab-pane fade {{ isset($tab['active']) && $tab['active'] === true ? 'active' : '' }} in">
                @yield($id)
            </div>
        @endforeach
    </div>

</div>
```

**components/timeline.blade.php**
```php
<ul class="@yield('class', 'small-timeline')">
    @yield('items')
</ul>
```

**components/timeline-item.blade.php**
```php
<li class="@yield('color', 'lime')">
    <div class="timeline-icon"></div>
    <div class="timeline-body">
        <div class="timeline-content">
            @if(isset($name))
                <a href="@yield('name-href', '#')" class="name">{{ $name }}</a>
            @endif
            @yield('text')
            <span class="time"><i class="fa fa-clock-o"></i>@yield('time-ago')</span>
        </div>
    </div>
</li>
```

**index.blade.php**
```php
@extends('layouts/default')

@section('content')
    <div class="row">
        <div class="col-md-6">
            @embed('components/box')
                @section('title', 'Box title')
                @section('section-class', 'p-n')
                @section('content')

                    @embed('components/tabs', [
                        'boxed' => true,
                        'tabs' => [
                            'first' => [ 'icon' => 'text-green fa-pencil-square-o', 'text' => 'First tab', 'active' => true ],
                            'second' => [ 'icon' => 'text-amber fa-puzzle-piece', 'text' => 'Second' ]
                        ]
                    ])
                        @section('side', 'right')
                        @section('first')
                            <p>First tab contents</p>
                            <p>Cur humani generis manducare?</p>
                            <p>The simple peace of sainthood is to invent with purpose.</p>
                        @stop
                        @section('second')
                            <p>Observare semper ducunt ad teres byssus.</p>
                            <p>Protons malfunction with advice at the ugly habitat cunninglyshields up!</p>
                            <p>Boil small chickpeas in a sauté pan with hollandaise sauce for about an hour to soothe their sweetness.</p>
                        @stop
                    @endembed

                @stop
            @endembed
        </div>
        <div class="col-md-6">
            @embed('components/box')
                @section('title', 'Box2 title')
                @section('content')
                    <p>Box 2 content</p>

                    @embed('components/timeline')
                        @section('items')

                            @embed('components/timeline-item', ['name' => 'Working good'])
                                @section('text', 'Not so fast please')
                                @section('time-ago', '5 minutes ago')
                            @endembed
                            @embed('components/timeline-item', ['name' => 'Robin RAdic'])
                                @section('color', 'yellow')
                                @section('text', 'Created a new github issue')
                                @section('time-ago', '2 days ago')
                            @endembed

                        @stop
                    @endembed
                @stop
            @endembed
        </div>
    </div>
@stop

```

### Copyright/License
Copyright 2015 [Robin Radic](https://github.com/RobinRadic) - [MIT Licensed](http://radic.mit-license.org) 
 
 
 
 
