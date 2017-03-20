@set('type', isset($type) ? $type : 'info')
<div class="panel panel-{{ $type }}">
    <div class="panel-heading">
        <h5>@yield('title', 'default title')
            <small>@yield('subtitle')</small>
        </h5>
    </div>


    <div class="panel-body">
        @yield('content')
    </div>
</div>
