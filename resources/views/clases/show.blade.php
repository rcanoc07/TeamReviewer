@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">{{ $clase->nombre }}</h1>

        <!-- Tabs de Bootstrap -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="rubricas-tab" data-bs-toggle="tab" href="#rubricas" role="tab" aria-controls="rubricas" aria-selected="true">Rúbricas</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="integrantes-tab" data-bs-toggle="tab" href="#integrantes" role="tab" aria-controls="integrantes" aria-selected="false">Integrantes</a>
            </li>
        </ul>

        <div class="tab-content mt-3" id="myTabContent">
            <!-- Pestaña de Rúbricas -->
            <div class="tab-pane fade show active" id="rubricas" role="tabpanel" aria-labelledby="rubricas-tab">
                <h2 class="mb-3">Rúbricas disponibles:</h2>

                <!-- Botón para añadir rúbrica -->
                @if(auth()->user()->hasRole('profesor'))
                    <div class="mb-4 text-end">
                        <!-- Botón para añadir rubrica -->
                        <a href="{{ route('rubricas.create', $clase) }}" class="btn btn-primary">Añadir Rubrica</a>
                    </div>
                @endif

                <ul class="list-group mb-4">
                    @foreach($rubricas as $rubrica)
                        <li class="list-group-item">{{ $rubrica->titulo }}</li>
                    @endforeach
                </ul>
            </div>

            <!-- Pestaña de Integrantes -->
            <div class="tab-pane fade" id="integrantes" role="tabpanel" aria-labelledby="integrantes-tab">
                <h2 class="mb-3">Alumnos inscritos:</h2>
                <ul class="list-group mb-4">
                    @foreach($alumnos as $alumno)
                        <li class="list-group-item">{{ $alumno->name }}</li>
                    @endforeach
                </ul>

                @if(auth()->user()->hasRole('alumno'))
                    <div class="text-center">
                        <form action="{{ route('clases.join', $clase) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-lg">Unirme a la clase</button>
                        </form>
                    </div>
                @elseif(auth()->user()->hasRole('profesor'))
                    <!-- No mostrar nada si el usuario es profesor -->
                @endif

            </div>
        </div>
    </div>
@endsection
