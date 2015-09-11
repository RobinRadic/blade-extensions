<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Laravel')</title>

    <link href="//fonts.googleapis.com/css?family=Lato:300" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <style type="text/css">
        @minify('css')

        .navbar-blade-extensions .navbar-brand {
            color: #4b2f2a;
            font-family: "Lato", "Helvetica Neue Light", "HelveticaNeue-Light", "Helvetica Neue", Calibri, Helvetica, Arial, sans-serif;
        }

        @endminify
    </style>

    @stack('styles')

</head>
@minify('html')
<body>

@yield('start')
<div class="container">
    @yield('content')
</div>
@yield('end')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
@stack('scripts')

</body>
@endminify
</html>
