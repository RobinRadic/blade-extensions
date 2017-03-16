---
title: Push to stack
subtitle: Features
---

Push to stack
==============
Pragmatically push content to a stack inside blade views. 

## How this works
todo...

## Example

layout.blade.php
```html
<html>
<head>
@stack('head')
</head>
<body>
@section('body')
@stack('scripts')
</body>
</html>
```

Somewhere in your PHP Code (a Service Provider `boot` method, a Controller method, whatever) 
```php
$be = app('blade-extensions');
$be->pushToStack('scripts', 'layout', '<script src="' . asset('my-script.js') . '">');
```

## Parameters

| Parameter    | Type   | Description           |
|:-------------|:-------|:----------------------|
| $stackName   | `string`           | The name of the stack |
| $targetViews | `string|string[]`  | The view(s) which contains the stack |
| $content     | `string|Closure`   | The content to push. If you provide a closure, it will receive the `View` as parameter and should return a string  |



