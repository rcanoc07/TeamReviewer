@extends('layouts.app')

@section('content')
    <h1 class="text-center mb-4">Mis Clases</h1>

    <div class="text-center mb-4">
        <a href="{{ route('clases.create') }}" class="btn btn-primary btn-lg">Crear nueva clase</a>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($clases as $clase)
            <div class="col">
                <div class="card shadow-sm border-light h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $clase->nombre }}</h5>
                        <p class="card-text">{{ Str::limit($clase->descripcion, 100) }}</p>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('clases.show', $clase) }}" class="btn btn-info">Ver detalles</a>
                            <form action="{{ route('clases.destroy', $clase) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
