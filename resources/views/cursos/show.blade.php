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

                        <!-- Las rúblicas creadas por el profesor y si eres profesor que te salga un "Añadir rública" -->

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
