Blade Partials
==============
This package introduces the concept of partials (not includes) in blade templating. Think of it like inline @extends functionality within your views.

Partials allow you to extend a view and inject content into it, inline, within your views.

Why?
---
To make it easier to create reusable components. I often find myself repeating a lot of HTML boilerplate when using frameworks like Bootstrap or Foundation, and this package reduces that. Furthermore, if we ever need to change the markup we don't need to hunt down every instance in our code to do so (DRY).

This functionality can be achieved by using `@include`, but that can be annoying when your templates are broken down into a ton of tiny templates scattered about.

Installation
------------
Begin by installing this package through Composer.

```json
{
    "require": {
        "crhayes/blade-partials": "0.*"
    }
}
```
Next open up `app/config/app.php`, comment out the Illuminate View Service Provider, and add the one from this package:
```php
'providers' => array(
    //'Illuminate\View\ViewServiceProvider',
    ...
    'Crhayes\BladePartials\ViewServiceProvider',
)
```

And that's it!

Creating a Partial
------------------
Partials start with the `@partial('path.to.view')` directive, which accepts the view you want the partial to extend from, and end with the `@endpartial` directive.

```php
@partial('partials.panel')
    @block('title', 'This is the panel title')

    @block('body')
        This is the panel body.
    @endblock
@endpartial
```

Blocks within partials behave the same way as sections within templates. They capture a piece of data that will be rendered into the extended view.

Rendering a Partial
-------------------
We use the `@render('block-to-render')` directive to render a block of content that was provided via the respective `@block` directive. Note that we can also provide a default value.

```html
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">@render('title', 'Default Title')</h3>
    </div>
    <div class="panel-body">
        @render('body', 'Default Body')
    </div>
</div> 
```

Full Example
------------
This example will include our partial HTML file. Notice that we can create as many instances of the partial as we like.

```php
// index.blade.php
@extends('layouts.master')
 
@section('content')
    @partial('partials.panel')
        @block('title', 'This is the panel title')
 
        @block('body')
            This is the panel body.
        @endblock
    @endpartial
    
    @partial('partials.panel')
        @block('title', 'This is a second panel title')
 
        @block('body')
            And we will have different content in this body.
        @endblock
    @endpartial
@stop
 
// /partials/panel.blade.php
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">@render('title')</h3>
    </div>
    <div class="panel-body">
        @render('body')
    </div>
</div> 
```

Nesting Partials
----------------
You can also do some cool things by nesting partials. For example:

```php
// index.blade.php
@extends('layouts.master')

@section('content')
    @partial('partials.danger-panel')
        @block('title', 'This is the panel title')
    
        @block('body')
            This is the panel body.
        @endblock
    @endpartial
@stop

// partials/danger-panel.blade.php
@partial('partials.panel')
    @block('type', 'danger')

    @block('title')
    	Danger! @render('title')
    @endblock
@endpartial

// partials/panel.blade.php
<div class="panel panel-@render('type', 'default')">
    <div class="panel-heading">
        <h3 class="panel-title">@render('title')</h3>
    </div>
    <div class="panel-body">
        @render('body')
    </div>
</div> 
```
