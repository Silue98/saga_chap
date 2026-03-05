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

    public function login(): void
    {
        $this->validate();
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'email' => 'Email ou mot de passe incorrect.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('home'), navigate: true);
    }

    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) return;

        event(new Lockout(request()));
        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => 'Trop de tentatives. Réessayez dans ' . ceil($seconds / 60) . ' minute(s).',
        ]);
    }

    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }
}; ?>

<div class="flex flex-col gap-6">

    <div style="text-align:center;margin-bottom:8px;">
        <h2 style="font-size:1.5rem;font-weight:700;color:#111827;margin:0 0 6px;">Bon retour ! 👋</h2>
        <p style="font-size:0.9rem;color:#6b7280;margin:0;">Connectez-vous à votre compte SagaChap</p>
    </div>

    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col gap-5">

        <flux:input
            wire:model="email"
            label="Adresse email"
            type="email"
            required
            autofocus
            autocomplete="email"
            placeholder="votre@email.com"
        />

        <div style="position:relative;">
            <flux:input
                wire:model="password"
                label="Mot de passe"
                type="password"
                required
                autocomplete="current-password"
                placeholder="Votre mot de passe"
            />
            @if (Route::has('password.request'))
                <div style="position:absolute;top:0;right:0;">
                    <flux:link :href="route('password.request')" wire:navigate style="font-size:0.8rem;color:#16a34a;">
                        Mot de passe oublié ?
                    </flux:link>
                </div>
            @endif
        </div>

        <flux:checkbox wire:model="remember" label="Se souvenir de moi" />

        <flux:button variant="primary" type="submit" class="w-full" style="background:#16a34a;">
            Se connecter
        </flux:button>

    </form>

    @if (Route::has('register'))
        <div style="text-align:center;font-size:0.875rem;color:#6b7280;">
            Pas encore de compte ?
            <flux:link :href="route('register')" wire:navigate style="color:#16a34a;font-weight:600;">
                Créer un compte gratuit
            </flux:link>
        </div>
    @endif

</div>
