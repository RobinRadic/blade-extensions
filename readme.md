## Laravel Blade Extensions
Laravel package providing additional Blade extensions.

- @foreach (with $loop data, like twig)
- @break
- @continue
- @set
- @array (multiline)
- @debug


### Version 0.2.0 alpha (Development Preview)
[View changelog and todo](https://github.com/RobinRadic/laravel-bukkit-console/blob/master/changelog.md)


#### Requirements
- PHP > 5.3 
- Laravel > 4.0


#### Installation
Add to `composer.json`
```JSON
{
    "require": {
        "radic/blade-extensions": "0.2.*"
    }
}

Add to `app/config/app.php` to register the service provider
```php
return array(
    'providers' => array(
        'Radic\BladeExtensions\BladeExtensionsServiceProvider'
    )
);
```


#### Documentation
Shows the current implemented functionality.

##### foreach
```php
@foreach ($data as $key => $val)
    Zero based index: {{ $loop->index }} - Starts at 1: {{ $loop->index1 }}
    {{ $loop->revindex }}  {{ $loop->revindex1 }}
    {{ $loop->first ? 'is first!' : 'not first' }} {{ $loop->last ? 'is last' : 'not last' }}
    {{ $loop->odd ? 'This is odd' : 'But this is even' }}
    {{ $loop->length }}            
    @foreach ($val as $subkey => $subval)
        Like usual: {{ $loop->index }}
        Access parent loop: {{ $loop->parentLoop->index }}
    @endforeach
@endforeach
```

##### break, continue
```php
@foreach ($loopData as $key => $val)
    @if ($loop->index > 10)
        @break
    @endif
    @if ($loop->odd)
        @continue
    @endif
    {{ $loop->index }} - {{ $key }} - {{ $val }}
@endforeach
```



### Roadmap
The following functionality is planned for the initial v1.0.0 stable release, but hasn't been (fully) implemented and/or tested yet.

##### set
```php
@set('varKey', 'varVal')
{{ $varKey }}
@set('varKey2', $varKey)
```

##### array
```php
@array('newArr', [     // multi-line support
    'key' => 'val',
    'key2' => 'val'
])
```

##### debug
```php
@debug($val) // die(var_dump($val))
```

### Copyright/License
Copyright 2014 [Robin Radic](https://github.com/RobinRadic) - [MIT Licensed](http://radic.mit-license.org)