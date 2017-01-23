---
title: Home
subtitle: Blade Extensions overview
---
## Introduction
Blade Extensions is a **Laravel** package providing additional Blade functionality.  
It mainly consists out of Blade directives.

### Quick Example: A few directives
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

// Minify this very big script
<script>
@minify('js')
window.blade = { foo: 'bar', date: new Date() }
@endminify
</script>
```

### Quick Example: Configuration
The configuration has come a long way. Lets have this example speak for itself!
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

#### Copyright/License
Copyright 2015 [Robin Radic](https://github.com/RobinRadic) - [MIT Licensed](http://radic.mit-license.org)
