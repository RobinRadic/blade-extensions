{{--

--}}
@set('id', isset($id) ? $id : uniqid('dropdown', false))
@set('tag', isset($tag) ? $tag : 'div')
@set('button', isset($button) && $button === true)

<{{ $tag }} class="dropdown @yield('container-class', '')">
    @if($button)
    <button class="btn @yield('button', 'btn-default') dropdown-toggle" type="button" id="@yield('id')" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        @yield('label', 'Dropdown')
        <span class="caret"></span>
    </button>
    @else
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            @yield('label', 'Dropdown')
            <span class="caret"></span>
        </a>
    @endif
    <ul class="dropdown-menu" aria-labelledby="@yield('id')">
        @yield('items')
    </ul>
</{{ $tag }}>
