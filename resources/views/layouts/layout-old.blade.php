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
			<h1><a href="/">Eseménynaptár</a></h1>
		</div>
		<div id="menu">
			<ul>
				<li class="{{Request::path() === '/' ? 'current_page_item' : ''}}"> <a href="/" accesskey="1" title="">Kezdőlap</a></li>
				<li class="{{Request::path() === 'events' ? 'current_page_item' : ''}}"> <a href="/events" accesskey="2" title="">Események</a></li>
				@can('viewAny', 'App/Models/User')
				<li class="{{Request::path() === 'users' ? 'current_page_item' : ''}}"> <a href="/users" accesskey="2" title="">Felhasználók</a></li>
				@endcan
				@can('viewAny', 'App/Models/Registration')
				<li class="{{Request::path() === 'registrations' ? 'current_page_item' : ''}}"> <a href="/registrations" accesskey="2" title="">Regisztrációk</a></li>
				@endcan
				@if (Route::has('login'))
					@auth
						<li><a href="{{ url('/home') }}" title="Fiókom">Fiókom</a></li>
					@else			
							<li><a href="{{ route('login') }}" title="Bejelentkezés">Bejelentkezés</a></li>
						@if (Route::has('register'))
								<li><a href="{{ route('register') }}" title="Regisztráció">Regisztráció</a></li>
						@endif
					@endauth
				@endif
			</ul>
		</div>
	</div>
	<div id="header-featured">
		<div id="banner-wrapper">
			@yield('banner')
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