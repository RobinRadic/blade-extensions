@macro('simple', $first, $second = 3, $what)
$who = $first . $second;
return $what . $who;
@endmacro
@domacro('simple', 'my age is', 3, 'patat')
