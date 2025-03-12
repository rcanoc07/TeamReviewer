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

                        <!-- Participantes -->
                        <h4 class="text-primary">Participantes</h4>
                        <div class="row">
                            @foreach ($curso->participantes as $participante)
                                <div class="col-md-6 mb-4">
                                    <div class="card shadow-sm rounded border-0">
                                        <div class="card-body p-3 d-flex justify-content-between align-items-center">
                                            <!-- Nombre y correo del participante -->
                                            <div>
                                                <h5 class="card-title">{{ $participante->name }}</h5>
                                                <p class="card-text">{{ $participante->email }}</p>
                                            </div>

                                            @if(auth()->user()->hasRole('profesor'))
                                                <!-- Botón para sacar al participante del curso -->
                                                <form action="{{ route('cursos.remove_participante', [$curso->id, $participante->id]) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres sacar a este participante del curso?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm">Eliminar</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
