<?php

namespace App\Filament\Resources\BetailResource\Pages;

use App\Filament\Resources\BetailResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBetails extends ListRecords
{
    protected static string $resource = BetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
