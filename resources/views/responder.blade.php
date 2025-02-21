<?php
@extends('layouts.app')

@section('title', 'Responder Rúbrica')

@section('content')
    <div class="card">
        <div class="card-header">Responder Rúbrica</div>
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

                @foreach (json_decode($rubrica->preguntas, true) as $index => $pregunta)
                    <div class="mb-3">
                        <label for="respuestas_{{ $index }}_pregunta" class="form-label">{{ $pregunta['pregunta'] }}</label>
                        <input type="text" class="form-control" id="respuestas_{{ $index }}_pregunta" name="respuestas[{{ $index }}][pregunta]" required>

                        <label for="respuestas_{{ $index }}_puntuacion" class="form-label">Puntuación</label>
                        <input type="number" class="form-control" id="respuestas_{{ $index }}_puntuacion" name="respuestas[{{ $index }}][puntuacion]" min="0" required>
                    </div>
                @endforeach

                <button type="submit" class="btn btn-primary">Enviar Respuestas</button>
            </form>
        </div>
    </div>
@endsection
