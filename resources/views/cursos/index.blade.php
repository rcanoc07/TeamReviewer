@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4 text-center">Cursos Disponibles</h1>

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

                            <!-- Botones alineados a la izquierda con espacio entre ellos -->
                            <div class="d-flex mt-3 gap-3">
                                <a href="#" class="btn btn-outline-primary btn-sm">Ver Más</a>

                                <!-- Botón Editar -->
                                <a href="#" class="btn btn-outline-warning btn-sm">Editar</a>

                                <!-- Botón Borrar -->
                                <form action="#" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres borrar este curso?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Borrar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
