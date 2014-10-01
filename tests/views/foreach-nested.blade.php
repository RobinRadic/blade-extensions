@foreach($loopData as $index => $data)
;outer:before:{{ $loop->index }};
@foreach($loopData as $index2 => $data2)
;inner:before:{{ $loop->index }};
;inner:value:{{ $index + $index2 }};
;inner:after:{{ $loop->index }};
@endforeach
;outer:after:{{ $loop->index }};
@endforeach