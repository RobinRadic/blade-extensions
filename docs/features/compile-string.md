---
title: Compile string
subtitle: Features
---

Compile string
==============
Compiles Blade strings **with** variables `BladeExtensions::compileString($string, array $vars = [])`.

## How this works
The method `compileString($string)` in laravel's `Illuminate\View\BladeCompiler`  does not accept variables because the function compiles the given string to PHP code.

The `BladeExtensions::compileString` method actually 'executes' the code, making it possible to use variables.

## Example

```php
$be = app('blade-extensions');
$result = $be->compileString('foo: {{ $foo }}', ['foo' => 'bat']);
print $result; // prints: foo: bar
```
