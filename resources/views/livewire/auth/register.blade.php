<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirectIntended(route('home'), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">

    <div style="text-align:center;margin-bottom:8px;">
        <h2 style="font-size:1.5rem;font-weight:700;color:#111827;margin:0 0 6px;">Créer un compte</h2>
        <p style="font-size:0.9rem;color:#6b7280;margin:0;">Rejoignez SagaChap et achetez votre bétail en ligne</p>
    </div>

    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-5">

        <flux:input
            wire:model="name"
            label="Nom complet"
            type="text"
            required
            autofocus
            autocomplete="name"
            placeholder="Votre nom complet"
        />

        <flux:input
            wire:model="email"
            label="Adresse email"
            type="email"
            required
            autocomplete="email"
            placeholder="votre@email.com"
        />

        <flux:input
            wire:model="password"
            label="Mot de passe"
            type="password"
            required
            autocomplete="new-password"
            placeholder="Minimum 8 caractères"
        />

        <flux:input
            wire:model="password_confirmation"
            label="Confirmer le mot de passe"
            type="password"
            required
            autocomplete="new-password"
            placeholder="Répétez le mot de passe"
        />

        <flux:button type="submit" variant="primary" class="w-full" style="background:#16a34a;margin-top:4px;">
            Créer mon compte
        </flux:button>

    </form>

    <div style="text-align:center;font-size:0.875rem;color:#6b7280;">
        Déjà inscrit ?
        <flux:link :href="route('login')" wire:navigate style="color:#16a34a;font-weight:600;">
            Se connecter
        </flux:link>
    </div>

</div>
