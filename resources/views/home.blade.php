@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <p>{{ __('You are logged in!') }}</p>

                        <div class="d-flex justify-content-center mt-3">
                            <a href="{{ url('/rubricas/create') }}" class="btn btn-primary">Ir al Formulario de Rúbrica</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
