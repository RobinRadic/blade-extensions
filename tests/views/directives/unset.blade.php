@set('mams', 'mamsVal')
@unset($mams)
@assertFalse(isset($mams), '@unset $mams should delete mams')

@set($mams, 'childs')
@unset('mams')
@assertFalse(isset($mams), '@unset mams should delete mams')

@set('pops', 'a')
@unset($pops);
@assertFalse(isset($pops), 'pops should not be set')
