<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BetailResource\Pages;
use App\Models\Betail;
use App\Models\BetailMedia;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;

class BetailResource extends Resource
{
    protected static ?string $model          = Betail::class;
    protected static ?string $navigationIcon  = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Bétails';
    protected static ?int    $navigationSort  = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Section::make('Informations générales')->schema([
                Forms\Components\Select::make('id_categorie_betail')
                    ->label('Catégorie')
                    ->options(\App\Models\Categorie::all()->pluck('nom_categorie', 'id_categorie'))
                    ->required()
                    ->searchable(),
                TextInput::make('race')
                    ->label('Race')->required()->maxLength(100),
                TextInput::make('age')
                    ->label('Âge (ans)')->required()->numeric()->minValue(0)->default(0),
                TextInput::make('poids')
                    ->label('Poids (kg)')->required()->numeric()->minValue(0)->default(0),
                TextInput::make('prix')
                    ->label('Prix (FCFA)')->required()->numeric()->minValue(0)->default(0),
                TextInput::make('quantite')
                    ->label('Stock')->required()->numeric()->minValue(0)->default(1),
                TextInput::make('origine')
                    ->label('Origine / Pays')->required()->maxLength(150),
                Forms\Components\Select::make('disponibilite')
                    ->label('Disponibilité')
                    ->options(['1' => 'Disponible', '0' => 'Indisponible'])
                    ->default('1')->required(),
            ])->columns(2),

            Forms\Components\Section::make('Photos')
                ->description('Uploadez vos photos. Ensuite cochez "Image principale" pour choisir celle affichée sur les cartes.')
                ->schema([
                    Forms\Components\FileUpload::make('images_upload')
                        ->label('Photos (plusieurs autorisées)')
                        ->multiple()
                        ->image()
                        ->disk('public')
                        ->directory('betails/photos')
                        ->maxSize(5120)
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->reorderable()
                        ->imagePreviewHeight('120')
                        ->panelLayout('grid')
                        ->dehydrated(false)
                        ->helperText('Après upload, copiez le nom du fichier et collez-le dans le champ ci-dessous pour le définir comme image principale.'),
                    Forms\Components\Select::make('image_principale')
                        ->label('Choisir l\'image principale')
                        ->options(function ($record) {
                            if (!$record) return [];
                            return \App\Models\BetailMedia::where('id_betail', $record->id_betail)
                                ->where('type', 'image')
                                ->pluck('chemin', 'chemin')
                                ->mapWithKeys(fn($v, $k) => [$k => basename($k)])
                                ->toArray();
                        })
                        ->default(function ($record) {
                            if (!$record) return null;
                            $p = \App\Models\BetailMedia::where('id_betail', $record->id_betail)
                                ->where('principale', true)->first();
                            return $p?->chemin;
                        })
                        ->helperText('Disponible uniquement lors de la modification. À la création, la 1ère photo uploadée sera automatiquement l\'image principale.')
                        ->dehydrated(false),
                ]),

            Forms\Components\Section::make('Vidéo')
                ->description('Une courte vidéo de présentation (MP4, WebM, MOV — max 50MB).')
                ->schema([
                    Forms\Components\FileUpload::make('video_upload')
                        ->label('Vidéo courte (optionnelle)')
                        ->disk('public')
                        ->directory('betails/videos')
                        ->maxSize(51200)
                        ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/quicktime'])
                        ->dehydrated(false),
                ]),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo_principale')
                    ->label('Photo')
                    ->getStateUsing(function (Betail $record): ?string {
                        $media = $record->images()->first();
                        if ($media) return $media->chemin;
                        return $record->photo ?? null;
                    })
                    ->disk('public')
                    ->width(60)->height(60)
                    ->extraImgAttributes(['style' => 'object-fit:cover;border-radius:6px;']),
                Tables\Columns\TextColumn::make('categorie.nom_categorie')
                    ->label('Catégorie')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('race')
                    ->label('Race')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('age')->label('Âge')->sortable(),
                Tables\Columns\TextColumn::make('poids')->label('Poids (kg)')->sortable(),
                Tables\Columns\TextColumn::make('prix')
                    ->label('Prix (FCFA)')
                    ->formatStateUsing(fn ($state) => number_format($state, 0, ',', ' ') . ' FCFA')
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantite')->label('Stock')->sortable(),
                Tables\Columns\TextColumn::make('images_count')
                    ->label('Photos')
                    ->getStateUsing(fn (Betail $record) => $record->images()->count() . ' 📷'),
                Tables\Columns\IconColumn::make('has_video')
                    ->label('Vidéo')
                    ->getStateUsing(fn (Betail $record) => $record->video_media()->exists())
                    ->boolean(),
                Tables\Columns\TextColumn::make('disponibilite')
                    ->label('Dispo')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state ? 'Disponible' : 'Indisponible')
                    ->color(fn ($state) => $state ? 'success' : 'danger'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('disponibilite')
                    ->options(['1' => 'Disponible', '0' => 'Indisponible']),
                Tables\Filters\SelectFilter::make('id_categorie_betail')
                    ->label('Catégorie')
                    ->options(\App\Models\Categorie::all()->pluck('nom_categorie', 'id_categorie')),
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

    public static function getRelations(): array { return []; }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBetails::route('/'),
            'create' => Pages\CreateBetail::route('/create'),
            'edit'   => Pages\EditBetail::route('/{record}/edit'),
        ];
    }
}
