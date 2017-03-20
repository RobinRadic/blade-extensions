---
title: Overview
subtitle: Blade Extensions 
---
# Overview

## Documentation Pages

- Prologue
  - [Changelog & Upgrade Guide](prologue/changelog-upgrade-guide.md)
  - [Contribution guidelines](prologue/changelog-upgrade-guide.md)
- Getting Started
  - [Installation](getting-started/installation.md)
  - [Configuration](getting-started/configuration.md)
- Features
  - [Compile String](features/compile-string.md) Compiles Blade strings **with** variables
  - [Push To Stack](features/push-to-stack.md) Programatically push content to a stack inside blade views. 
- Directives  
  - [@set / @unset](directives/set-unset.md) Setting and unsetting of values
  - [@breakpoint / @dump](directives/breakpoint-dump.md) Dump values to screen and set breakpoints in views
  - [@foreach / @break / @continue](directives/foreach-break-continue.md) Loop data and extras (similair to twig `$loop`)
  - [@embed](directives/embed.md) Think of embed as combining the behaviour of include and extends. (similair to twig `embed`)
  - [@minify / @endminify](directives/minify.md)  Minify inline code. Supports CSS, JS and HTML.
  - [@macro / @endmacro/ @macrodef](directives/macro.md) Defining and running macros
  - [@markdown/ @endmarkdown](directives/markdown.md) Render markdown content
  - [@spaceless / @endspaceless](directives/spaceless.md) Render the content without spaces
  - [@ifsection](directives/ifsection.md) check section
- Develop
  - [Overview](develop/overview.md) Explains how `BladeExtensions` is structured and executed. 
  - [Directives](develop/directives.md) Explains how to add, extend and test directives.
  
   

## Quick example of all directives
```blade
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
    $loop->depth;       // int
    
    // aliases (to match/support laravel 5.4 changes)
    $loop->count;       // $loop->length
    $loop->remaining;   // $loop->revindex1
    $loop->iteration;   // $loop->index1

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



// Assignment
@set('newvar', 'value')
{{ $newvar }}
@unset('newvar')
@unset($newvar)



// var_dump or HTMLDumper or....
@debug($somearr)

// xdebug_break breakpoints (configurable) to debug compiled views. Sweet? YES!
@breakpoint


// Parse some markdown code
@markdown
** with some bold text too **
@endmarkdown 



// Minification of inline code
@minify('html')
<html>
    <body>HTML To Minify</body>
</html>
@endminify

<script>
@minify('js')
window.blade = { foo: 'bar', date: new Date() }
@endminify
</script>

<style>
@minify('css')
body {
    color: blue;
}
@endminify
</style>
```

## Quick Example: Configuration
Lets have this example speak for itself. 
```php

return [
    'directives'        => [
        'set'        => 'Radic\\BladeExtensions\\Directives\\SetDirective',
        'unset'      => 'Radic\\BladeExtensions\\Directives\\UnsetDirective',
        'breakpoint' => 'App\\Directives\\MyBreakpointDirective',
        'foreach'    => 'Radic\\BladeExtensions\\Directives\\ForeachDirective',
        'endforeach' => 'Radic\\BladeExtensions\\Directives\\EndforeachDirective',
        'break'      => 'Radic\\BladeExtensions\\Directives\\BreakDirective',
        // ....
        
        // prefered, will call the 'handle' function. 
        'directiveName' => 'Full\\Qualified\\Class\\Path',
        
        // alternatively you can let it call some other function
        'directiveName2' => 'Full\\Qualified\\Class\\Path@fire',
        
        // Also possible, but shouldn't really 
        'directiveName3' => function($value){}
        
        // Blade Extensions will feature a lot of optional directives, you'd have to enable them
        // manually by uncommenting 
        //'spaceless' => 'Radic\\BladeExtensions\\Directives\\SpacelessDirective',
        //'endspaceless' => 'Radic\\BladeExtensions\\Directives\\EndspacelessDirective',
    ],
    // `optional` directives are only used for **unit-testing**
    // If you want to use any of the `optional` directives, you have to **manually copy/paste** them to `directives`.
    'optional' => [       
        // prefered, will call the 'handle' function. 
        'directiveName' => 'Full\\Qualified\\Class\\Path',
        
        // alternatively you can let it call some other function
        'directiveName2' => 'Full\\Qualified\\Class\\Path@fire',
        
        // Also possible, but shouldn't really 
        'directiveName3' => function($value){}        
    ],
    
    // For most people, Version Overrides aren't interesting.
    'version_overrides' => [
        // 5.0 behaves a bit differently, so we react to it. (imginary issue provided as example)
        '5.0' => [
            'foreach'    => 'Radic\\BladeExtensions\\Directives\\Laravel50\\ForeachDirective',
        ],
        '5.1' => [
        ],
        // 5.2 introduced @break and @continue
        '5.2' => [
            'break'    => null,
            'continue' => null,
        ],
        // 5.3 introduced the loop variable for the @foreach directive.
        '5.3' => [
            'foreach'    => null,
            'endforeach' => null,
            'break'      => null,
            'continue'   => null,
        ],
    ],
];
```

## Copyright/License
Copyright 2015 [Robin Radic](https://github.com/RobinRadic) - [MIT Licensed](http://radic.mit-license.org)
