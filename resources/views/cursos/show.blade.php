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
                            <a href="#" class="btn btn-outline-warning btn-sm">Calificaciones</a>
                            <a href="{{ route('cursos.sobre', $curso->id) }}" class="btn btn-outline-info btn-sm">Sobre el curso</a>
                        </div>

                        <!-- Línea divisoria -->
                        <hr class="my-4">

                        <!-- Mostrar las rúbricas disponibles -->
                        <h3 class="mb-3">Rúbricas Disponibles</h3>

                        @if ($rubricas->isEmpty())
                            <div class="alert alert-info">
                                No hay rúbricas disponibles para este curso.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Código</th>
                                        <th>Título</th>
                                        <th>Descripción</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($rubricas as $rubrica)
                                        <tr>
                                            <td>{{ $rubrica->id }}</td>
                                            <td>{{ $rubrica->codigo }}</td>
                                            <td>{{ $rubrica->titulo }}</td>
                                            <td>{{ Str::limit($rubrica->descripcion, 50) }}</td>
                                            <td>
                                                <a href="{{ route('rubricas.show', $rubrica->id) }}" class="btn btn-info btn-sm">Ver</a>
                                                @if (Auth::user()->hasRole('profesor'))
                                                    <a href="{{ route('rubricas.edit', $rubrica->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                                    <form action="{{ route('rubricas.destroy', $rubrica->id) }}" method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        <!-- Botón para añadir rúbrica (solo para profesores) -->
                        @if (Auth::user()->hasRole('profesor'))
                            <div class="mt-4">
                                <a href="{{ route('rubricas.create', ['curso_id' => $curso->id]) }}" class="btn btn-primary">Añadir Rúbrica</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
