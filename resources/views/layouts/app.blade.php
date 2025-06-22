<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SAMI') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
</head>
<body>
    <div id="app">
        @unless(Request::is('login') || Request::is('register') || Request::is('password/reset*') || Request::is('password/email'))
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <button class="navbar-toggler d-md-none me-2" type="button" onclick="toggleSidebar()">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/home') }}">
                    <strong>SAMI</strong>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" 
                               role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-1"></i>
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="bi bi-person me-2"></i> Perfil
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                        @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar sesión
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary" href="{{ route('register') }}">
                                <i class="bi bi-person-plus me-1"></i> Registrarse
                            </a>
                        </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
        @endunless

        @if(Request::is('login') || Request::is('register') || Request::is('password/reset*') || Request::is('password/email'))
        <div class="auth-page">
            @if(Request::is('login'))
            <div class="register-float">
                
            </div>
            @endif
            
            
                @yield('content')
                
                @if(Request::is('login') && Route::has('password.request'))
                <div class="text-center mt-3">
                    
                </div>
                @endif
            
        </div>
        @else
        <div class="d-flex">
            <!-- Sidebar -->
            <div class="sidebar" id="sidebar">
                <div class="logo">SAMI</div>
                <ul class="nav-menu">
                    <li class="{{ request()->is('home') ? 'active' : '' }}">
                        <a href="{{ url('/home') }}"><i class="bi bi-house-door"></i> Inicio</a>
                    </li>
                    <li class="{{ request()->is('horarios') ? 'active' : '' }}">
                        <a href="{{ route('horarios') }}"><i class="bi bi-calendar3"></i> Horarios</a>
                    </li>
                    <li class="{{ request()->is('citas') ? 'active' : '' }}">
                        <a href="#"><i class="bi bi-clipboard2-pulse"></i> Citas</a>
                    </li>
                    <li class="{{ request()->is('expedientes') ? 'active' : '' }}">
                        <a href="#"><i class="bi bi-folder"></i> Expedientes</a>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <main class="main-content py-4">
                @yield('content')
            </main>
        </div>
        @endif
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        

        // Inicializar todos los dropdowns de Bootstrap
        document.addEventListener('DOMContentLoaded', function() {
            var dropdowns = document.querySelectorAll('.dropdown-toggle');
            dropdowns.forEach(function(dropdown) {
                dropdown.addEventListener('click', function(e) {
                    e.preventDefault();
                    var dropdownMenu = this.nextElementSibling;
                    dropdownMenu.classList.toggle('show');
                });
            });

            // Cerrar dropdowns al hacer click fuera
            document.addEventListener('click', function(e) {
                if (!e.target.matches('.dropdown-toggle')) {
                    var dropdowns = document.querySelectorAll('.dropdown-menu');
                    dropdowns.forEach(function(dropdown) {
                        dropdown.classList.remove('show');
                    });
                }
            });
        });

        
    </script>
</body>




</html>