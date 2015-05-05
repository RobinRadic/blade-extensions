{{--
https://github.com/RobinRadic/blade-extensions/issues/11
Using @set right after @foreach throws FatalErrorException
--}}
@foreach  (   $array as $key => $val   )
    @set('my', count($val['tags']))
@endforeach
