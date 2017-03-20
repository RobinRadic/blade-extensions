---
title: Configuration
subtitle: Getting Started
---

Configuration
=============
Using the published configuration file `config/blade-extensions.php`

## Directives

> Tip: Comment out all directives you won't be using.

- Directives are named in the configuration file. So you can easily transform (for example) `@markdown` to `@md`.  
- Directives are either class paths, class paths with @ sign or closures.
- `optional` directives are only used for **unit-testing**
- If you want to use any of the `optional` directives, you have to **manually copy/paste** them to `directives`.

```php
[                                                                                                                                                                                                                                            
    'directives' => [
        // prefered, will call the 'handle' function. 
        'directiveName' => 'Full\\Qualified\\Class\\Path',
        
        // alternatively you can let it call some other function
        'directiveName2' => 'Full\\Qualified\\Class\\Path@fire',
        
        // Also possible to use a closure. Not advisable 
        'directiveName3' => function($value){
            return 'value: ' . ((int) $value + 50); 
        }
    ],
    'optional'          => [
        // prefered, will call the 'handle' function. 
        'directiveName4' => 'Full\\Qualified\\Class\\Path',
        
        // alternatively you can let it call some other function
        'directiveName5' => 'Full\\Qualified\\Class\\Path@fire',
        
        // Also possible to use a closure. Not advisable 
        'directiveName6' => function($value){
            return 'value: ' . ((int) $value + 50); 
        }
    ]
];
```


## Version overrides
Override configured directives based on Laravel version. It uses [Composers version constraints](https://getcomposer.org/doc/articles/versions.md).

> Tip: You can try/test version constraints using [semver.mwl.be](https://semver.mwl.be/).

```php
[
    'version_overrides' => [
        '5.0.*' => [
            // will override the 'directiveName' directive defined in 'directives'
            // Only for Laravel 5.0.*. 
            'directiveName' => 'Full\\Qualified\\Class\\Path\\To\\L50\\Override',            
        ],
        '>=5.3' => [
            // will override the 'directiveName' directive defined in 'directives'
            // Laravel 5.3 and upwards 
            'directiveName' => 'Full\\Qualified\\Class\\Path\\To\\L53\\Override',
        ]
    ]
]
```
