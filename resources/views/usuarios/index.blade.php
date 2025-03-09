@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4 text-center text-primary">{{ $tipo == 'alumno' ? 'Listado de Alumnos' : 'Listado de Profesores' }}</h1>

        <!-- Formulario de Búsqueda y Orden -->
        <form action="{{ url()->current() }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Buscar por nombre" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
                    </div>
                </div>
                <div class="col-md-4 text-md-right mt-3 mt-md-0">
                    <!-- Enlaces para ordenar -->
                    <a href="{{ url()->current() . '?order=name&direction=asc' }}" class="btn btn-outline-secondary btn-sm mx-1"><i class="fas fa-sort-alpha-up"></i> Ascendente</a>
                    <a href="{{ url()->current() . '?order=name&direction=desc' }}" class="btn btn-outline-secondary btn-sm mx-1"><i class="fas fa-sort-alpha-down"></i> Descendente</a>
                </div>
            </div>
        </form>

        <!-- Tabla de Usuarios -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="thead-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th class="text-center">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->name }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td class="text-center">
                            <!-- Botón Ver -->
                            <a href="#" class="btn btn-info btn-sm mx-1" data-toggle="tooltip" data-placement="top" title="Ver"><i class="fas fa-eye"></i></a>

                            <!-- Botón Editar -->
                            <a href="#" class="btn btn-warning btn-sm mx-1" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>

                            <!-- Botón Eliminar -->
                            <form action="#" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm mx-1" onclick="return confirm('¿Seguro que quieres eliminar a {{ $usuario->name }}?')" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts necesarios para los tooltips -->
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    @endpush
@endsection
