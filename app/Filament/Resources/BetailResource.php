<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BetailResource\Pages;
use App\Filament\Resources\BetailResource\RelationManagers;
use App\Models\Betail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;


class BetailResource extends Resource
{
    protected static ?string $model = Betail::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('id_categorie_betail')
                    // -label('Catégories')
                    ->options(
                        \App\Models\Categorie::all()->pluck('nom_categorie', 'id_categorie')
                    )
                    ->required()
                    ->searchable(),
                TextInput::make('race')
                     ->label('Race')
                     ->required()
                     ->maxLength(100),
                TextInput::make('age')
                    ->label('Âge')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->default(0),
                TextInput::make('poids')
                    ->label('Poids (kg)')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(1000)
                    ->default(0),
                TextInput::make('prix')
                    ->label('Prix (FCFA)')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->default(0),
                Forms\Components\FileUpload::make('photo')
                    ->label('Photo')
                    ->image()
                    ->required()
                    ->disk('public')
                    ->directory('betails/photos')
                    ->maxSize(1024) // 1MB
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif']),
                TextInput::make('quantite')
                    ->label('Quantité')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->default(0),
                TextInput::make('origine')
                    ->label('Origine')
                    ->required()
                    ->maxLength(100),
                Forms\Components\FileUpload::make('video')
                    ->label('Vidéo')
                    // ->required()
                    ->disk('public')
                    ->directory('betails/videos')
                    ->maxSize(10240) // 10MB
                    ->acceptedFileTypes(['video/mp4', 'video/avi', 'video/mov']),
                Forms\Components\Select::make('disponibilite')
                    ->label('Disponibilité')
                    ->options([
                        'Disponible' => 'Disponible',
                        'Indisponible' => 'Indisponible',
                    ])
                    ->default('Disponible')
                    ->required(),
            ])->columns([     
            
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                
            
                Tables\Columns\TextColumn::make('categorie.nom_categorie')
                    ->label('Catégorie')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('race')
                    ->label('Race')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('age')
                    ->label('Âge')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('poids')
                    ->label('Poids (kg)')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('prix')
                    ->label('Prix (FCFA)')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('photo')
                    ->label('Photo')
                    ->formatStateUsing(fn ($state) => $state ? '<img src="' . asset('storage/' . $state) . '" alt="Betail Photo" style="width: 50px; height: auto;">' : 'Aucune photo')
                    ->html()
                    ->sortable()
                    ->searchable(),
            Tables\Columns\TextColumn::make('quantite')
                    ->label('quantité')
                    ->sortable()
                    ->searchable(),
            Tables\Columns\TextColumn::make('origine')
                    ->label('Origine')
                    ->sortable()
                    ->searchable(),
            Tables\Columns\TextColumn::make('video')
                    ->label('Vidéo')
                    ->formatStateUsing(fn ($state) => $state ? '<video width="100" controls><source src="' . asset('storage/' . $state) . '" type="video/mp4">Your browser does not support the video tag.</video>' : 'Aucune vidéo')
                    ->html()
                    ->sortable()
                    ->searchable(),
            Tables\Columns\TextColumn::make('disponibilite')
                    ->label('Disponibilité')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBetails::route('/'),
            'create' => Pages\CreateBetail::route('/create'),
            'edit' => Pages\EditBetail::route('/{record}/edit'),
        ];
    }
}
