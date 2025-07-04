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
    
    <style>
        /* Estilos generales del sidebar */
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #6C5CE7;
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            padding-top: 60px;
            transition: all 0.3s;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        .logo {
            padding: 15px 20px;
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .nav-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1;
        }

        .nav-menu li {
            margin: 0;
        }

        .nav-menu li a {
            display: block;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }

        .nav-menu li a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #A29BFE;
        }

        .nav-menu li a i {
            margin-right: 10px;
        }

        .nav-menu li.active a {
            background-color: rgba(255, 255, 255, 0.2);
            border-left: 4px solid #A29BFE;
        }

        /* Estilos para el menú de usuario en el sidebar */
        .sidebar-user {
            padding: 15px 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: auto;
        }

        .sidebar-user .user-info {
            display: flex;
            align-items: center;
            color: white;
            margin-bottom: 10px;
        }

        .sidebar-user .user-info i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .sidebar-user .user-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-user .user-menu li {
            margin: 5px 0;
        }

        .sidebar-user .user-menu a {
            display: block;
            padding: 8px 10px;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: all 0.3s;
        }

        .sidebar-user .user-menu a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar-user .user-menu .divider {
            height: 1px;
            background-color: rgba(255, 255, 255, 0.1);
            margin: 8px 0;
        }

        /* Estilos para el contenido principal */
        .main-content {
            margin-left: 250px;
            width: calc(100% - 250px);
            padding: 20px;
            transition: all 0.3s;
        }

        /* ===== NUEVOS ESTILOS OPTIMIZADOS PARA EL NAVBAR ===== */
        .navbar {
            padding: 0.5rem 1rem;
            min-height: 60px;
            position: relative;
            z-index: 1001;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar-container {
            display: flex;
            width: 100%;
            align-items: center;
        }

        .navbar-brand-container {
            display: flex !important;
            align-items: center;
            gap: 10px;
            height: 100%;
            padding: 0 15px;
            z-index: 1002;
            position: relative;
            text-decoration: none;
        }

        .navbar-logo-img {
            width: 36px;
            height: 36px;
            min-width: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #6C5CE7;
            display: block;
            flex-shrink: 0;
        }

        .navbar-brand-text {
            font-weight: bold;
            color: #6C5CE7;
            font-size: 1.25rem;
            white-space: nowrap;
            margin: 0;
            line-height: 1;
        }

        .navbar-nav-container {
            display: flex;
            margin-left: auto;
            align-items: center;
        }

        /* Botón de hamburguesa */
        .navbar-toggler {
            border: none;
            font-size: 1.25rem;
            padding: 0.5rem;
            background: transparent;
        }

        .navbar-toggler:focus {
            box-shadow: none;
            outline: none;
        }

        /* Estilos para móviles */
        @media (max-width: 767.98px) {
            .sidebar {
                left: -250px;
            }

            .sidebar.show {
                left: 0;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .navbar-brand-container {
                position: absolute;
                left: 50%;
                transform: translateX(-50%);
            }
            
            .navbar-toggler {
                order: -1;
                margin-right: auto;
            }
            
            .navbar-nav-container {
                width: 100%;
                justify-content: flex-end;
            }
        }

        /* Estilos para desktop */
        @media (min-width: 768px) {
            .navbar-brand-container {
                margin-left: 0;
                padding-left: 0;
            }
            
            .navbar-logo-img {
                width: 40px;
                height: 40px;
                min-width: 40px;
            }
        }

        /* Overlay para móviles cuando el sidebar está abierto */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        }

        .sidebar.show + .sidebar-overlay {
            display: block;
        }

        /* Garantizar que no haya conflicto con Bootstrap */
        .navbar-collapse {
            flex-grow: 0 !important;
        }
    </style>

    @stack('styles')
</head>
<body>
    <div id="app">
        @unless(Request::is('login') || Request::is('register') || Request::is('medico/login') || Request::is('password/reset*') || Request::is('password/email'))
        <nav class="navbar navbar-light bg-white shadow-sm">
            <div class="container-fluid navbar-container">
                <!-- Botón hamburguesa solo para móvil -->
                @if(Auth::guard('medico')->check() || Auth::check())
                <button class="navbar-toggler d-md-none" type="button" onclick="toggleSidebar()">
                    <span class="navbar-toggler-icon"></span>
                </button>
                @endif
                
                <!-- Logo y texto - siempre visible -->
                <a href="{{ Auth::guard('medico')->check() ? url('/home') : (Auth::check() ? url('/paciente/dashboard') : url('/')) }}" class="navbar-brand-container">
                    <img src="{{ asset('images/logo1.png') }}" alt="Logo SAMI" class="navbar-logo-img">
                    <span class="navbar-brand-text">SAMI</span>
                </a>

        <!-- Menú de navegación derecho -->
        <div class="navbar-nav-container">
            <ul class="navbar-nav">
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar Sesión
                    </a>
                </li>
                <li class="nav-item ms-2">
                    <a class="btn btn-primary" href="{{ route('register') }}">
                        <i class="bi bi-person-plus me-1"></i> Registrarse
                    </a>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
        
        @endunless

        @if(Request::is('login') || Request::is('register') || Request::is('medico/login') || Request::is('password/reset*') || Request::is('password/email'))
        <div class="auth-page">
            <main class="auth-container">
                @yield('content')
            </main>
        </div>
        @else
        <div class="d-flex">
            <!-- Sidebar -->
            @if(Auth::guard('medico')->check() || Auth::check())
            <div class="sidebar" id="sidebar">
                <div class="logo">SAMI</div>
                <ul class="nav-menu">
                    @if(Auth::guard('medico')->check())
    <!-- Menú para médico -->
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
                    @else
                    <!-- Menú para paciente -->
                    <li class="{{ request()->is('paciente/dashboard') ? 'active' : '' }}">
                        <a href="{{ url('/paciente/dashboard') }}"><i class="bi bi-house-door"></i> Inicio</a>
                    </li>
                    <li class="{{ request()->is('paciente/citas') ? 'active' : '' }}">
                        <a href="#"><i class="bi bi-calendar-check"></i> Mis Citas</a>
                    </li>
                    <li class="{{ request()->is('paciente/expediente') ? 'active' : '' }}">
                        <a href="#"><i class="bi bi-file-earmark-medical"></i> Mi Expediente</a>
                    </li>
                    @endif
                </ul>

                <div class="sidebar-user">
                    <div class="user-info">
                        <i class="bi bi-person-circle"></i>
                        {{ Auth::guard('medico')->check() ? Auth::guard('medico')->user()->nombre_completo : Auth::user()->nombre }}
                    </div>
                    <ul class="user-menu">
                        <li>
                            <a href="#">
                                <i class="bi bi-person me-2"></i> Perfil
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <form id="logout-form" action="{{ Auth::guard('medico')->check() ? route('medico.logout') : route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-link text-white p-0 text-start w-100">
                                    <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            @endif

            <!-- Overlay para móviles -->
            <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

            <!-- Main Content -->
            <main class="main-content py-4" style="@if(!Auth::guard('medico')->check() && !Auth::check()) margin-left: 0; width: 100%; @endif">
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
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
            
            const overlay = document.getElementById('sidebarOverlay');
            if (sidebar.classList.contains('show')) {
                overlay.style.display = 'block';
                document.body.style.overflow = 'hidden';
            } else {
                overlay.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }

        // Cerrar sidebar al hacer clic en un enlace (solo en móviles)
        document.querySelectorAll('.nav-menu a, .sidebar-user a').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 768) {
                    toggleSidebar();
                }
            });
        });

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