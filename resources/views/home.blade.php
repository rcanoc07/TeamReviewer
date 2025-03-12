@extends('layouts.app')

@section('content')
    <!-- Contenedor principal para la bienvenida -->
    <div class="d-flex align-items-center justify-content-center flex-grow-1">
        <div class="bg-white p-5 rounded-3 shadow-lg text-center border border-2 border-light">
            <!-- Icono de bienvenida -->
            <i class="bi bi-person-check display-1 text-primary"></i>
            <!-- Mensaje de bienvenida al usuario -->
            <h1 class="mt-3 fw-bold text-dark animate__animated animate__fadeInDown">
                ¡Bienvenido, {{ auth()->user()->name }}!
            </h1>
            <p class="mt-2 text-muted animate__animated animate__fadeInUp">
                Has iniciado sesión correctamente. Estamos felices de tenerte de vuelta.
            </p>
        </div>
    </div>

    <!-- Contenedor para las opciones del usuario según su rol -->
    <div class="container mt-5">
        <div class="row">
            <!-- Condición para mostrar opciones solo a los administradores -->
            @if(Auth()->user()->hasRole('admin'))
                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <!-- Sección de gestión de cursos -->
                        <div class="col-md-4">
                            <div class="p-4 bg-white rounded-3 shadow-sm text-center border">
                                <i class="bi bi-book display-4 text-primary"></i>
                                <h4 class="mt-3 fw-bold">Cursos</h4>
                                <p class="text-muted">
                                    Visualiza y gestiona los cursos disponibles en la plataforma. Puedes editar su contenido y administrar la información de cada curso.
                                </p>
                                <a href="{{ route('cursos.index') }}" class="btn btn-primary">Gestionar Cursos</a>
                            </div>
                        </div>

                        <!-- Sección de gestión de profesores -->
                        <div class="col-md-4">
                            <div class="p-4 bg-white rounded-3 shadow-sm text-center border">
                                <i class="bi bi-person-badge display-4 text-secondary"></i>
                                <h4 class="mt-3 fw-bold">Profesores</h4>
                                <p class="text-muted">
                                    Crea nuevos profesores, edita su información y visualiza la lista de docentes registrados en el sistema.
                                </p>
                                <a href="{{ route('usuarios.index', ['tipo' => 'profesor']) }}" class="btn btn-secondary">Gestionar Profesores</a>
                            </div>
                        </div>

                        <!-- Sección de gestión de alumnos -->
                        <div class="col-md-4">
                            <div class="p-4 bg-white rounded-3 shadow-sm text-center border">
                                <i class="bi bi-people display-4 text-success"></i>
                                <h4 class="mt-3 fw-bold">Alumnos</h4>
                                <p class="text-muted">
                                    Gestiona la información de los alumnos y visualiza la lista de estudiantes registrados en la plataforma.
                                </p>
                                <a href="{{ route('usuarios.index', ['tipo' => 'alumno']) }}" class="btn btn-success">Gestionar Alumnos</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Condición para mostrar opciones solo a los profesores -->
            @elseif(Auth()->user()->hasRole('profesor'))
                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <!-- Sección de gestión de cursos -->
                        <div class="col-md-4">
                            <div class="p-4 bg-white rounded-3 shadow-sm text-center border">
                                <i class="bi bi-journal-plus display-4 text-primary"></i>
                                <h4 class="mt-3 fw-bold">Crear Curso</h4>
                                <p class="text-muted">Crea un nuevo curso para tus alumnos.</p>
                                <a href="{{ route('cursos.create') }}" class="btn btn-primary">Crear Curso</a>
                            </div>
                        </div>

                        <!-- Sección de gestión de profesores -->
                        <div class="col-md-4">
                            <div class="p-4 bg-white rounded-3 shadow-sm text-center border">
                                <i class="bi bi-journal-text display-4 text-secondary"></i>
                                <h4 class="mt-3 fw-bold">Mis Cursos</h4>
                                <p class="text-muted">Gestiona los cursos en los que eres profesor.</p>
                                <a href="{{ route('cursos.index') }}" class="btn btn-primary">Ver mis Cursos</a>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(auth()->user()->hasRole('alumno'))
                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <!-- Sección de gestión de cursos -->
                        <div class="col-md-4">
                            <div class="p-4 bg-white rounded-3 shadow-sm text-center border">
                                <i class="bi bi-person-square display-4 text-primary"></i>
                                <h4 class="mt-3 fw-bold">Área Personal</h4>
                                <p class="text-muted">Consulta tus cursos y avances.</p>
                                <a href="{{ route('cursos.indexAlumno', 1) }}" class="btn btn-primary">Ir al Área Personal</a>
                            </div>
                        </div>

                        <!-- Sección de gestión de profesores -->
                        <div class="col-md-4">
                            <div class="p-4 bg-white rounded-3 shadow-sm text-center border">
                                <i class="bi bi-journal-bookmark display-4 text-success"></i>
                                <h4 class="mt-3 fw-bold">Cursos Disponibles</h4>
                                <p class="text-muted">Explora todos los cursos de la plataforma.</p>
                                <a href="{{ route('cursos.indexAlumno', 0) }}" class="btn btn-primary">Ver Cursos</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
