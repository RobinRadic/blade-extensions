<!---
title: Assignments
author: Robin Radic
-->

Set or unset variables your blade views.   

```php
@set('foo', '213')
{{ $foo }} //> 213

@set($foo, 'bar')
{{ $foo }} //> bar

@set('foo', 'bar2')
{{ $foo }} //> bar2

@set('bar', $foo)
# equals
@set($bar, $foo)

@unset('foo')
# equals
@unset($foo)
```
