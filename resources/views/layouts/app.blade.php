<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('img/app-icon.png') }}" type="image/x-icon">

    <title>{{ config('app.name', 'Pawstop') }}</title>

    <!-- Scripts -->
    <script src="https://kit.fontawesome.com/feda2375e8.js"></script>
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
</head>
<body class="bg-white">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light" style="z-index: 1000;">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <div class="box">
                        <img src="{{ asset('img/app-icon.png') }}" alt="App Icon" width="32" height="32">
                        <span class="d-inline-block mx-3" style="color: #424242; font-size: 25px">
                            <b>{{ config('app.name', 'Pawstop') }}</b>
                        </span>
                    </div>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse bg-white" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link @if(Route::is('login')) active @endif" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link @if(Route::is('register')) active @endif" href="{{ route('register') }}">{{ __('Sign Up') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <div style="background-image: url(@if(Auth::user()->avatar) {{ Auth::user()->avatar }} @else {{ asset('img/profile-default.png') }} @endif)" class="avatar shadow-sm mr-2 d-inline-block"></div>

                                    <span class="mr-1">
                                        {{ Auth::user()->name }}
                                    </span>

                                    <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item @if(Route::is('profile')) active @endif" href="{{ route('profile') }}">
                                        {{ __('Profile') }}
                                    </a>

                                    <a class="dropdown-item @if(Route::is('security')) active @endif" href="{{ route('security') }}">
                                        {{ __('Security') }}
                                    </a>

                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

    <script>
        const swalWithBoostrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary rounded-button',
            },
            buttonsStyling: false,
        })

        @if(Session::has('warning'))
            swalWithBoostrapButtons.fire({
                title: 'Arf - arf!',
                html: '{!! __(Session::get("warning")) !!}',
                type: 'warning',
            })
        @elseif(Session::has('success'))
            swalWithBoostrapButtons.fire({
                title: 'Awoo!',
                html: '{!! __(Session::get("success")) !!}',
                type: 'success',
            })
        @elseif(Session::has('info'))
            swalWithBoostrapButtons.fire({
                title: 'Hmmm?',
                html: '{!! __(Session::get("info")) !!}',
                type: 'info',
            })
        @elseif(Session::has('question'))
            swalWithBoostrapButtons.fire({
                title: 'Hmmm?',
                html: '{!! __(Session::get("question")) !!}',
                type: 'question',
            })
        @elseif(Session::has('error'))
            swalWithBoostrapButtons.fire({
                title: 'Grrrr!',
                html: '{!! __(Session::get("error")) !!}',
                type: 'error',
            })
        @endif
    </script>

    @yield('script')
</body>
</html>
