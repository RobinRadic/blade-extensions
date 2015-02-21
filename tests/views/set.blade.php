
@assertTrue($dataString === 'hello', 'datastring should equal hello')
{{--@assertTrue(is_array($dataArray), 'dataArray should be an array')--}}


@set('mams', 'mamsVal')
@assertTrue(isset($mams), '@set mams should create a new var')
@assertTrue($mams === 'mamsVal', 'should create new variable named $mams with value "mamsVal"')

@unset($mams)
@assertFalse(isset($mams), '@unset mams should delete mams')

@set($mams, 'oelala')
@assertTrue(isset($mams), '@set $mams should create a new var')
@assertTrue($mams === 'oelala', 'should create new variable named $mams with value "oelala"')

@set($mams, 'pops');
@assertTrue($mams === 'pops', '@set should accept a $variable as key, and override the old value')

@set('mams', 'childs');
@assertTrue($mams === 'childs', '@set should accept a string as key, and override the old value')



@unset('mams')
@assertFalse(isset($mams), '@unset should accept a string as key')


@set($testArray, $dataArray)
{{--@assertTrue(is_array($testArray), 'testArray should be an array')
@assertArrayHasKey(0, $testArray, 'testArray should have key 0')
{{ xdebug_break() }}

@set($testArray[0]['index'], 0)
@assertTrue($testArray[0]['index'] === 0, 'testArray key 0 should have key index on 0')


@set($testArray[0]['index'], 1)
@assertTrue($testArray[0]['index'] === 1, 'testArray key 1 should have key index on 1')

@set('pops', $testArray[0]['index'])
@assertTrue($pops === $testArray[0]['index'], 'pops should equal testArray.0.index')
--}}
@unset($pops);
@assertFalse(isset($pops), 'pops should not be set')
