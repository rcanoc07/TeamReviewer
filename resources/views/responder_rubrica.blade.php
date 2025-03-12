@extends('layouts.app')

@section('title', 'Responder Rúbrica')

@section('content')
    <div class="card">
        <div class="card-header">Responder Rúbrica: {{ $rubrica->titulo }}</div>
        <div class="card-body">
            <form action="{{ route('rubricas.responder', $rubrica->id) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="codigo" class="form-label">Código de la Rúbrica</label>
                    <input type="text" class="form-control" id="codigo" name="codigo" value="{{ $rubrica->codigo }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" value="{{ $rubrica->titulo }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" readonly>{{ $rubrica->descripcion }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="claridad" class="form-label">¿Evaluar Claridad?</label>
                    <input type="text" class="form-control" id="claridad" name="claridad" value="{{ $rubrica->claridad ? 'Sí' : 'No' }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="comentario" class="form-label">¿Permitir Comentarios?</label>
                    <input type="text" class="form-control" id="comentario" name="comentario" value="{{ $rubrica->comentario ? 'Sí' : 'No' }}" readonly>
                </div>

                <hr>

                <h4>Preguntas</h4>

                @foreach (json_decode($rubrica->preguntas, true) as $index => $pregunta)
                    <div class="mb-3">
                        <label for="respuestas_{{ $index }}_pregunta" class="form-label">Pregunta {{ $index + 1 }}</label>
                        <input type="text" class="form-control" id="respuestas_{{ $index }}_pregunta" name="respuestas[{{ $index }}][pregunta]" value="{{ $pregunta['pregunta'] }}" readonly>

                        <label for="respuestas_{{ $index }}_puntuacion" class="form-label">Puntuación (Máxima: {{ $pregunta['puntuacion'] }})</label>
                        <input type="number" class="form-control" id="respuestas_{{ $index }}_puntuacion" name="respuestas[{{ $index }}][puntuacion]" min="0" max="{{ $pregunta['puntuacion'] }}" required>
                    </div>
                @endforeach

                <div class="mb-3">
                    <label for="comentario_alumno" class="form-label">Comentario (opcional)</label>
                    <textarea class="form-control" id="comentario_alumno" name="comentario_alumno" rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Enviar Respuesta</button>
            </form>
        </div>
    </div>
@endsection
