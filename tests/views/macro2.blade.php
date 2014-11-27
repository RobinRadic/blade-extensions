@macro('simple', $first, $second = 3)
return $first . $second;
@endmacro
@domacro('simple', 'my age is ', 6)
