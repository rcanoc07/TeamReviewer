@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4 text-center">Cursos</h1>

        <div class="row">
            @foreach ($cursos as $curso)
                <div class="col-md-12 mb-4">
                    <!-- Card -->
                    <div class="card shadow-lg rounded border-0">
                        <div class="card-body p-4">
                            <!-- Título -->
                            <h4 class="card-title mb-3 text-primary">{{ $curso->titulo }}</h4>

                            <!-- Descripción -->
                            <p class="card-text text-muted">{{ $curso->descripcion }}</p>

                            <!-- Acciones -->
                            <div class="d-flex mt-3 gap-3">
                                @if(auth()->user()->hasRole('profesor') || auth()->user()->hasRole('admin'))
                                    <!-- Botón Ver Más -->
                                    <a href="{{ route('cursos.show', $curso->id) }}" class="btn btn-outline-primary btn-sm">Ver Más</a>

                                    <!-- Botón Editar -->
                                    <a href="#" class="btn btn-outline-warning btn-sm">Editar</a>

                                    <!-- Botón Borrar -->
                                    <form action="#" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres borrar este curso?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">Borrar</button>
                                    </form>

                                @elseif(auth()->user()->hasRole('alumno'))
                                    @if($curso->participantes->contains(auth()->user()->id))
                                        <!-- Si el alumno está inscrito -->
                                        <a href="{{ route('cursos.show', $curso->id) }}" class="btn btn-outline-primary btn-sm">Acceder al Curso</a>
                                    @else
                                        <!-- Si no está inscrito, mostrar el formulario para inscribirse -->
                                        <form action="{{ route('cursos.inscribirse', $curso->id) }}" method="POST">
                                            @csrf
                                            <div class="input-group">
                                                <input type="text" name="codigo" class="form-control" placeholder="Código del curso" required>
                                                <button type="submit" class="btn btn-success btn-sm">Inscribirse</button>
                                            </div>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
