<?php

namespace App\Filament\Widgets;

use App\Models\Commande;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class RevenusChart extends ChartWidget
{
    protected static ?string $heading  = 'Revenus — 6 derniers mois (FCFA)';
    protected static ?int    $sort     = 3;
    protected int | string | array $columnSpan = 2;
    protected static ?string $maxHeight = '200px';

    protected function getData(): array
    {
        $data = $labels = [];
        for ($i = 5; $i >= 0; $i--) {
            $date     = Carbon::now()->subMonths($i);
            $labels[] = $date->format('M y');
            $data[]   = (float) Commande::whereIn('statut', ['confirmee', 'livree'])
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('montant_total');
        }
        return [
            'datasets' => [[
                'label'           => 'Revenus',
                'data'            => $data,
                'backgroundColor' => ['#22C55E','#3B82F6','#FBBF24','#EF4444','#A855F7','#14B8A6'],
                'borderRadius'    => 6,
                'borderWidth'     => 0,
            ]],
            'labels' => $labels,
        ];
    }

    protected function getType(): string { return 'bar'; }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => ['beginAtZero' => true],
            ],
            'plugins' => ['legend' => ['display' => false]],
            'maintainAspectRatio' => false,
        ];
    }
}
