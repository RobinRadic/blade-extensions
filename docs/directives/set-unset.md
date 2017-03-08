---
title: @set @unset
subtitle: Directives
---

The `@set` directive allows you to set variable values in your view. It will be added as environment variable as well (`$__env`, `$__data`).
It accepts a wide variety of input values, including multi-line arrays.
 
 
```blade
@set('main_links', [ ])
{{ empty($testArray) }} // > true

@set('main_links', [
    'Home' => url(),
    'Overview' => url(),
    'Choose' => [
        'Action' => '#',
        'Another action' => '#',
        'Something else here' => '#'
    ]
])
{{ print_r($testArray) }} // > array data

@set  (  'set_spaces', 'yes' )
{{ $set_spaces }} // > yes

@set  (  "set_quotes", "yes" )
{{ $set_quotes }} // > yes

@set('noSpace','ok')
{{ $noSpace }} // > ok

@set('mams', 'mamsVal')  
{{ $mams }} // > mamsVal

@set($mams, 'oelala')
{{ $mams }} // > oelala

@set($mams, 'pops')
{{ $mams }} // > pops

@set('mams', 'childs')
{{ $mams }} // > childs

@set($testArray, $main_links)
{{ print_r($testArray) }} // > array data

@set('myArr', ['my' => 'arr'])
{{ print_r($myArr) }} // > array data

@set('myArr2', array('my' => 'arr'))
{{ print_r($myArr2) }} // > array data
```

```php
@set('mams', 'childs')
{{ $mams }} // > childs
@unset($mams)
{{ $mams }} // > throws Error/Warning

@set('mams', 'childs')
{{ $mams }} // > childs
@unset('mams')
{{ $mams }} // > throws Error/Warning
```
