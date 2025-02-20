@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Lista de Rúbricas</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('rubricas.create') }}" class="btn btn-primary mb-3">Crear Nueva Rúbrica</a>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Código</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($rubricas as $rubrica)
                <tr>
                    <td>{{ $rubrica->id }}</td>
                    <td>{{ $rubrica->codigo }}</td>
                    <td>{{ $rubrica->titulo }}</td>
                    <td>{{ Str::limit($rubrica->descripcion, 50) }}</td>
                    <td>
                        <a href="{{ route('rubricas.show', $rubrica) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('rubricas.edit', $rubrica) }}" class="btn btn-warning btn-sm">Editar</a>

                        <form action="{{ route('rubricas.destroy', $rubrica) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
