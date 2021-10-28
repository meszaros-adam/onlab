<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Eseménynaptár">
        <meta name="keywords" content="Eseménynaptár, Erdei iskola, Sopron">
        <title>Eseménynaptár</title>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css">
    </head>
    <body>
        <div class="page-container">
            <div class="header">                    
                    <ul class="nav">
                        @guest
                                @if (Route::has('register'))
                                    <li><a class="nav-button" href="{{ route('register') }}">Regisztráció</a></li>
                                @endif

                                @if (Route::has('login'))
                                    <li><a class="nav-button" href="{{ route('login') }}">Bejelentkezés</a></li>
                                @endif
                                
                                
                            @else
                                <li>
                                    <div class="dropdown">
                                        <a class="nav-button">{{ Auth::user()->name }}</a>
                                            <div class="dropdown-content">
                                                <a href="/home">Regisztrációim</a>
                                                <a class="nav-button" href="{{ route('logout') }}"
                                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                                        Kijelentkezés
                                                </a>
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                                        @csrf
                                                    </form>
                                            </div>
                                    </div>
                            </li>
                        @endguest

                        @can('viewAny', 'App/Models/Registration')
                            <li><a class="nav-button" href="/registrations" title="Regisztrációk">Regisztrációk</a></li>
                        @endcan

                        @can('viewAny', 'App/Models/User')
                            <li><a class="nav-button" href="/users" title="Felhasználók">Felhasználók</a></li>
                        @endcan

                        @can('create', 'App/Models/Event')
                            <li><a class="nav-button" href="/events/create" title="Esemény létrehozása">Esemény létrehozása</a></li>
                        @endcan

                        <li><a class="nav-button" href="/events" title="Események">Események</a></li>
                        <li class="title"><a href="/" title="Kezdőlap"><h1>Eseménynaptár</h1></a></li>
                        <!--<li class="title"><a href="/" title="Kezdőlap"><h1>Erdei Iskola Eseménynaptár<h1></a></li>-->
                    </ul>
            </div>
            
            <section class="content">
            @yield('content')
            </section>

            <div class="footer" >
                <div>Minden jog védve!</div>
                <!--<a href="https://taegrt.hu">Tanulmányi Erdőgazdaság Zrt.</a>-->
            </div>
        </div>
    </body>
</html>