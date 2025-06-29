<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>

    <body class="flex flex-col h-screen bg-cover bg-center bg-no-repeat bg-fixed"
          style="background-image: url('{{ asset('imagen/fondo.jpg') }}');">

        <!-- Contenedor centrado -->
        <div class="h-screen flex items-center justify-center">
            <div class="w-full max-w-md p-8 rounded-3xl shadow-2xl text-white text-center"
                style="background: rgba(32,47,54,0.85);">
                <!-- Contenido dinámico del formulario -->
                        {{ $slot }}
            </div>

        </div>

        <!-- Footer -->
        <footer class="text-center text-white text-lg py-4 relative -top-4">
            © {{ date('Y') }} Universidad Peruana Unión - Gestión de Convenios
        </footer>


    </body>
</html>