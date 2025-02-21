@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Crear Clase</h1>

        <form action="{{ route('clases.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="nombre" class="form-label">Nombre de la Clase:</label>
                <input type="text" name="nombre" class="form-control" id="nombre" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success btn-lg">Crear Clase</button>
            </div>
        </form>
    </div>
@endsection
