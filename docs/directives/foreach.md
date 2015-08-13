<!---
title: Foreach, break, continue
author: Robin Radic
-->

The `@foreach` directive provides the `$loop` data inside foreach blocks.
The `$loop` is able to traverse upwards, so it's possible to get the parent loop inside
child loops by accessing `$loop->parent`.
```php
@foreach($stuff as $key => $val)
    $loop->index;       // int, zero based
    $loop->index1;      // int, starts at 1
    $loop->revindex;    // int
    $loop->revindex1;   // int
    $loop->first;       // bool
    $loop->last;        // bool
    $loop->even;        // bool
    $loop->odd;         // bool
    $loop->length;      // int

    @foreach($other as $name => $age)

        $loop->parent->odd;
        {{ $loop->index }}

        @if($loop->odd)
            @continue
        @endif

        @foreach($friends as $foo => $bar)
            $loop->parent->index;
            $loop->parent->parent->index;

            @if($loop->index > 1)
                @break
            @endif

        @endforeach

    @endforeach

@endforeach
```
