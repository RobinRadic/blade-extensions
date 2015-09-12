---
title: Macros
subtitle: '@macro @macrodef'
---
#### Creating macro's
A few examples: 

```php
@macrodef('alert', $type, $content, $dismissible = true)
<?php
$dismissible = $dismissible ? "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>\n" : '';
return "<div class='alert alert-{$type}' role='alert'>{$dismissible}{$content}</div>";
?>
@endmacro

@macrodef('lia', $label, $href = '#', $listClass = '', $linkClass = '')
<?php
$listClass = $listClass == '' ? '' : " class='{$listClass}'";
$linkClass = $linkClass == '' ? '' : " class='{$linkClass}'";
return "<li{$listClass}><a href='{$href}'{$linkClass}>{$label}</a></li>";
?>
@endmacro

@macrodef('divider', $class = 'divider', $role = 'seperator')
<?php return "<li role='{$role}' class='{$class}'></li>"; ?>
@endmacro
```

#### Using macros
```php
    <div class="row">
        <div class="col-md-6">
            @macro('alert', 'warning', 'This is a warning')
            @macro('alert', 'info', 'This is some information without dismiss button', false)
            @macro('alert', 'success', 'You did well!')
        </div>
    </div>

    @embed('blade-ext::dropdown', ['button' => true])
        @section('label', 'Choose')
        @section('items')
            @macro('lia', 'Action')
            @macro('lia', 'Another Action')
            @macro('lia', 'Something else here')
            @macro('lia', 'Separated link')
        @stop
    @endembed
```
