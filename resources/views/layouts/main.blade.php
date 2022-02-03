<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('img/app-icon.png') }}" type="image/x-icon">

    <title>{{ config('app.name', 'Pawstop') }}</title>

    @routes

    <!-- Scripts -->
    <script src="https://kit.fontawesome.com/feda2375e8.js"></script>
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

    @yield('style')
</head>
<body class="bg-white">
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar" class="">
            <div class="sidebar-header">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <div class="box">
                        <img src="{{ asset('img/app-icon.png') }}" alt="App Icon" width="32" height="32">
                        <span class="d-inline-block mx-3" style="color: #424242; font-size: 25px">
                            <b>{{ config('app.name', 'Pawstop') }}</b>
                        </span>
                    </div>
                </a>
            </div>

            <ul class="list-unstyled components px-3">
                <li class="mb-2 {{ Route::is('home') ? 'active' : '' }}">
                    <a href="{{ route('home') }}">Dashboard</a>
                </li>
                <li class="mb-2 {{ request()->is('admin*', 'product*') ? 'active' : '' }}">
                    <a href="#manageMenu" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle">Manage</a>
                    <ul class="list-unstyled collapse {{ request()->is('admin*', 'product*') ? 'show' : '' }}" id="manageMenu">
                        <li class="{{ request()->is('product*') ? 'active' : '' }}">
                            <a href="{{ route('product.index') }}">Products</a>
                        </li>
                        <li class="{{ request()->is('admin*') ? 'active' : '' }}">
                            <a href="{{ route('admin.index') }}">Users</a>
                        </li>
                    </ul>
                </li>
                {{-- <li class="mb-2">
                    <a href="#">Video Player</a>
                </li> --}}
            </ul>
        </nav>

        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="navbar-btn">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbar">

                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item {{ request()->is('profile*') ? 'active' : '' }}" style="background-color: #F5F5F5; border-radius: 5px;">
                                <a class="nav-link" href="{{ route('profile') }}">
                                    <div style="background-image: url(@if(Auth::user()->avatar) {{ Auth::user()->avatar }} @else {{ asset('img/profile-default.png') }} @endif); border: 3px solid #555;" class="avatar shadow-sm mr-2 d-inline-block"></div>

                                    <span class="mr-1">
                                        {{ Auth::user()->name }}
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item {{ request()->is('security*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('security') }}">Security</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <main id="app">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

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

        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
                $(this).toggleClass('active');
            });
        });
    </script>

    @yield('script')
</body>
</html>
