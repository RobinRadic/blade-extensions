@foreach($loopData as $index => $data)
    @set('count', $count + $loop->index)
@endforeach
{{ $count }}