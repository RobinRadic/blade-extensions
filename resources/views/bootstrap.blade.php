@extends('blade-ext::layouts.default')

@include('blade-ext::macros')

@set('main_links', [
    'Home' => url(),
    'Overview' => url(),
    'Choose' => [
        'Action' => '#',
        'Another action' => '#',
        'Something else here' => '#',
        '---',
        'Separated link' => '#'
    ]
])

@section('start')
    @embed('blade-ext::navbar', [
        'class' => 'navbar-blade-extensions'
    ])
        @section('brand', 'Blade Extensions')

        @section('content')
            @foreach($main_links as $label => $link)
                @if(is_array($link))
                    @embed('blade-ext::dropdown', ['tag' => 'li', 'label' => $label, 'link' => $link ])
                        @section('label', $label)
                        @section('items')
                            @foreach($link as $_label => $_link)
                                @if($_link === '---')
                                    @macro('divider')
                                @else
                                    @macro('lia', $_label, $_link)
                                @endif
                            @endforeach
                        @stop
                    @endembed
                @else
                    @if($link === '---')
                        @macro('divider')
                    @else
                        @macro('lia', $label, $link, $loop->first ? 'active' : '')
                    @endif
                @endif
            @endforeach

        @stop

        @push('navbars')
            <ul class="nav navbar-nav navbar-right">
                @macro('lia', 'Link', '#')
                @embed('blade-ext::dropdown', ['tag' => 'li'])
                    @section('label', 'Choose')
                    @section('items')
                        @macro('lia', 'Action', '#')
                        @macro('lia', 'Another Action')
                        @macro('lia', 'Something else here')
                        @macro('divider')
                        @macro('lia', 'Separated link')
                        @macro('divider')
                        @macro('lia', 'One more separated link')
                    @stop
                @endembed
            </ul>
        @endpush
    @endembed
@stop


@section('content')
    <div class="row">
        <div class="col-md-6">
            @macro('alert', 'warning', 'This is a warning')
            @macro('alert', 'info', 'This is some information without dismiss button', false)
            @macro('alert', 'success', 'You did well!')
        </div>
    </div>

    @embed('blade-ext::dropdown', ['button' => true])
        @section('label', 'Choose')
        @section('items')
            @macro('lia', 'Action')
            @macro('lia', 'Another Action')
            @macro('lia', 'Something else here')
            @macro('lia', 'Separated link')
        @stop
    @endembed
@stop
