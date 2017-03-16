---
title: Foreach loop
subtitle: '@foreach @break @continue'
---

#### Basic usage
By default, blade doesn't have `@break` and `@continue` which are useful to have. So that's included.
 
Furthermore, the `$loop` variable is introduced inside loops, (almost) exactly like Twig. So il shamelessly steal their description table:

| Variable | Description |
|:---------|:------------|
| loop.index1 | The current iteration of the loop. (1 indexed) |
| loop.index | The current iteration of the loop. (0 indexed) |
| loop.revindex1 | The number of iterations from the end of the loop (1 indexed) |
| loop.revindex | The number of iterations from the end of the loop (0 indexed) |
| loop.first | 	True if first iteration |
| loop.last | True if last iteration |
| loop.length | The number of items in the sequence |
| loop.parent | The parent context |


#### Usage example

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
        @foreach($friends as $foo => $bar)
            $loop->parent->index;
            $loop->parent->parentLoop->index;
        @endforeach
    @endforeach  
    
    @break

    @continue
@endforeach
```
