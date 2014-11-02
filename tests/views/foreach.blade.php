@assertTrue(true)

@foreach(true)
	@assertTrue($loop->index);
@endforeach
@foreach($array)
	{{ $loop->index }}
@endforeach
@foreach($array as $item)
	{{ $loop->index }}
@endforeach
@foreach($array as $key => $val)
	{{ $loop->index }}
@endforeach
@foreach(getArray())
	{{ $loop->index }}
@endforeach
@foreach(getArray() as $key => $val)
	{{ $loop->index }}
@endforeach
@foreach($value->array)
	{{ $loop->index }}
@endforeach
@foreach($value->array as $key => $val)
	{{ $loop->index }}
@endforeach
@foreach($value->getArray())
	{{ $loop->index }}
@endforeach
@foreach($value->getArray() as $key => $val)
	{{ $loop->index }}
@endforeach
@foreach($value->getArray(true) as $key => $val)
	{{ $loop->index }}
@endforeach