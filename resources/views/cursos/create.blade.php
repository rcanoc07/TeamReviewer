@extends('layouts.app')

@section('title', 'Crear Curso')

@section('content')
    <div class="card">
        <div class="card-header">Crear Nuevo Curso</div>
        <div class="card-body">
            <form action="{{ route('cursos.store') }}" method="POST">
                @csrf

                <!-- Título -->
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título del Curso</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" required>
                </div>

                <!-- Descripción -->
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                </div>

                <!-- Código del Curso (Contraseña para inscribirse) -->
                <div class="mb-3">
                    <label for="codigo" class="form-label">Código del Curso</label>
                    <input type="text" class="form-control" id="codigo" name="codigo" required>
                    <small class="text-muted">Los alumnos usarán este código para inscribirse en el curso.</small>
                </div>

                <button type="submit" class="btn btn-primary">Crear Curso</button>
            </form>
        </div>
    </div>
@endsection
