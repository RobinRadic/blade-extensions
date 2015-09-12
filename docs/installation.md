---
title: Installation
---

#### 1. Composer
Add the `radic/blade-extensions` package to your composer.json dependencies.
```json
"require": {
    "radic/blade-extensions": "~6.0"
}
```

#### 2. Laravel
Register the `BladeExtensionsServiceProvider` in your application, preferably in your `config/app.php` file.
```php
'providers' => [
    Radic\BladeExtensions\BladeExtensionsServiceProvider::class
]
```

#### 3. Optional: Publish config
```sh
php artisan vendor:publish --provider=Radic\BladeExtensions\BladeExtensionsServiceProvider
```

#### 4. Optional: Extra features
Some features are not enabled by default as they might depend on other packages. 
For enabling the desired optional features, follow the installation instructions below.


###### Minify CSS/JS
By default, only `@minify('html')` works. To enable javascript and css minification, add the `matthiasmullie/minify` package to your composer dependencies.
Blade Extensions automaticly detects the package and enables `@minify('js')` and `@minify('css')` directives. For more information, check out the directive's documentation page.
```json
"require": {
    "matthiasmullie/minify": "~1.3"
}
```

###### Markdown
To enable the `@markdown` directive or to enable the Markdown view engine (`@include('path.to.md.file')` / `View::make('path.to.md.file')`), 
add your preferred Markdown parser to your composer dependencies. By default `erusev/parsedown` is enabled as renderer. 
Check the markdown directive documentation page on how to implement custom a markdown parser.
```json
"require": {
    "erusev/parsedown": "~1.5"
}
```

###### Debug output
The `@debug($var)` directive will either use Symfony's `VarDumper` or the regular `var_dump` method. 
By installing the `raveren/kint` package. The debug output will be greatly improved. For more information, check out [this page](https://github.com/raveren/kint).
```json
"require": {
    "raveren/kint": "~1.0"
}
```

![Kint CLI output](http://i.imgur.com/6B9MCLw.png)
![Kint displays data intelligently](http://i.imgur.com/9P57Ror.png)
![Kint themes](http://raveren.github.io/kint/img/theme-preview.png)
![Kint profiling feature](http://i.imgur.com/tmHUMW4.png)
