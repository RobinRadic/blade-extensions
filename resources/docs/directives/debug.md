<!---
title: Debug
author: Robin Radic
-->

#### Dump the value
Dumps the value, uses var_dump. If installed, uses Kint::dump. 
```php
@debug(app())
```

If you would like to change the dump output to use your own logic, open up `config/blade_extensions.php` and edit the directive output.
```php
return array(
    // ...
    'directives' => array(
        // ...
        ,'addDebug' => <<<'EOT'
<h1>DEBUG OUTPUT:</h1>
<pre><code>
    <?php (class_exists('Kint') ? Kint::dump($1) : var_dump($1)) ?>
</code></pre>
EOT
        , // ...
    )
)
```


#### Breakpoints
If you wish to insert a breakpoint (xdebug) in a view, you can do so by using 
```php
@breakpoint
```
