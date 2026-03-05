<?php

namespace App\Filament\Widgets;

use App\Models\Commande;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class CommandesChart extends ChartWidget
{
    protected static ?string $heading  = 'Commandes — 30 derniers jours';
    protected static ?int    $sort     = 2;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $maxHeight = '200px';

    protected function getData(): array
    {
        $data = $labels = [];
        for ($i = 29; $i >= 0; $i--) {
            $date     = Carbon::now()->subDays($i);
            $labels[] = $date->format('d/m');
            $data[]   = Commande::whereDate('created_at', $date)->count();
        }
        return [
            'datasets' => [[
                'label'           => 'Commandes',
                'data'            => $data,
                'backgroundColor' => 'rgba(34,197,94,0.15)',
                'borderColor'     => '#22C55E',
                'borderWidth'     => 2,
                'fill'            => true,
                'tension'         => 0.4,
                'pointRadius'     => 3,
            ]],
            'labels' => $labels,
        ];
    }

    protected function getType(): string { return 'line'; }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => ['beginAtZero' => true, 'ticks' => ['stepSize' => 1]],
                'x' => ['ticks' => ['maxTicksLimit' => 10]],
            ],
            'plugins' => ['legend' => ['display' => false]],
            'maintainAspectRatio' => false,
        ];
    }
}
