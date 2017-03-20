@extends('layout')

@section('content')
    @embed('directives.embed.panel')
        {{--By default, we've @set the 'type' to 'info'.--}}
        {{--However, since we have passed 'type' => 'warning', type is now a global and will be used instead--}}
        @section('title', 'Warning panel')
        @section('content')
            <strong>Warning panel content</strong>

            {{--To override it inside our embed (without overiding the global), we just pass it as argument--}}
            @embed('components.panel', ['type' => 'info'])
                @section('title', 'Info panel')
                @section('subtitle', 'Child of Warning panel')
                @section('content', 'You are doing something wrong!')
            @endembed

            @embed('components.panel', ['type' => 'success'])
                @section('title', 'Success panel')
                @section('subtitle', 'Child 2 of Warning panel, parent of danger panel panel')
                @section('content')
                    <p>Very good {{ $username }}, you are very successfull</p>

                    @embed('components.panel', ['type' => 'danger', 'items' => ['first', 'second', 'third'] ])
                        @section('title', 'Danger panel')
                        @section('subtitle', 'Child of success panel')
                        @section('content')
                            {{--<strong>{{ $type }}</strong>--}}
                            {{--<ul>--}}
                                {{--@foreach($items as $item)--}}
                                    {{--<li>{{ $item }}</li>--}}
                                {{--@endforeach--}}
                            {{--</ul>--}}
                        @stop
                    @endembed

                @stop
            @endembed

        @stop
    @endembed
@endsection
