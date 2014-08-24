value = {{ $value }}<br>
<br>


@set('newval', 'has a VALUE')

newval = {{ $newval }}<br>
<br>




@set('value', $newval)

value = {{ $value }}<br>
<br>


@set('session', Request::getSession())

{{ var_dump($session->all()) }}