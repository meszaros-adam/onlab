<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by TEMPLATED
http://templated.co
Released for free under the Creative Commons Attribution License

Name       : SimpleWork 
Description: A two-column, fixed-width design with dark color scheme.
Version    : 1.0
Released   : 20140225

-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />

<link href="{{ asset('css/default.css') }}" rel="stylesheet" type="text/css" media="all" />
<link href="{{ asset('css/fonts.css') }}" rel="stylesheet" type="text/css" media="all" />

<!--[if IE 6]><link href="default_ie6.css" rel="stylesheet" type="text/css" /><![endif]-->

</head>
<body>
<div id="header-wrapper">
	<div id="header" class="container">
		<div id="logo">
			<h1><a href="#">Eseménynaptár</a></h1>
		</div>
		<div id="menu">
			<ul>
				<li class="{{Request::path() === '/' ? 'current_page_item' : ''}}"> <a href="/" accesskey="1" title="">Kezdőlap</a></li>
				<li class="{{Request::path() === 'events' ? 'current_page_item' : ''}}"> <a href="/events" accesskey="2" title="">Események</a></li>
				@can('viewAny', 'App\Models\Registration')
				<li class="{{Request::path() === 'registrations' ? 'current_page_item' : ''}}"> <a href="/registrations" accesskey="2" title="">Regisztrációk</a></li>
				@endcan
				@if (Route::has('login'))
					@auth
						<li><a href="{{ url('/home') }}" accesskey="3" title="">Fiókom</a></li>
					@else			
							<li><a href="{{ route('login') }}" accesskey="4" title="">Bejelentkezés</a></li>
						@if (Route::has('register'))
								<li><a href="{{ route('register') }}" accesskey="5" title="">Regisztráció</a></li>
						@endif
					@endauth
				@endif
			</ul>
		</div>
	</div>
	<div id="header-featured">
		<div id="banner-wrapper">
			<div id="banner" class="container">
				<h2>Erdei iskola eseménynaptára</h2>
				<p>This is <strong>SimpleWork</strong>, a free, fully standards-compliant CSS template designed by <a href="http://templated.co" rel="nofollow">TEMPLATED</a>. The photos in this template are from <a href="http://fotogrph.com/"> Fotogrph</a>. This free template is released under the <a href="http://templated.co/license">Creative Commons Attribution</a> license, so you're pretty much free to do whatever you want with it (even use it commercially) provided you give us credit for it. Have fun :) </p>
				<a href="#" class="button">Etiam posuere</a> </div>
		</div>
	</div>
</div>
<div id="wrapper">
	<div id="page" class="container">
		<div id="content">
		@yield('content')
		</div>
	</div>
</div>
<div id="copyright" class="container">
	<p>&copy; Untitled. All rights reserved. | Photos by <a href="http://fotogrph.com/">Fotogrph</a> | Design by <a href="http://templated.co" rel="nofollow">TEMPLATED</a>.</p>
</div>
</body>
</html>