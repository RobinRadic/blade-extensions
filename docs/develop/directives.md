---
title: Directives
subtitle: Develop
---

Directives Development
======================

Creating directives
-------------------

Create a class that implements `Radic\BladeExtensions\Directives\DirectiveInterface` or extends `Radic\BladeExtensions\Directives\AbstractDirective`. 

```php
namespace App\Directives;

use Radic\BladeExtensions\Directives\AbstractDirective;

class IfSectionDirective extends AbstractDirective {
    protected $replace = '$1<?php if($section){ ?>$2';
}
```

Add to `config/blade-extensions.php`

```php
return [
    'directives' => [
        'ifSection' => 'App\Directives\IfSectionDirective',
        // other directives...
    ]
];

```


Examples 
--------
Check the classes in `Radic\BladeExtensions\Directives`
