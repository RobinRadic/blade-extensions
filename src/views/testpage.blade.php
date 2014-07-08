going to test ForEach loop<br>
<br>
@foreach ($loopData as $key => $val)
{{ $loop->index }} - {{ $key }} - {{ $val }} <br>

    @foreach ($loopData as $key2 => $val2)
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $loop->index }} - {{ $key2 }} - {{ $val2 }} <br>
    @endforeach
@endforeach