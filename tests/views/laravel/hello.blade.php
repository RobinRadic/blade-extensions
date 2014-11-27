<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Laravel PHP Framework</title>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<style>
		@import url(//fonts.googleapis.com/css?family=Lato:700);

		body {
			margin:0;
			font-family:'Lato', sans-serif;
			text-align:center;
			color: #999;
		}

		.welcome {
			width: 300px;
			height: 200px;
			position: absolute;
			left: 50%;
			top: 50%;
			margin-left: -150px;
			margin-top: -100px;
		}

		a, a:visited {
			text-decoration:none;
		}

		h1 {
			font-size: 32px;
			margin: 16px 0 0 0;
		}

		.panel {
			border: 1px solid #404040;
			width: 200px;
			margin: 20px auto;
		}
		.panel-heading {
			border-bottom: 1px solid #818181;
			background-color: #aaaaaa;
		}
		.panel-title {
			color: #4bb1b1;
		}
		.panel-body {
			color: #72b145;
		}
	</style>
</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-md-3">

@set('newvar', 'value')
{{ $newvar }}
<br>
@set('mams', 'mamsVal')
{{ $mams }}
<br>
@unset($mams)
{{ var_dump(isset($mams)) }}
<br>
@set('mams', 'childs')
{{ $mams }}
<br>
@unset('mams')
{{ var_dump(isset($mams)) }}
<br>
@macro('simple', $first, $second = 3, $what)
$who = $first . $second;
return $what . $who;
@endmacro
@domacro('simple', 'my age is', 3, 'patat')
<br>
@macro('gravatar', $email, $size = 32, $default = 'mm')
return '<img src="http://www.gravatar.com/avatar/' . md5(strtolower(trim($email))) . '?s=' . $size . '&d=' . $default . '" alt="Avatar">';
@endmacro
@domacro('gravatar', 'info@radic.nl', 80)
<br>
@set('partialTitle', 'The gravatar')
@partial('partials.panel')
	@block('title', $partialTitle)

	@block('body')
		@domacro('gravatar', 'info@radic.nl', 80)
	@endblock
@endpartial

@partial('partials.panel')
	@block('title', 'This is a second panel title')

	@block('body')
		And we will have different content in this body.
	@endblock
@endpartial
		</div>
	</div>
</div>
</body>
</html>
