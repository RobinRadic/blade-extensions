<!---
title: Configuration
author: Robin Radic
icon: fa fa-legal
-->

#### Blacklisting directives
The Blade extender will ignore blacklisted directives. Use the name of the method inside the `Directives/*Directive.php`. For example:
```php
return array(
    'blacklist' => array('openForeach', 'closeForeach'),
    //....
);
```


#### Altering directives
For example; you want to edit the `@foreach` directive because you'd rather have `$loop` named `$myLoop` or you want to extend `$loop` to include more/custom data.
Blade Extensions makes this easier by having all the view replacement code in the config file:
```php
return array(
        // ....
        'openForeach' => <<<'EOT'
<?php
\Radic\BladeExtensions\Helpers\LoopFactory::newLoop($1);
foreach($1 as $2):
    $loop = \Radic\BladeExtensions\Helpers\LoopFactory::loop();
?>
EOT
        ,'closeForeach' => <<<'EOT'
$1<?php
\Radic\BladeExtensions\Helpers\LoopFactory::looped();
endforeach;
\Radic\BladeExtensions\Helpers\LoopFactory::endLoop($loop);
?>$2
EOT
);
```

Because of this approach, you can easily extend/change the helper classes or naming conventions for all directives.
