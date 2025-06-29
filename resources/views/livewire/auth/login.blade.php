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

<div class="space-y-4">
    <div class="mb-2">
        <img src="/imagen/logo-upu-blanco.png" alt="Logo UPeU" class="mx-auto w-32">
        <h1 class="fw-bold mt-4 text-3xl" style="color:#e6eaee;">Gestión de Convenios</h1>
    </div>

    <!-- Mensaje -->
    <p class="text-lg mb-4">Por favor, identifíquese</p>

    <!-- Alerta de error -->
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative text-sm">
            <strong>Error:</strong> Verifique sus credenciales e intente nuevamente.
        </div>
    @endif

    <!-- Formulario -->
    <form wire:submit.prevent="login" class="space-y-4">
        <!-- Correo electrónico -->
        <input type="email" name="email" wire:model="email" placeholder="Correo electrónico"
            class="w-full px-6 py-3 rounded-full bg-white bg-opacity-100 text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-yellow-400 font-semibold" />

        @error('email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror

        <!-- Contraseña -->
        <input type="password" name="password" wire:model="password" placeholder="Contraseña"
            class="w-full px-6 py-3 rounded-full bg-white bg-opacity-100 text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-yellow-400 font-semibold" />

        @error('password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror

        <!-- Botón principal -->
        <button type="submit"
            class="w-full py-3 rounded-full bg-yellow-400 hover:bg-yellow-300 text-black font-semibold text-lg transition">
            Iniciar sesión
        </button>
    </form>

    <!-- Enlace de recuperación -->
    <a href="#" class="text-sm underline text-white hover:text-yellow-300 block mt-2">Recuperar contraseña</a>
</div>

<script>
    window.addEventListener('refreshPage', () => {
        window.location.reload();
    });
</script>







