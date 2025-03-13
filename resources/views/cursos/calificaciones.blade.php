@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Detalles del curso -->
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card shadow-lg rounded border-0">
                    <div class="card-body p-4">
                        <!-- Título del curso -->
                        <h1 class="mb-4 text-center text-primary">{{ $curso->titulo }}</h1>

                        <!-- Botones -->
                        <div class="d-flex justify-content-center gap-3 mb-4">
                            <a href="{{ route('cursos.show', $curso->id) }}" class="btn btn-outline-primary btn-sm">Curso</a>
                            <a href="{{ route('cursos.participantes', $curso->id) }}" class="btn btn-outline-success btn-sm">Participantes</a>
                            <a href="{{ route('correcciones.show', $curso->id) }}" class="btn btn-outline-warning btn-sm">Calificaciones</a>
                            <a href="{{ route('cursos.sobre', $curso->id) }}" class="btn btn-outline-info btn-sm">Sobre el curso</a>
                        </div>

                        <!-- Línea divisoria -->
                        <hr class="my-4">

                        <!-- Mostrar las correcciones de los alumnos -->
                        <h3 class="mb-3">Calificaciones de los Alumnos</h3>

                        @if ($correcciones->isEmpty())
                            <div class="alert alert-info">
                                No hay calificaciones disponibles para este curso.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Alumno</th>
                                        <th>Rúbrica</th>
                                        <th>Nota</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($correcciones as $correccion)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $correccion->respuesta->alumno->name }}</td>
                                            <td>
                                                <a href="{{ route('rubricas.show', $correccion->respuesta->rubrica->id) }}">
                                                    {{ $correccion->respuesta->rubrica->titulo }}
                                                </a>
                                            </td>
                                            <td>{{ $correccion->nota }}</td>
                                            <td>
                                                <a href="{{ route('correcciones.show', $correccion->id) }}" class="btn btn-info btn-sm">Ver Detalles</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
