---
title: Home
subtitle: Blade Extensions overview
---
#### Introduction
Blade Extensions is a **Laravel** package providing additional Blade functionality. 
It mainly consists out of new blade directives. Highly configurable, easily extendable. 


By altering the configuration you can blacklist unwanted directives, enable/disable features or completely override directives provided by the package.


#### A few examples
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


#### Copyright/License
Copyright 2015 [Robin Radic](https://github.com/RobinRadic) - [MIT Licensed](http://radic.mit-license.org)
