---
title: Debug
subtitle: '@breakpoint @debug'
---

#### @breakpoint
The `@breakpoint` directive is a convienient way to place debugger breakpoints inside your views. 
By default it uses `xdebug_break`, but can easily be changed using the config file:
```php
return array(
    'overrides' => array(
        'breakpoint' => array(
            // Default replacement, change if other debugger is used.
            'replacement' => '<?php if(function_exists('xdebug_break')){ var_dump(xdebug_break()); } ?>'
        )
    )
);
```

#### @debug
The `@debug($var)` directive will dump the `$var` using the either `raveren/kint`, Symfony's `VarDumper` or the regular `var_dump` method. 
