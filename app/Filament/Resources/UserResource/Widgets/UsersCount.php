<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UsersCount extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Utilisateurs', User::count())
                ->description('Nombre total d\'utilisateurs')
                ->icon('heroicon-o-users')
                ->color('success'),
        ];
    }
}
