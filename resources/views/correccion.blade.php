<?php
@extends('layouts.app')

@section('title', 'Corrección de Rúbrica')

@section('content')
    <div class="card">
        <div class="card-header">Corrección de Rúbrica</div>
        <div class="card-body">
            <h5>Puntuación: {{ $correccion->puntuacion }}</h5>
            <h5>Comentarios:</h5>
            <p>{{ $correccion->comentarios }}</p>
            <h5>Detalles de la corrección:</h5>
            <pre>{{ json_encode(json_decode($correccion->detalles_correccion), JSON_PRETTY_PRINT) }}</pre>
        </div>
    </div>
@endsection
