going to test set<br>
@set('testvar', 'testvalue')
testvar: {{ $testvar }}<br>

going to test ForEach loop<br>
<br>
@foreach ($loopData as $key => $val)
    @if ($loop->index > 5)
        @break
    @endif

    {{ $loop->index }} - {{ $key }} - {{ $val }} <br>

    @foreach ($loopData as $key2 => $val2)
        @if ($loop->index > 5)
            @break
        @endif
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $loop->index }} - {{ $key2 }} - {{ $val2 }} <br>
    @endforeach

    {{ $loop->index }} - after<br>
@endforeach

should be none: {{ isset($loop) ? 'loop set, is NOT good' : 'all good' }}

<br>
<br>
continue
<br>
<br>


@foreach ($loopData as $key => $val)
    @if ($loop->index > 10)
        @break
    @endif

    @if ($loop->odd)
        @continue
    @endif

    {{ $loop->index }} - {{ $key }} - {{ $val }} <br>

@endforeach