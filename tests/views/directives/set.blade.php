{{-- Test directive spaces and quotes--}}
@set  (  'set_spaces', 'yes' )
@assertEquals('yes', $set_spaces, 'set set_spaces should pass')

@unset  (  'set_spaces' )
@assertFalse(isset($set_spaces), 'unset set_spaces should pass')

@set  (  "set_quotes", "yes" )
@assertEquals('yes', $set_quotes, 'set set_quotes should pass')

{{-- Test directive NO spaces. Issue #19 --}}
@set('noSpace','ok')
@assertEquals('ok', $noSpace)

{{-- Test directive input variants --}}
@set('mams', 'mamsVal')
@assertTrue(isset($mams), '@set mams should create a new var')
@assertTrue($mams === 'mamsVal', 'should create new variable named $mams with value "mamsVal"')

@set($mams, 'oelala')
@assertTrue(isset($mams), '@set $mams should create a new var')
@assertTrue($mams === 'oelala', 'should create new variable named $mams with value "oelala"')

@set($mams, 'pops')
@assertTrue($mams === 'pops', '@set should accept a $variable as key, and override the old value')

@set('mams', 'childs')
@assertTrue($mams === 'childs', '@set should accept a string as key, and override the old value')

@set('myArr', ['my' => 'arr'])
@assertEquals('arr', $myArr['my'])

@set('myArr2', array('my' => 'arr'))
@assertEquals('arr', $myArr2['my'])
