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

                        <!-- Información sobre el curso -->
                        <h4 class="text-primary">Descripción del Curso</h4>
                        <p class="card-text">{{ $curso->descripcion }}</p>

                        <!-- Profesor del curso -->
                        <h4 class="text-primary mt-4">Profesor</h4>
                        @if ($curso->user) <!-- Verificamos si el curso tiene un profesor -->
                        <p class="card-text"><strong>Nombre:</strong> {{ $curso->user->name }}</p>
                        <p class="card-text"><strong>Email:</strong> {{ $curso->user->email }}</p>
                        @else
                            <p class="card-text text-muted">No se ha asignado un profesor a este curso.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
