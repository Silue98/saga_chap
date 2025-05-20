<?php

namespace App\Filament\Resources\BetailResource\Pages;

use App\Filament\Resources\BetailResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBetail extends EditRecord
{
    protected static string $resource = BetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
