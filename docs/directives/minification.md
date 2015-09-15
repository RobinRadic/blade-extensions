---
title: Minification
subtitle: '@minify'
---

#### Basic
By default only `html` minification is available. If you also want to enable `css` and `js` minification, 
install the `"matthiasmullie/minify": "~1.3"` package as explained in the [installation](../installation.html) documentation. 

The `@minify` directive requires 1 parameter which is `html`, `css` or `js`.

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


#### Usage examples
Should make it clear.

###### Javascript
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

###### CSS
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
