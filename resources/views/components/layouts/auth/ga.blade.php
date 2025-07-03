<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>

    <body class="flex flex-col h-screen bg-cover bg-center bg-no-repeat bg-fixed"
          style="background-image: url('{{ asset('imagen/fondo.jpg') }}');">

        <!-- Contenedor centrado -->
        <div class="h-screen flex items-center justify-center relative">
            <div class="w-full h-full max-w-none flex items-center justify-center p-0">

                <!-- Contenido dinámico del formulario -->
                {{ $slot }}
            </div>
            <!-- Logo IASD en la esquina inferior derecha -->
            <img src="{{ asset('imagen/logo_iasd.png') }}" alt="Logo IASD"
                class="absolute right-6 bottom-6 w-28 m-4 h-auto opacity-90 select-none pointer-events-none" />
        </div>
    </body>
</html>
