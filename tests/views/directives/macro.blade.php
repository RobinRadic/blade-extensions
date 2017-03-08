@macrodef('simple', $first, $second = 3)
<?php return $first.$second; ?>
@endmacro
@macro('simple', 'my age is')
