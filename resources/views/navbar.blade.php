{{--
@embed('blade-ext::navbar', [
    'fixed'         => null, # top / bottom (Body padding required: body { padding-bottom: 70px; })
    'type'          => 'default',
    'fluid'         => false,
    'wrap_brand'    => true
]);
    @section('brand', 'Brand name')
    @section('content')
        <li><a>Item</a></li>
    @stop
    @push('navbars')
        <ul class="nav navbar-nav navbar-right">
            <li><a>Item</a></li>
        </ul>
    @endpush
@endembed
--}}
@set('id', isset($id) ? $id : uniqid('navbar', false))
@set('type', isset($type) ? $type : 'default')
@set('fixed', isset($fixed) ? ' navbar-fixed-' . $fixed : '')
@set('fluid', isset($fluid) && $fluid === true ? 'container-fluid' : 'container')
@set('wrap_brand', isset($wrap_brand) ? $wrap_brand : true)
@set('class', isset($class) ? ' ' .$class : '')

<nav class="navbar navbar-{{ $type }}{{ $fixed }}{{ $class }}">
    <div class="{{ $fluid }}">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#{{ $id }}-collapse" aria-expanded="false">
                <span class="sr-only">@yield('toggle', 'Toggle navigation')</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            @if($wrap_brand)
                <a class="navbar-brand" href="#">@yield('brand', 'Brand')</a>
            @else
                @yield('brand', '')
            @endif
        </div>

        <div class="collapse navbar-collapse" id="{{ $id }}-collapse">

            <ul class="nav navbar-nav">
                @yield('content')
            </ul>
            @stack('navbars')
        </div>

    </div>
</nav>
