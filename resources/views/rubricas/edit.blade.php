@extends('layouts.app')

@section('title', 'Editar Rúbrica')

@section('content')
    <div class="card">
        <div class="card-header">Editar Rúbrica</div>
        <div class="card-body">
            <form action="{{ route('rubricas.update', $rubrica->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="codigo" class="form-label">Código de la Rúbrica</label>
                    <input type="text" class="form-control" id="codigo" name="codigo" value="{{ old('codigo', $rubrica->codigo) }}" required>
                </div>

                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" value="{{ old('titulo', $rubrica->titulo) }}" required>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required>{{ old('descripcion', $rubrica->descripcion) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="claridad" class="form-label">¿Evaluar Claridad?</label>
                    <select class="form-select" id="claridad" name="claridad" required>
                        <option value="1" {{ $rubrica->claridad == 1 ? 'selected' : '' }}>Sí</option>
                        <option value="0" {{ $rubrica->claridad == 0 ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="comentario" class="form-label">¿Permitir Comentarios?</label>
                    <select class="form-select" id="comentario" name="comentario" required>
                        <option value="1" {{ $rubrica->comentario == 1 ? 'selected' : '' }}>Sí</option>
                        <option value="0" {{ $rubrica->comentario == 0 ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="num_preguntas" class="form-label">Número de Preguntas</label>
                    <input type="number" class="form-control" id="num_preguntas" name="num_preguntas" min="1" value="{{ old('num_preguntas', $rubrica->num_preguntas) }}" required>
                </div>

                <div id="preguntas_fields">
                    @foreach(json_decode($rubrica->preguntas) as $index => $pregunta)
                        <div class="mb-3">
                            <label for="preguntas_{{ $index }}_pregunta" class="form-label">Pregunta {{ $index + 1 }}</label>
                            <input type="text" class="form-control" id="preguntas_{{ $index }}_pregunta" name="preguntas[{{ $index }}][pregunta]" value="{{ old('preguntas.' . $index . '.pregunta', $pregunta->pregunta) }}" required>

                            <label for="preguntas_{{ $index }}_puntuacion" class="form-label">Puntuación {{ $index + 1 }}</label>
                            <input type="number" class="form-control" id="preguntas_{{ $index }}_puntuacion" name="preguntas[{{ $index }}][puntuacion]" min="0" value="{{ old('preguntas.' . $index . '.puntuacion', $pregunta->puntuacion) }}" required>
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-primary">Actualizar Rúbrica</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('num_preguntas').addEventListener('input', function() {
            const numPreguntas = parseInt(this.value);
            const container = document.getElementById('preguntas_fields');
            const existingQuestions = container.querySelectorAll('.mb-3').length;

            // Limpiar campos previos
            for (let i = existingQuestions; i < numPreguntas; i++) {
                const preguntaDiv = document.createElement('div');
                preguntaDiv.classList.add('mb-3');
                preguntaDiv.innerHTML = `
                    <label for="preguntas_${i}_pregunta" class="form-label">Pregunta ${i + 1}</label>
                    <input type="text" class="form-control" id="preguntas_${i}_pregunta" name="preguntas[${i}][pregunta]" required>

                    <label for="preguntas_${i}_puntuacion" class="form-label">Puntuación ${i + 1}</label>
                    <input type="number" class="form-control" id="preguntas_${i}_puntuacion" name="preguntas[${i}][puntuacion]" min="0" required>
                `;
                container.appendChild(preguntaDiv);
            }

            // Eliminar preguntas extra si se reduce el número
            for (let i = numPreguntas; i < existingQuestions; i++) {
                container.removeChild(container.lastChild);
            }
        });
    </script>
@endsection
