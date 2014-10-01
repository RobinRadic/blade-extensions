@foreach($loopData as $index => $data)
    @set('count', $count + $testNumber)
@endforeach
{{ $count }}