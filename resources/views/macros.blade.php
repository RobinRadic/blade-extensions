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
