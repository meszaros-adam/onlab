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
            <a href="/" class="main-page" title="Főoldal"><h1>Erdei Iskola Eseménynaptár</h1></a>
                <div class="menu">
                    <ul class="menu-list">
                        <li><a href="/events" title="Események"> Események</a></li>
                        @can('create', 'App/Models/Event')
                        <li><a href="/events/create" title="Esemény létrehozása"> Esemény létrehozása</a></li>
                        @endcan
                        @can('viewAny', 'App/Models/User')
                        <li><a href="/users" title="Felhasználók">Felhasználók</a></li>
                        @endcan
                        @can('viewAny', 'App/Models/Registration')
                        <li><a href="/registrations" title="Regisztrációk">Regisztrációk</a></li>
                        @endcan
                        @if (Route::has('login'))
                            @auth
                            <li><a href="/home" title="Fiókom">Fiókom</a></li>
                            @else		
                            <li><a href="{{ route('login') }}" title="Bejelntkezés">Bejelentkezés</a></li>
                                @if (Route::has('register'))
                                <li><a href="{{ route('register') }}" title="Regisztráció">Regisztráció</a></li>
                                @endif
                            @endauth
                        @endif
                    </ul>
                </div>
            </div>
            
            <section class="content">
            @yield('content')
            </section>

            <div class="footer" >
                <div>Minden jog védve!</div>
                <a href="https://taegrt.hu">Tanulmányi Erdőgazdaság Zrt.</a>
            </div>
        </div>
    </body>
</html>