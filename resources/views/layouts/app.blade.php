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
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        /* Estilos generales */
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fa;
        }
        
        /* Sidebar */
        .sidebar {
            min-height: calc(100vh - 56px);
            background: #2c3e50;
            color: white;
            padding: 20px 0;
            width: 250px;
            position: fixed;
            top: 56px;
            left: 0;
            transition: all 0.3s;
            z-index: 100;
        }
        
        /* Contenido principal */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
            transition: all 0.3s;
        }
        
        /* Logo */
        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
            color: white;
        }
        
        /* Menú de navegación */
        .nav-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .nav-menu li {
            padding: 12px 20px;
            cursor: pointer;
            transition: all 0.3s;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .nav-menu li:hover, 
        .nav-menu li.active {
            background-color: #34495e;
        }
        
        .nav-menu li a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        
        .nav-menu li a i {
            margin-right: 10px;
            font-size: 1.1rem;
        }
        
        /* Páginas de autenticación */
        .auth-page {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f8f9fa;
            position: relative;
        }
        
        .auth-container {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
        }
        
        .auth-card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }
        
        .auth-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid #eee;
        }
        
        /* Estilos responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                width: 100%;
            }
        }
        
        /* Dropdown de usuario */
        .dropdown-menu {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        
        .dropdown-item {
            padding: 0.5rem 1.5rem;
        }
        
        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #2c3e50;
        }

        /* Estilo para el botón de registro */
        .nav-item .btn-primary {
            margin-left: 10px;
            padding: 0.375rem 0.75rem;
        }

        /* Botón de registro flotante */
        .register-float {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
        
        @media (max-width: 576px) {
            .register-float {
                position: static;
                margin: 20px auto;
                display: block;
                width: fit-content;
            }
        }
    </style>
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
                <a href="{{ route('register') }}" class="btn btn-outline-primary">
                    <i class="bi bi-person-plus me-1"></i> Registrarse
                </a>
            </div>
            @endif
            
            <main class="auth-container">
                @yield('content')
                
                @if(Request::is('login') && Route::has('password.request'))
                <div class="text-center mt-3">
                    <a class="btn btn-link text-decoration-none" href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>
                @endif
            </main>
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
        // Función para mostrar/ocultar el sidebar en móviles
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }

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
    @yield('scripts')
</body>
</html>