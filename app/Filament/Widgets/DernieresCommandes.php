<?php

namespace App\Filament\Widgets;

use App\Models\Commande;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class DernieresCommandes extends BaseWidget
{
    protected static ?string $heading = 'Dernières commandes';
    protected static ?int    $sort    = 5;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(Commande::latest()->limit(8))
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('#')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nom')
                    ->label('Client')
                    ->formatStateUsing(fn ($record) => $record->prenom . ' ' . $record->nom),
                Tables\Columns\TextColumn::make('telephone')
                    ->label('Téléphone'),
                Tables\Columns\TextColumn::make('ville')
                    ->label('Ville'),
                Tables\Columns\TextColumn::make('montant_total')
                    ->label('Total')
                    ->formatStateUsing(fn ($state) => number_format($state, 0, ',', ' ') . ' FCFA'),
                Tables\Columns\TextColumn::make('statut')
                    ->label('Statut')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'en_attente' => 'warning',
                        'confirmee'  => 'success',
                        'livree'     => 'primary',
                        'annulee'    => 'danger',
                        default      => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('voir')
                    ->label('Gérer')
                    ->icon('heroicon-o-pencil')
                    ->url(fn (Commande $record) => route('filament.admin.resources.commandes.edit', $record)),
            ]);
    }
}
