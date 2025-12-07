<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Cargar Bootstrap y scripts compilados con Vite --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h1 class="display-4 mb-4">{{ config('app.name', 'Laravel') }}</h1>
                <p class="lead">Bienvenido a tu aplicación en Laravel con Bootstrap 4 y Vite.</p>
                <div class="mt-4">
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="btn btn-primary me-2">Iniciar Sesión</a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline-secondary">Registrarse</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>
