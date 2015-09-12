---
title: BladeString
---
#### Usage
The `BladeStringRenderer` allows you to render blade template strings with variables. To get an instance of the renderer, you can:
- Use the binding `app('blade.string')->render($str, $vars = []);`
- Use the Facade `BladeString::render($str, $vars = []);`
- Inject `__construct(BladeStringRenderer $bladeString)`

```php
$rendered = BladeString::render('{{ $var1 }} @if($var2 === true) {{ $var1 }} @endif', [ 'var1' => 'Yes Man', 'var2' => true ]);`
echo $rendered;
```

#### Facade
To use the `BladeString` facade, add it to the `facades` array in your `config/app.php` file.
```php
return [
    'facades' => [
        'BladeString' => Radic\BladeExtensions\Facades\BladeString::class    
    ]
];
```
