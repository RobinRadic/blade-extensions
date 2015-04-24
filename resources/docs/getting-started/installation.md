<!---
title: Installation
author: Robin Radic
icon: fa fa-legal
-->

#### Requirements
```JSON
"PHP": ">=5.4.0",
"illuminate/support": "~5.0"
```

#### Recommended
```JSON
"illuminate/html": "~5.0",
"raveren/kint": ">=0.9.1"
```

#### Composer
Add the following line to your composer.json file
```JSON
"radic/blade-extensions": "2.*"
```

#### Laravel
Add the following line to your config/app.php file, in the `Service Provider` config block.
```php
'Radic\BladeExtensions\BladeExtensionsServiceProvider'
```

#### Illuminate/html
Having this package will enable the macro directives.

#### Raveren/kint
Having this package will beautify the @debug directive output. An example:
  
![Kint](https://camo.githubusercontent.com/178d6772f1ca114c2c344e2d75f5fb29b801cdf6/687474703a2f2f7261766572656e2e6769746875622e636f6d2f6b696e742f696d672f707265766965772e706e67)
