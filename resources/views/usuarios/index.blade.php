@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Listado de {{ $tipo == 'alumno' ? 'Alumnos' : 'Profesores' }}</h1>

        <table class="table table-striped table-hover">
            <thead class="table-dark">
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>
                        <!-- Botón Ver -->
                        <a href="#" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>

                        <!-- Botón Editar -->
                        <a href="#" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>

                        <!-- Botón Eliminar -->
                        <form action="#" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que quieres eliminar a {{ $usuario->name }}?')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
