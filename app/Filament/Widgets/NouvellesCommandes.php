<?php

namespace App\Filament\Widgets;

use App\Models\Commande;
use Filament\Notifications\Notification;
use Filament\Widgets\Widget;
use Livewire\Attributes\On;

class NouvellesCommandes extends Widget
{
    protected static ?int $sort = 0;
    protected static bool $isLazy = false;
    protected int | string | array $columnSpan = 'full';
    protected static string $view = 'filament.widgets.nouvelles-commandes';

    public int $nbEnAttente = 0;

    public function mount(): void
    {
        $this->nbEnAttente = Commande::where('statut', 'en_attente')->count();
    }

    #[On('echo:commandes,NouvelleCommande')]
    public function refresh(): void
    {
        $this->nbEnAttente = Commande::where('statut', 'en_attente')->count();
    }
}
