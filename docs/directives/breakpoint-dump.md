---
title: Debugging directives
subtitle: '@breakpoint @debug @dump'
---

Debugging directives
====================


@breakpoint
-----------
The `@breakpoint` directive is a convienient way to place debugger breakpoints inside your views. 
By default it uses `xdebug_break` but can be modified before the application is `booted`:
```php
Radic\BladeExtensions\Directives\BreakpointAbstractDirective::setFunction('other_breakpoint_function_name');
```


@dump
------

1. The `@dump()` directive will dump the entire view environment.
2. The `@dump($var)` directive will dump the `$var`.
 
Using the either `raveren/kint`, Laravels `HtmlDumper`, Symfony's `VarDumper` or the regular `var_dump` method. 

#### Kint?
By installing the `raveren/kint` package. The debug output will be greatly improved. For more information, check out [this page](https://github.com/raveren/kint).
```json
"require": {
    "raveren/kint": "~1.0"
}
```

![Kint CLI output](http://i.imgur.com/6B9MCLw.png)
![Kint displays data intelligently](http://i.imgur.com/9P57Ror.png)
![Kint themes](http://raveren.github.io/kint/img/theme-preview.png)
![Kint profiling feature](http://i.imgur.com/tmHUMW4.png)
