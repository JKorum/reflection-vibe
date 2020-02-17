<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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
    <!-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> -->

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- animations -->
    <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">
    <!-- icons -->
    <script src="https://kit.fontawesome.com/df3682f87e.js" crossorigin="anonymous"></script>

    <script src="{{ asset('js/navbar.js') }}" defer></script>
</head>

<body>
    <div id="app" class="position-relative">

        <nav id='navbar' class="navbar navbar-expand-md navbar-light bg-white fixed-top">
            <div class="container">
                <div class="navbar-brand">
                    @auth
                    <a href="/posts" class='text-decoration-none text-reset'>
                        <i class="fas fa-camera-retro"></i>
                        <span id='project-name' class="animated faster">Reflection Vibe</span>
                    </a>
                    @endauth
                    @guest
                    <i class="fas fa-camera-retro"></i>
                    Reflection Vibe
                    @endguest
                </div>

                <ul class="navbar-nav ml-auto d-flex flex-row">
                    @auth
                    <li class="nav-item px-2">
                        <i class="far fa-compass fa-lg"></i>
                    </li>

                    <li class="nav-item px-2">
                        <i class="far fa-heart fa-lg"></i>
                    </li>

                    <li class="nav-item px-2">
                        <a href="/profiles/{{Auth::user()->id}}" class='text-decoration-none text-reset'>
                            <i class="far fa-user fa-lg"></i>
                        </a>
                    </li>

                    <li class="nav-item px-2">
                        <a href="{{ route('logout') }}" class='text-decoration-none text-reset'>
                            <i class="fas fa-sign-out-alt fa-lg" onclick="event.preventDefault(); 
                                document.getElementById('logout-form').submit();"></i>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                    @endauth
                    @guest
                    <li class="nav-item px-2">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    @if (Route::has('register'))
                    <li class="nav-item px-2">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                    @endif
                    @endguest
                </ul>
            </div>
        </nav>

        <main class="py-5 mt-4">
            @yield('content')
        </main>
    </div>

</body>

</html>