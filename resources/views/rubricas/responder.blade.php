@extends('layouts.app')

@section('title', 'Responder Rúbrica')

@section('content')
    <div class="container">
        <h1>Responder Rúbrica: {{ $rubrica->titulo }}</h1>

        <form action="{{ route('rubricas.guardarRespuesta', $rubrica->id) }}" method="POST">
            @csrf

            <!-- Campo oculto para el ID de la rúbrica -->
            <input type="hidden" name="rubrica_id" value="{{ $rubrica->id }}">

            <!-- Campo oculto para el ID del alumno -->
            <input type="hidden" name="alumno_id" value="{{ Auth::id() }}">

            <!-- Preguntas de la rúbrica -->
            @foreach (json_decode($rubrica->preguntas, true) as $index => $pregunta)
                <div class="mb-3">
                    <label for="respuesta_{{ $index }}" class="form-label">{{ $pregunta['pregunta'] }}</label>
                    <input type="text" class="form-control" id="respuesta_{{ $index }}" name="respuestas[{{ $index }}][puntuacion]" required>
                    <input type="hidden" name="respuestas[{{ $index }}][pregunta]" value="{{ $pregunta['pregunta'] }}">
                </div>
            @endforeach

            <button type="submit" class="btn btn-primary">Enviar Respuesta</button>
        </form>
    </div>
@endsection
