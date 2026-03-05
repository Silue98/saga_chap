<?php

namespace App\Filament\Widgets;

use App\Models\Betail;
use App\Models\Commande;
use App\Models\User;
use App\Models\Cart;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalRevenu = Commande::whereIn('statut', ['confirmee', 'livree'])->sum('montant_total');
        $commandesMois = Commande::whereMonth('created_at', now()->month)
                                  ->whereYear('created_at', now()->year)
                                  ->count();
        $paniersActifs = Cart::distinct('session_id')->count('session_id');

        return [
            Stat::make('Bétails en vente', Betail::where('disponibilite', true)->count())
                ->description(Betail::count() . ' bétails au total')
                ->icon('heroicon-o-squares-2x2')
                ->color('success'),

            Stat::make('Commandes totales', Commande::count())
                ->description($commandesMois . ' ce mois-ci')
                ->icon('heroicon-o-shopping-cart')
                ->color('primary'),

            Stat::make('Commandes en attente', Commande::where('statut', 'en_attente')->count())
                ->description('À traiter')
                ->icon('heroicon-o-clock')
                ->color('warning'),

            Stat::make('Revenu confirmé', number_format($totalRevenu, 0, ',', ' ') . ' FCFA')
                ->description('Commandes confirmées + livrées')
                ->icon('heroicon-o-banknotes')
                ->color('success'),

            Stat::make('Clients inscrits', User::where('is_admin', false)->count())
                ->description(User::whereMonth('created_at', now()->month)->count() . ' ce mois-ci')
                ->icon('heroicon-o-users')
                ->color('info'),

            Stat::make('Paniers actifs', $paniersActifs)
                ->description('Sessions avec articles')
                ->icon('heroicon-o-shopping-bag')
                ->color('gray'),
        ];
    }
}
