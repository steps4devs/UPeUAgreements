<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);

        // Forzar refresh de página después del login exitoso
        $this->dispatch('refreshPage');
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}; ?>

<div class="w-full max-w-md mx-auto flex flex-col items-center justify-center" style="margin-top: -20px;">
    <div class="mb-5 transform hover:scale-105 transition-transform duration-300">
        <img src="/imagen/logo-upu-blanco.png" alt="Logo UPeU" class="mx-auto w-40 drop-shadow-lg">
    </div>

    <!-- Mensaje con animación de typing -->
    <p class="text-lg mb-6 text-white text-center font-light tracking-wide">
        <span class="typing-text">Por favor, identifíquese</span>
    </p>

    <!-- Alerta de error mejorada -->
    @if ($errors->any())
        <div class="bg-red-500 bg-opacity-20 backdrop-blur-sm border border-red-400 text-white px-5 py-3 rounded-lg relative text-sm mb-6 w-full max-w-xs animate-pulse">
            <strong class="block mb-1">¡Error!</strong> Verifique sus credenciales e intente nuevamente.
        </div>
    @endif

    <!-- Formulario centrado con efecto de glassmorphism -->
    <form wire:submit.prevent="login" class="space-y-5 w-full flex flex-col items-center px-12 py-10 rounded-xl">
        <!-- Campo de correo electrónico -->
        <div class="w-full relative group">
            <input type="email" name="email" wire:model="email" placeholder="Usuario"
                class="w-full h-12 px-5 py-2 rounded-full text-center text-white bg-[rgba(30,30,30,0.5)] 
                       placeholder-gray-300 focus:outline-none font-normal text-base leading-5
                       transition-all duration-300 border border-gray-600 focus:border-amber-400
                       input-focus-effect" />
            
            <div class="absolute inset-0 bg-gradient-to-r from-amber-500 to-amber-300 rounded-full opacity-0 
                        group-hover:opacity-10 -z-10 transition-opacity duration-300"></div>
                        
            @error('email')
                <p class="text-red-300 text-xs mt-2 text-center animate-pulse">{{ $message }}</p>
            @enderror
        </div>

        <!-- Campo de contraseña -->
        <div class="w-full relative group">
            <input type="password" name="password" wire:model="password" placeholder="Contraseña"
                class="w-full h-12 px-5 py-2 rounded-full text-center text-white bg-[rgba(30,30,30,0.5)] 
                       placeholder-gray-300 focus:outline-none font-normal text-base leading-5
                       transition-all duration-300 border border-gray-600 focus:border-amber-400
                       input-focus-effect" />
                       

            <div class="absolute inset-0 bg-gradient-to-r from-amber-500 to-amber-300 rounded-full opacity-0 
                        group-hover:opacity-10 -z-10 transition-opacity duration-300"></div>
                        
            @error('password')
                <p class="text-red-300 text-xs mt-2 text-center animate-pulse">{{ $message }}</p>
            @enderror
        </div>

        <!-- Botón principal con efecto de hover -->
        <button type="submit"
            class="w-full h-12 mt-4 py-2 rounded-full bg-gradient-to-r from-amber-500 to-amber-400
                   hover:from-amber-400 hover:to-amber-500 text-black font-medium text-base
                   transition-all duration-300 transform hover:scale-105 hover:shadow-lg
                   hover:shadow-amber-500/20 focus:outline-none focus:ring-2 focus:ring-amber-300">
            <span class="relative z-10">Iniciar sesión</span>
        </button>
    </form>

    <!-- Enlace de recuperación -->
    <a href="#" class="text-sm text-gray-300 hover:text-amber-400 block mt-6 text-center transition-colors duration-300">
        ¿Olvidó su contraseña?
    </a>
</div>

<script>
    window.addEventListener('refreshPage', () => {
        window.location.reload();
    });
    
    // Efecto de typing para el mensaje de bienvenida
    document.addEventListener('DOMContentLoaded', function() {
        const text = "Por favor, identifíquese";
        const typingElement = document.querySelector('.typing-text');
        
        if (typingElement) {
            typingElement.textContent = '';
            let i = 0;
            
            const typeWriter = () => {
                if (i < text.length) {
                    typingElement.textContent += text.charAt(i);
                    i++;
                    setTimeout(typeWriter, 80);
                }
            };
            
            setTimeout(typeWriter, 500);
        }
    });
</script>