## Laravel Blade Extensions
Laravel package providing remote access to a Bukkit server console using JS/PHP/Laravel and the SwiftAPI Bukkit plugin.

### Version 0.1.0 (Pre Alpha - Development)
[View changelog and todo](https://github.com/RobinRadic/laravel-bukkit-console/blob/master/changelog.md)

#### Requirements
- PHP > 5.3 
- Laravel > 4.0


#### Installation
Not yet on packagist. needs further development.

#### Documentation

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

##### set
```php
@set('varKey', 'varVal')
{{ $varKey }}
@set('varKey2', $varKey)
```


### Maby?

##### config
```php
@config('key', 'val') // set
@config('key') // get
```

##### do
```php
@do($key++)
@do(1 + 1)
```

##### debug
```php
@debug($val) // die(var_dump($val))
```


### Credits
- [Robin Radic](https://github.com/RobinRadic)

### License
MIT. Check license.txt.