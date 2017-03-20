---
title: If section
subtitle: '@ifsection @elseifsecton @endifsection'
---

# If section
check the [pull-request](https://github.com/RobinRadic/blade-extensions/pull/43)

`@ifsection` allows patterns like this:

**panel.blade.php**

```php
<div class="panel">

    @ifsection('header')
    <div class="panel-header">
        @yield('header')
    </div>
    @endifsection

    <div class="panel-content">
        @yield('content')
    </div>

    @ifsection('footer')
    <div class="panel-footer">
        @yield('footer')
    </div>
    @endifsection

</div>
```

**example-without-footer.blade.php**

```php
@extends('panel')

@section('header')
    This is the header
@endsection

@section('content')
    This is some content
@endsection
```

**example-without-header.blade.php**

```php
@extends('panel')

@section('content')
    This is some content
@endsection

@section('footer')
    This is the footer
@endsection
```

It becomes much more useful when combined with `@embed`

**page.blade.php**

```php
@embed('panel')
    @section('header')
        This is the header
    @endsection

    @section('content')
        This is some content
    @endsection
@endembed
```

I agree `@ifsection` is probably not the ideal solution to this specific problem. A helper function would be much better as it could be used as a param within other directives. I was unable to figure out how to make one that accomplished the same thing. Do you have any alternative ideas for implementing this pattern? or how it could be done with a helper function?
