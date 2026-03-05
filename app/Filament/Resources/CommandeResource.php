<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommandeResource\Pages;
use App\Models\Commande;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class CommandeResource extends Resource
{
    protected static ?string $model          = Commande::class;
    protected static ?string $navigationIcon  = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Commandes';
    protected static ?int    $navigationSort  = 3;

    public static function getNavigationBadge(): ?string
    {
        $count = \App\Models\Commande::where('statut', 'en_attente')->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informations client')->schema([
                Forms\Components\TextInput::make('nom')->label('Nom')->disabled(),
                Forms\Components\TextInput::make('prenom')->label('Prénom')->disabled(),
                Forms\Components\TextInput::make('telephone')->label('Téléphone')->disabled(),
                Forms\Components\TextInput::make('adresse')->label('Adresse')->disabled(),
                Forms\Components\TextInput::make('ville')->label('Ville')->disabled(),
            ])->columns(2),

            Forms\Components\Section::make('Statut de la commande')->schema([
                Forms\Components\Select::make('statut')
                    ->label('Statut')
                    ->options([
                        'en_attente' => 'En attente',
                        'confirmee'  => 'Confirmée',
                        'livree'     => 'Livrée',
                        'annulee'    => 'Annulée',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('montant_total')
                    ->label('Total (FCFA)')
                    ->disabled(),
            ])->columns(2),
        ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make('Informations client')->schema([
                Infolists\Components\TextEntry::make('nom')->label('Nom'),
                Infolists\Components\TextEntry::make('prenom')->label('Prénom'),
                Infolists\Components\TextEntry::make('telephone')->label('Téléphone'),
                Infolists\Components\TextEntry::make('adresse')->label('Adresse'),
                Infolists\Components\TextEntry::make('ville')->label('Ville'),
            ])->columns(2),

            Infolists\Components\Section::make('Commande')->schema([
                Infolists\Components\TextEntry::make('statut')
                    ->label('Statut')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'en_attente' => 'warning',
                        'confirmee'  => 'success',
                        'livree'     => 'primary',
                        'annulee'    => 'danger',
                        default      => 'gray',
                    }),
                Infolists\Components\TextEntry::make('montant_total')
                    ->label('Total')
                    ->formatStateUsing(fn ($state) => number_format($state, 0, ',', ' ') . ' FCFA'),
                Infolists\Components\TextEntry::make('created_at')
                    ->label('Date')
                    ->dateTime('d/m/Y H:i'),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('#')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nom')
                    ->label('Client')
                    ->formatStateUsing(fn ($record) => $record->prenom . ' ' . $record->nom)
                    ->searchable(['nom', 'prenom']),
                Tables\Columns\TextColumn::make('telephone')
                    ->label('Téléphone'),
                Tables\Columns\TextColumn::make('ville')
                    ->label('Ville'),
                Tables\Columns\TextColumn::make('montant_total')
                    ->label('Total (FCFA)')
                    ->formatStateUsing(fn ($state) => number_format($state, 0, ',', ' ') . ' FCFA')
                    ->sortable(),
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
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('statut')
                    ->options([
                        'en_attente' => 'En attente',
                        'confirmee'  => 'Confirmée',
                        'livree'     => 'Livrée',
                        'annulee'    => 'Annulée',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCommandes::route('/'),
            'view'   => Pages\ViewCommande::route('/{record}'),
            'edit'   => Pages\EditCommande::route('/{record}/edit'),
        ];
    }
}
