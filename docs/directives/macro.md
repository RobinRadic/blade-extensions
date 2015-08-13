<!---
title: Macros
author: Robin Radic
-->

```php
@macro('simple', $first, $second = 3, $what)
    $who = $first . $second;
    return $what . $who;
@endmacro

@domacro('simple', 'my age is', 3, 'patat')

@macro('gravatar', $email, $size = 32, $default = 'mm')
    return '<img src="http://www.gravatar.com/avatar/' . md5(strtolower(trim($email))) . '?s=' . $size . '&d=' . $default . '" alt="Avatar">';
@endmacro

@domacro('gravatar', 'info@radic.nl', 80)
```
### Breakdown
##### @macro
```php
@macro('simple', $first, $second = 3, $what)
    $who = $first . $second;
    return $what . $who;
@endmacro
```
Is the equivalent of
```php
HTML::macro('simple', function($first, $second = 3, $what){
    $who = $first . $second;
    return $what . $who;
});
```


##### @domacro
```php
@domacro('gravatar', 'info@radic.nl', 80)
// equals:
{{ HTML::macro('gravatar, 'info@radic.nl, 80)
```

