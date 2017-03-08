---
title: Embedding
subtitle: '@embed'
---
#### Behaviour
Think of embed as combining the behaviour of include and extends. (similair to twig `embed`). 
Embedded view files have their own `sections` and `stacks` making it possible to re-use section names, similar to Twig.
 
Environment/global variables can be used inside embedded views and can be overridden as well.

<!-- For more example's, enable `example_views` as described on the configuration page. -->
 
#### Example usage
**components/panel.blade.php**
```php
@set('type', isset($type) ? $type : 'info')
<div class="panel panel-{{ $type }}">
    <h5>@yield('title', 'default title') <small>@yield('subtitle')</small></h5>
    <div>
        @yield('content')
    </div>
</div>
```

**index.blade.php**  

  No worries about name conflicts. Re-use embed's, even recursive. Lets say the view below has been loaded using:

  `View::make('index', [ 'username' => 'robin', 'type' => 'warning' ])`
```php
@extends('layouts.default')

@section('content')

    @embed('components.panel')
        // By default, we've @set the 'type' to 'info'. 
        // However, since we have passed 'type' => 'warning', type is now a global and will be used instead
        @section('title', 'Warning panel')
        @section('content')
                
            <strong>Warning panel content</strong>

            // To override it inside our embed (without overiding the global), we just pass it as argument
            @embed('components.panel', ['type' => 'info'])
                @section('title', 'Info panel')
                @section('subtitle', 'Child of Warning panel')
                @section('content', 'You are doing something wrong!')
            @endembed

            @embed('components.panel', ['type' => 'success'])
                @section('title', 'Success panel')
                @section('subtitle', 'Child 2 of Warning panel, parent of danger panel panel')                
                @section('content')
                
                    <p>Very good {{ $username }}, you are very successfull</p>
                    
                    @embed('components.panel', ['type' => 'danger', 'items' => ['first', 'second', 'third'] ])
                        @section('title', 'Danger panel')
                        @section('subtitle', 'Child of success panel')
                        @section('content')
                            <strong>{{ $type }}<strong>
                            <ul>
                                @foreach($items as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        @stop
                    @endembed
                    
                @stop
            @endembed

        @stop
    @endembed
@stop
```
