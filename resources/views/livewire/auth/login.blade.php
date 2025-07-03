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

<div class="w-full max-w-md mx-auto flex flex-col items-center justify-center h-screen" style="margin-top: -74px;">
    <div class="mb-5">
        <img src="/imagen/logo-upu-blanco.png" alt="Logo UPeU" class="mx-auto w-37.5">
    </div>

    <!-- Mensaje -->
    <p class="text-sm mb-4 text-white text-center">Por favor, identifíquese</p>

    <!-- Alerta de error -->
    @if ($errors->any())
        <div class="bg-red-100 bg-opacity-80 border border-red-400 text-red-700 px-4 py-3 rounded relative text-sm text-center">
            <strong>Error:</strong> Verifique sus credenciales e intente nuevamente.
        </div>
    @endif

    <!-- Formulario centrado -->
    <form wire:submit.prevent="login" class="space-y-3 w-full mt-0 flex flex-col items-center">
        <!-- Correo electrónico -->
        <input type="email" name="email" wire:model="email" placeholder="Usuario"
            class="w-[55.8%] mx-auto h-10 px-3 py-2 rounded-[20px] text-center text-white bg-[rgba(157,157,157,0.32)] placeholder-gray-200 focus:outline-none font-normal text-[14px] leading-4 transition cursor-text box-border"
            style="background-clip: padding-box;" />

        @error('email')
            <p class="text-red-400 text-xs mt-1 text-center">{{ $message }}</p>
        @enderror

        <!-- Contraseña -->
        <input type="password" name="password" wire:model="password" placeholder="Contraseña"
            class="w-[55.8%] mx-auto h-10 mt-1 px-3 py-2 rounded-[20px] text-center text-white bg-[rgba(157,157,157,0.32)] placeholder-gray-200 focus:outline-none font-normal text-[14px] leading-4 transition cursor-text box-border"
            style="background-clip: padding-box;" />

        @error('password')
            <p class="text-red-400 text-xs mt-1 text-center">{{ $message }}</p>
        @enderror

        <!-- Botón principal -->
        <button type="submit"
            class="w-[55.8%] mx-auto h-10 mt-1 py-2 rounded-full bg-[#ffa92d;] hover:bg-[#ff922d] text-black font-normal text-base transition"
            style="font-size: 0.9rem;">
            Iniciar sesión
        </button>
    </form>

    <!-- Enlace de recuperación -->
    <a href="#" class="text-xs text-white hover:text-[#ff922d] block mt-6 text-center">
        Recuperar contraseña
    </a>
</div>

<script>
    window.addEventListener('refreshPage', () => {
        window.location.reload();
    });
</script>
