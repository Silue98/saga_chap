<?php

namespace App\Filament\Widgets;

use App\Models\Commande;
use Filament\Widgets\ChartWidget;

class StatutCommandesChart extends ChartWidget
{
    protected static ?string $heading = 'Répartition des statuts';
    protected static ?int    $sort    = 4;
    protected int | string | array $columnSpan = 1;
    protected static ?string $maxHeight = '220px';

    protected function getData(): array
    {
        $enAttente = Commande::where('statut', 'en_attente')->count();
        $confirmee = Commande::where('statut', 'confirmee')->count();
        $livree    = Commande::where('statut', 'livree')->count();
        $annulee   = Commande::where('statut', 'annulee')->count();

        return [
            'datasets' => [[
                'data'            => [$enAttente, $confirmee, $livree, $annulee],
                'backgroundColor' => [
                    '#FBBF24',
                    '#22C55E',
                    '#3B82F6',
                    '#EF4444',
                ],
                'borderWidth' => 2,
                'hoverOffset' => 6,
            ]],
            'labels' => [
                "En attente ($enAttente)",
                "Confirmées ($confirmee)",
                "Livrées ($livree)",
                "Annulées ($annulee)",
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels'   => ['boxWidth' => 12, 'padding' => 10],
                ],
            ],
            'maintainAspectRatio' => false,
            'cutout' => '65%',
        ];
    }
}
