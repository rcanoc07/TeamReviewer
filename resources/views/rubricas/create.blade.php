    @extends('layouts.app')

    @section('title', 'Crear Rúbrica')

    @section('content')
        <div class="card">
            <div class="card-header">Crear Nueva Rúbrica</div>
            <div class="card-body">
                <form action="{{ route('rubricas.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="codigo" class="form-label">Código de la Rúbrica</label>
                        <input type="text" class="form-control" id="codigo" name="codigo" required>
                    </div>

                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="claridad" class="form-label">¿Evaluar Claridad?</label>
                        <select class="form-select" id="claridad" name="claridad" required>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="comentario" class="form-label">¿Permitir Comentarios?</label>
                        <select class="form-select" id="comentario" name="comentario" required>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="num_preguntas" class="form-label">Número de Preguntas</label>
                        <input type="number" class="form-control" id="num_preguntas" name="num_preguntas" min="1" required>
                    </div>

                    <div id="preguntas_fields"></div>

                    <button type="submit" class="btn btn-primary">Guardar Rúbrica</button>
                </form>
            </div>
        </div>

        <script>
            document.getElementById('num_preguntas').addEventListener('input', function() {
                const numPreguntas = parseInt(this.value);
                const container = document.getElementById('preguntas_fields');
                container.innerHTML = '';  // Limpiar campos previos

                for (let i = 0; i < numPreguntas; i++) {
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
            });

        </script>
    @endsection
