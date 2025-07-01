
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
    <style>
        /* Animaciones y efectos mejorados */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Base del contenedor del formulario */
        .form-container {
            animation: fadeIn 0.6s ease-out;
            backdrop-filter: blur(10px);
            transition: all 1.2s cubic-bezier(0.19, 1, 0.22, 1); /* Transición más lenta y suave */
            background: linear-gradient(135deg, 
                       rgba(30,41,59,0.65) 0%, 
                       rgba(17,24,39,0.75) 100%);
            border: 1px solid rgba(255,255,255,0.1);
        }
        
        /* Hover suave en el contenedor */
        .form-container:hover {
            background: linear-gradient(135deg, 
                       rgba(30,41,59,0.7) 0%, 
                       rgba(17,24,39,0.8) 100%); /* Diferencia sutil */
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            transform: scale(1.01); /* Escala más sutil */
        }
        
        /* Estado activo (cuando hay foco en inputs) - transición más suave */
        .form-container.form-focus-active {
            background: linear-gradient(135deg, 
                       rgba(28,39,55,0.7) 0%, 
                       rgba(15,23,42,0.75) 100%); /* Valores más cercanos al estado normal */
            border: 1px solid rgba(255,255,255,0.15);
            box-shadow: 0 8px 30px rgba(0,0,0,0.25);
        }
        
        /* Eliminamos el efecto ::before que causaba la transición brusca */
        .form-focus-effect::before {
            display: none; /* Desactivamos este efecto */
        }
        
        /* Estilos para inputs */
        .input-focus-effect {
            transition: all 0.4s cubic-bezier(0.19, 1, 0.22, 1);
            box-shadow: 0 0 0 rgba(255,169,45,0);
            background: rgba(30,41,59,0.5);
            border: 1px solid rgba(255,255,255,0.08);
        }
        
        /* Hover en inputs */
        .input-focus-effect:hover:not(:focus) {
            border: 1px solid rgba(255,169,45,0.2);
            background: rgba(30,41,59,0.55);
            box-shadow: 0 0 10px rgba(255,169,45,0.1);
        }
        
        /* Focus en inputs */
        .input-focus-effect:focus {
            box-shadow: 0 0 20px rgba(255,169,45,0.25);
            transform: scale(1.02);
            border: 1px solid rgba(255,169,45,0.3);
            background: rgba(30,41,59,0.6); /* Valor más cercano al estado normal */
        }
        
        /* Select específico */
        select.input-focus-effect:hover:not(:focus) {
            cursor: pointer;
            border: 1px solid rgba(255,169,45,0.2);
            box-shadow: 0 0 10px rgba(255,169,45,0.15), inset 0 0 30px rgba(255,169,45,0.02);
            background: rgba(30,41,59,0.55);
        }
        
        /* Animación suave para opciones del select */
        select.input-focus-effect option {
            background-color: rgba(15,23,42,0.9);
            color: white;
            transition: background-color 0.3s;
        }
        
        select.input-focus-effect option:hover {
            background-color: rgba(255,169,45,0.2);
        }
        
        .animated-gradient {
            background: linear-gradient(-45deg, #0f172a, #1e293b, #334155, #1e293b);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }
    </style>
</head>

<body class="flex flex-col h-screen bg-cover bg-center bg-no-repeat bg-fixed relative overflow-hidden"
      style="background-image: linear-gradient(rgba(15,23,42,0.5), rgba(15,23,42,0.6)), url('{{ asset('imagen/fondo.jpg') }}');">
    
    <!-- Partículas animadas de fondo mejoradas -->
    <div class="absolute inset-0 z-0 opacity-40">
        <div id="particles-js"></div>
    </div>
    
    <!-- Efecto de resplandor ambiental -->
    <div class="absolute inset-0 z-0">
        <div class="absolute top-[10%] left-[20%] w-64 h-64 bg-blue-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-[15%] right-[15%] w-96 h-96 bg-amber-500/10 rounded-full blur-3xl"></div>
    </div>

    <!-- Contenedor centrado -->
    <div class="h-screen flex items-center justify-center relative z-10">
        <div class="w-full h-full max-w-none flex items-center justify-center p-0">
            <!-- Contenedor del formulario con efecto de foco -->
            <div class="form-container form-focus-effect relative rounded-2xl p-10 shadow-2xl shadow-black/30">
                <!-- Contenido dinámico del formulario -->
                {{ $slot }}
            </div>
        </div>
        
        <!-- Logo en la esquina inferior derecha -->
        <img src="{{ asset('imagen/logo_iasd.png') }}" alt="Logo"
            class="absolute right-6 bottom-6 w-28 m-4 h-auto opacity-90 select-none pointer-events-none 
                   hover:opacity-100 transition-opacity duration-300" />
    </div>

    <!-- Scripts para animaciones -->
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configuración de partículas mejorada
            particlesJS('particles-js', {
                particles: {
                    number: { value: 80, density: { enable: true, value_area: 1200 } },
                    color: { value: "#ffffff" },
                    opacity: { value: 0.35, random: true, anim: { enable: true, speed: 0.5 } },
                    size: { value: 2.5, random: true, anim: { enable: true, speed: 1 } },
                    line_linked: { enable: true, distance: 150, color: "#ffffff", opacity: 0.2, width: 1 },
                    move: { 
                        enable: true, 
                        speed: 1, 
                        direction: "none", 
                        random: true, 
                        straight: false,
                        out_mode: "out",
                        bounce: false,
                        attract: { enable: true, rotateX: 600, rotateY: 1200 }
                    }
                },
                interactivity: {
                    detect_on: "canvas",
                    events: {
                        onhover: { enable: true, mode: "bubble" },
                        onclick: { enable: true, mode: "repulse" },
                        resize: true
                    },
                    modes: {
                        bubble: { distance: 150, size: 4, duration: 2, opacity: 0.5, speed: 3 },
                        repulse: { distance: 150, duration: 0.4 }
                    }
                },
                retina_detect: true
            });
            
            // Efecto de oscurecimiento modificado para transición más suave
            const formContainer = document.querySelector('.form-container');
            const inputs = document.querySelectorAll('input, select');
            
            // Variable para controlar las transiciones
            let focusTimeout;
            
            inputs.forEach(input => {
                input.addEventListener('focus', () => {
                    // Cancelar cualquier timeout pendiente
                    clearTimeout(focusTimeout);
                    
                    // Añadir la clase de manera progresiva
                    if (!formContainer.classList.contains('form-focus-active')) {
                        requestAnimationFrame(() => {
                            formContainer.classList.add('form-focus-active');
                        });
                    }
                });
                
                input.addEventListener('blur', () => {
                    // Solo quitar la clase si ningún input tiene focus
                    const anyFocused = Array.from(inputs).some(i => document.activeElement === i);
                    if (!anyFocused) {
                        // Retrasar la eliminación de la clase para una transición más suave
                        focusTimeout = setTimeout(() => {
                            formContainer.classList.remove('form-focus-active');
                        }, 150);
                    }
                });
            });
            
            // Asegurarse de que los elementos select tengan la clase input-focus-effect
            document.querySelectorAll('select').forEach(select => {
                if (!select.classList.contains('input-focus-effect')) {
                    select.classList.add('input-focus-effect');
                }
            });
        });
    </script>
</body>
</html>