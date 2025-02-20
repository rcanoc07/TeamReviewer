@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="display-4 text-center mb-4">Rúbrica: {{ $rubrica->titulo }}</h1>

        <p><strong>Código:</strong> {{ $rubrica->codigo }}</p>
        <p><strong>Descripción:</strong> {{ $rubrica->descripcion }}</p>
        <p><strong>Claridad:</strong> {{ $rubrica->claridad ? 'Sí' : 'No' }}</p>
        <p><strong>Comentario:</strong> {{ $rubrica->comentario ? 'Sí' : 'No' }}</p>
        <p><strong>Número de Preguntas:</strong> {{ $rubrica->num_preguntas }}</p>

        <h3 class="mt-4 mb-3">Preguntas:</h3>

        <div class="list-group">
            @foreach(json_decode($rubrica->preguntas) as $index => $pregunta)
                <div class="list-group-item p-4 mb-3" style="border: 2px solid #007bff; border-radius: 10px; background-color: #f8f9fa;">
                    <h5 class="font-weight-bold" style="font-size: 1.5rem;">Pregunta {{ $index + 1 }}:</h5>
                    <p style="font-size: 1.2rem; line-height: 1.5;">
                        <strong>Pregunta:</strong> {{ $pregunta->pregunta }} <br>
                        <strong>Puntuación:</strong> {{ $pregunta->puntuacion }}
                    </p>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            <a href="{{ route('rubricas.edit', $rubrica) }}" class="btn btn-warning btn-lg">Editar</a>
            <a href="{{ route('rubricas.index') }}" class="btn btn-secondary btn-lg">Volver a la lista</a>
        </div>
    </div>
@endsection
