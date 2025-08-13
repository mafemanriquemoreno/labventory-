<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LabVentory</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Estilos personalizados para esta página --}}
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="antialiased">
    {{-- CONTENEDOR PRINCIPAL --}}
    {{-- Ocupa toda la pantalla y tiene la imagen de fondo --}}
    <div class="relative min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white" style="background-image: url('{{ asset('imagenes/lab-background.jpg') }}'); background-size: cover; background-position: center;">

        {{-- Capa oscura semitransparente sobre el fondo --}}
        <div class="absolute inset-0 bg-black opacity-60"></div>

        {{-- Contenedor del contenido, centrado vertical y horizontalmente --}}
        <div class="relative min-h-screen flex flex-col items-center justify-center text-center text-white p-6">

            {{-- TARJETA DE CONTENIDO --}}
            {{-- Usamos un fondo oscuro translúcido para el efecto de "vidrio" --}}
            <div class="bg-gray-900 bg-opacity-70 backdrop-blur-sm p-8 sm:p-12 rounded-2xl shadow-2xl max-w-2xl">
                
                {{-- Título principal --}}
                <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight">
                    LabVentory
                </h1>

                {{-- Subtítulo o descripción --}}
                <p class="mt-4 text-lg text-gray-300">
                    App web para optimizar el control de inventario y registro en laboratorios clínicos.
                </p>

                {{-- Contenedor de los botones de acción --}}
                <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('login') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-cyan-600 hover:bg-cyan-700 transition-transform transform hover:scale-105">
                        Iniciar Sesión
                    </a>
                    <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-gray-400 text-base font-medium rounded-md text-white hover:bg-gray-700 transition-transform transform hover:scale-105">
                        Registrarse
                    </a>
                </div>
            </div>

            {{-- Icono de flecha para indicar que hay más contenido (opcional) --}}
            <div class="absolute bottom-10">
                <svg class="w-8 h-8 text-white animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </div>
        </div>
    </div>
</body>
</html>