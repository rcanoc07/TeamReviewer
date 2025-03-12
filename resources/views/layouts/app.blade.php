<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TeamReviewer') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Agregar tu archivo CSS aquí -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <!-- Iconos de Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="d-flex flex-column min-vh-100"> <!-- Cambio 1: Flexbox en el body -->
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'TeamReviewer') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                    @if(auth()->user()->hasRole('admin'))
                        <!-- Todos los cursos existentes -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cursos.index') }}">Cursos</a>
                        </li>
                        <!-- Todos los profesores registrados y también la posibilidad de crear un usuario (profesor) -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('usuarios.index', ['tipo' => 'profesor']) }}">Profesores</a>
                        </li>
                        <!-- Todos los alumnos registrados -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('usuarios.index', ['tipo' => 'alumno']) }}">Alumnos</a>
                        </li>
                    @elseif(auth()->user()->hasRole('profesor'))
                        <!-- Formulario para crear un nuevo curso -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cursos.create') }}">Crear curso</a>
                        </li>
                        <!-- Listado de todos los cursos en la base de datos -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cursos.index') }}">Mis cursos</a>
                        </li>
                        <!-- Agregar enlace a las rúbricas -->
                        <li class="nav-item">
                            <a class="nav-link" href="#">Rúbricas</a>
                        </li>
                    @elseif(auth()->user()->hasRole('alumno'))
                        <!-- Área personal del alumno, para ver los cursos en los que está registrado -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cursos.indexAlumno', 1) }}">Área personal</a>
                        </li>
                        <!-- Todos los cursos que se encuentran en la aplicación -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cursos.indexAlumno', 0) }}">Cursos</a>
                        </li>
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('perfil') }}">
                                    {{ __('Mi cuenta') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Cerrar sesión') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1 py-4"> <!-- Cambio 2: flex-grow-1 para ocupar espacio restante -->
        @yield('content')
    </main>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
