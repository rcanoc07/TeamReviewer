<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TeamReviewer</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
@if (Auth::check())
    <script>window.location.href = "{{ url('/home') }}";</script>
@else
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="text-center">
            <h1 class="mb-4">Bienvenido a TeamReviewer</h1>
            <p class="mb-4">Por favor, elige una opción para continuar.</p>

            @if (Route::has('login'))
                <a href="{{ route('login') }}" class="btn btn-outline-primary">Iniciar Sesión</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-outline-primary">Registrarse</a>
                @endif
            @endif
        </div>
    </div>
@endif
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
