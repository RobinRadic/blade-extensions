0---
title: Minification
subtitle: '@minify'
---

Minification
============

> There aren't many valid use-cases for using this directive. Check out the [alternatives](#alternatives) at the bottom of the page first! 

The `@minify` directive requires 1 parameter which is `html`, `css` or `js`.


By default, only `@minify('html')` works. 


```html
@minify('html')
<body>

@yield('start')
<div class="container">
    @yield('content')
</div>
@yield('end')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
@stack('scripts')

</body>
@endminify
```




Javascript & CSS
-----------------------

To enable javascript and css minification, Add the `matthiasmullie/minify` package.

If Blade Extensions detects the package it enables the `@minify('js')` and `@minify('css')` directives
```json
"require": {
    "matthiasmullie/minify": "~1.3"
}
```

### Javascript
```php
<script>
    @minify('js')
    var exampleJavascript = {
        this: 'that',
        foo: 'bar',
        doit: function(){
            console.log('yesss');
        }
    };
    @endminify
</script>
```


### CSS 

```php
<style type="text/css">
    @minify('css')      
    a.bg-primary:hover,
    a.bg-primary:focus {
      background-color: #286090;
    }
    
    .bg-success {
      background-color: #dff0d8;
    }
    
    a.bg-success:hover,
    a.bg-success:focus {
      background-color: #c1e2b3;
    }
    @endminify
</style>
```


<a name='alternatives'></a>
Alternatives
------------
Just a few examples
- [laradic/assets](https://packagist.org/packages/laradic/assets) A asset manager for Laravel 5. Enables grouping, chaining, compiling (minification, url rewriting for css, etc). Uses `Assetic`'s filters in order to provide high functionality.
- [graham-campbell/htmlmin](https://packagist.org/packages/graham-campbell/htmlmin) A HTML minifier for Laravel 5. Minify entire responses or minify blade at compile time.

