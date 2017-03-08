@macrodef('simple', $first, $second = 3, $what)
<?php
$who = $first.$second;

return $what.$who;
?>
@endmacro
@macro('simple', 'my age is', 3, 'patat')
