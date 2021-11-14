<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Eseménynaptár">
        <meta name="keywords" content="Eseménynaptár, Erdei iskola, Sopron">
        <title>Eseménynaptár</title>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <div class="page-container">
            <div class="topnav" id="myTopnav">

                <a href="/" class="logo" title="Kezdőlap">Eseménynaptár</a>
                <a class="nav-button" href="/events" title="Események">Események</a>

                        @guest
                                @if (Route::has('register'))
                                    <a class="nav-button" href="{{ route('register') }}">Regisztráció</a>
                                @endif

                                @if (Route::has('login'))
                                    <a class="nav-button" href="{{ route('login') }}">Bejelentkezés</a>
                                @endif

                        @else
                                    <a href="/home">Regisztrációim</a>
                                    <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                            Kijelentkezés
                                    </a>  
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                                        @csrf
                                        </form>                               
                                    <!-- <div class="dropdown">
                                        <a class="nav-button">                                            
                                            {{ Auth::user()->name }}
                                            @if(Auth::user()->admin==1)
                                                (Admin) 
                                            @endif
                                            <i class="arrow down"></i>
                                        </a>                                        
                                        <div class="dropdown-content">
                                            <a href="/home">Regisztrációim</a>
                                            <a href="{{ route('logout') }}"
                                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                                        Kijelentkezés
                                            </a>
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                                        @csrf
                                                    </form>
                                        </div>
                                    </div> -->
                        @endguest

                        @can('viewAny', 'App/Models/Registration')
                            <a class="nav-button" href="/registrations" title="Regisztrációk">Regisztrációk</a>
                        @endcan

                        @can('viewAny', 'App/Models/User')
                            <a class="nav-button" href="/users" title="Felhasználók">Felhasználók</a>
                        @endcan

                        @can('create', 'App/Models/Event')
                            <a class="nav-button" href="/events/create" title="Esemény létrehozása">Esemény létrehozása</a>
                        @endcan
                            <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                                <i class="fa fa-bars"></i>
                            </a>
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

<script>
    function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
</script>
