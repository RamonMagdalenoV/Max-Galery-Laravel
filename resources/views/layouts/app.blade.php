<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script src="https://kit.fontawesome.com/dda0018cf8.js"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body{
            font-size: 1rem;
        }
        .navbar-dark .navbar-nav .nav-link {
            color: #ffff;
            padding-right: 9px;
        }

        .navbar-dark .navbar-nav .nav-link:hover{
            background-color: #4aa0e6;
        }
    </style>


</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background-color: #3479AD;">
            <a class="navbar-brand" href="{{ url('/') }}">
                MaxGalery
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side -->
                <ul class="navbar-nav mr-auto">
                    <!-- Opciones del Sistema si el usuario esta autenticado -->
                    @auth
                        <li class="nav-item">
                            <router-link class="nav-link" to="/home">{{ __('Inicio') }}</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" to="/products">{{ __('Productos') }}</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" to="/providers">{{ __('Proveedores') }}</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" to="/categories">{{ __('Categorias') }}</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" to="/brands">{{ __('Marcas') }}</router-link>
                        </li>
                    @endauth
                </ul>

                <!-- Right Side -->
                <div class="navbar-nav d-flex" style="width: auto;">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @else
                        @auth
                            @if(auth()->user()->type == 'Administrador')
                                <li class="nav-item">
                                    <router-link class="nav-link"  to="/users">{{ __('Usuarios') }}</router-link>
                                </li>
                            @endif
                        @endauth
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </div>

            </div>
        </nav>

        <main class="py-4">
            @guest
                @yield('content')
            @endguest

            @auth
                <router-view></router-view>
            @endauth
        </main>
    </div>

</body>
</html>
