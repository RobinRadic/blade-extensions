{{-- View::make('set', ['dataString' => 'hello', 'dataArray' => $this->data->array, 'dataClassInstance' => $this->data, 'dataClassName' => 'TestData'])->render(); --}}

{{-- Test view data --}}
@assertTrue($dataString === 'hello')
@assertTrue(is_array($dataArray))
@assertTrue($dataClassInstance instanceof TestData);


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





{{-- [0] => Array
                     (
                         [_id] => 542231ae3749519f2775a6b2
                         [index] => 0 --}}
@set($testArray, $dataArray)
@assertTrue(is_array($testArray))
@assertArrayHasKey(0, $testArray)
@assertTrue($testArray[0]['index'] === 0)


@set($testArray[0]['index'], 1)
@assertTrue($testArray[0]['index'] === 1)

@set('pops', $testArray[0]['index'])
@assertTrue($pops === $testArray[0]['index'])

@unset($pops);
@assertFalse(isset($pops))