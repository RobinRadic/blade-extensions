---
title: Configuration
---

## config/blade-extensions.php
### mode
This is used internally to bind the directives defined in `blade-extensions.directives 
#### auto
`'mode' => 'auto'`
#### custom
`'mode' => 'custom'`
#### none
`'mode' => 'disabled'`


### directives
```php
[                                                                                                                                                                                                                                            
    'directives' => [
        // prefered, will call the 'handle' function. 
        'directiveName' => 'Full\\Qualified\\Class\\Path',
        
        // alternatively you can let it call some other function
        'directiveName2' => 'Full\\Qualified\\Class\\Path@fire',
        
        // Also possible, but shouldn't really 
        'directiveName3' => function($value){
    
        }
    ]
];
```


