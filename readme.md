## Laravel Blade Extensions
Laravel package providing remote access to a Bukkit server console using JS/PHP/Laravel and the SwiftAPI Bukkit plugin.

### Version 0.1.0 (Pre Alpha - Development)
[View changelog and todo](https://github.com/RobinRadic/laravel-bukkit-console/blob/master/changelog.md)

#### Requirements
- PHP > 5.3 
- Laravel > 4.0


#### Installation
...

#### Documentation

##### ForEach
As with Twig, @foreach now has a $loop variable in the block available.
```php
@foreach ($data as $key => $val)
    {{ $loop->index }}      {{ $loop->odd ? 'This is odd' : 'But this is even' }}    
@endforeach
```

### Credits
- [Robin Radic](https://github.com/RobinRadic) created [Laravel Bukkit SwiftApi](https://github.com/RobinRadic/laravel-bukkit-swiftapi)

### License
MIT