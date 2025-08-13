<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        
        <div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0" style="background-image: url('{{ asset('imagenes/lab-background.jpg') }}'); background-size: cover; background-position: center;">
            
            <div class="absolute inset-0 bg-black opacity-60"></div>

            {{--
                INICIO DE LA MODIFICACIÓN
                Hemos eliminado el div que contenía el logo.
            --}}

            {{-- Contenedor del formulario ($slot) --}}
            {{-- Le añadimos un poco de padding superior para compensar el espacio del logo --}}
            <div class="relative z-10 w-full sm:max-w-md mt-6 pt-6">
                {{ $slot }}
            </div>

        </div>
    </body>
</html>