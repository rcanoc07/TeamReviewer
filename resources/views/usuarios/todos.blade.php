{{--
    Documentacion blade (@):
    https://laravel.com/docs/9.x/blade

    Usamos como base la plantilla resources/views/layouts/app.blade.php
    Queda ver el botón de acceso a esta página en la cabecera en ese fichero (Usuarios)
--}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ "Lista de Usuarios" }}

                    <form action="{{ route('usuariostodos') }}">
                        <input type="text" name="busqueda">
                        <input type="submit" value="Buscar">
                    </form>
                        @if($busq)
                    Buscamos por la cadena: {{ $busq }}
                        @endif
                    </div>

                    <div class="card-body">
{{-- Hasta aquí esta cogido de app.blade.php --}}

                        {{--
                        PONLO TÚ BONITO CON Bootstrap
                        https://getbootstrap.com/docs/5.2/getting-started/introduction/
                        --}}
                        <ol class="list-group list-group-numbered">

                            @foreach ($usuarios as $usuario)
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">
                                            {{ $usuario->name }}
                                        </div>
                                        {{ $usuario->email }}
                                    </div>

                                    <div>


                                       <span class="badge bg-primary rounded-pill">
                                            @if( $usuario->getRoleNames()->count() > 0)
                                            {{ $usuario->getRoleNames()[0] }}
                                            @endif
                                        </span>
                                        <a class="material-icons" href="{{ route("cambiarrol", $usuario->id) }}">
                                            manage_accounts
                                        </a>

                                        <a href="{{ route("borrarusu", $usuario->id) }}" type="button" class="btn btn-sm btn-danger">Borrar</a>
                                    </div>
                                </li>

                            @endforeach
                        </ol>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
