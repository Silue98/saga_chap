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
use Illuminate\Support\Facades\Storage;

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

            // Photos existantes (visible uniquement en édition)
            Forms\Components\Section::make('Photos existantes')
                ->description('Images actuellement enregistrées pour ce bétail.')
                ->schema([
                    Forms\Components\Placeholder::make('images_existantes')
                        ->label('')
                        ->content(function ($record) {
                            if (!$record) return 'Aucune image.';
                            $medias = BetailMedia::where('id_betail', $record->id_betail)
                                ->where('type', 'image')
                                ->orderByDesc('principale')
                                ->orderBy('ordre')
                                ->get();
                            if ($medias->isEmpty()) return new \Illuminate\Support\HtmlString('<p style="color:#6b7280;">Aucune image enregistrée.</p>');
                            $html = '<div style="display:flex;flex-wrap:wrap;gap:12px;margin-top:8px;">';
                            foreach ($medias as $media) {
                                $url   = asset('storage/' . $media->chemin);
                                $badge = $media->principale
                                    ? '<span style="position:absolute;top:4px;left:4px;background:#16a34a;color:#fff;font-size:10px;padding:2px 6px;border-radius:4px;font-weight:600;">★ Principale</span>'
                                    : '';
                                $border = $media->principale ? '#16a34a' : '#e5e7eb';
                                $html .= '<div style="position:relative;border:2px solid '.$border.';border-radius:8px;overflow:hidden;width:130px;height:110px;background:#f9fafb;">'
                                    . $badge
                                    . '<img src="'.$url.'" style="width:100%;height:100%;object-fit:contain;">'
                                    . '</div>';
                            }
                            $html .= '</div>';
                            return new \Illuminate\Support\HtmlString($html);
                        }),
                ])
                ->visible(fn ($record) => $record !== null),

            // Upload photos
            Forms\Components\Section::make('Photos')
                ->description('Uploadez vos photos. Les nouvelles photos s\'ajouteront aux existantes, sauf si vous activez "Remplacer toutes les images".')
                ->schema([
                    Forms\Components\FileUpload::make('images_upload')
                        ->label('Ajouter des photos (plusieurs autorisées)')
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
                        ->helperText('Formats : JPG, PNG, WebP. Max 5 MB par image.'),

                    Forms\Components\Select::make('image_principale_chemin')
                        ->label('Définir l\'image principale (parmi les existantes)')
                        ->options(function ($record) {
                            if (!$record) return [];
                            return BetailMedia::where('id_betail', $record->id_betail)
                                ->where('type', 'image')
                                ->get()
                                ->mapWithKeys(fn ($m) => [
                                    $m->chemin => basename($m->chemin) . ($m->principale ? ' ★' : '')
                                ])
                                ->toArray();
                        })
                        ->default(function ($record) {
                            if (!$record) return null;
                            return BetailMedia::where('id_betail', $record->id_betail)
                                ->where('type', 'image')
                                ->where('principale', true)
                                ->value('chemin');
                        })
                        ->placeholder('Sélectionner une image principale')
                        ->dehydrated(false)
                        ->visible(fn ($record) => $record !== null)
                        ->helperText('Choisissez l\'image affichée sur les cartes du catalogue.'),

                    Forms\Components\Toggle::make('supprimer_toutes_images')
                        ->label('Remplacer toutes les images existantes par les nouvelles')
                        ->default(false)
                        ->dehydrated(false)
                        ->visible(fn ($record) => $record !== null)
                        ->helperText('Activez pour supprimer toutes les anciennes photos avant d\'ajouter les nouvelles.'),
                ]),

            Forms\Components\Section::make('Vidéo courte')
                ->description('Une courte vidéo de présentation (MP4, WebM, MOV — max 50MB).')
                ->schema([
                    Forms\Components\FileUpload::make('video_upload')
                        ->label('Vidéo courte (optionnelle)')
                        ->disk('public')
                        ->directory('betails/videos')
                        ->maxSize(51200)
                        ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/quicktime'])
                        ->dehydrated(false)
                        ->helperText('Formats acceptés : MP4, WebM, MOV. Max 50 MB.'),
                ]),

            Forms\Components\Section::make('📍 Localisation GPS')
                ->description('Coordonnées GPS pour la carte en temps réel.')
                ->schema([
                    TextInput::make('localisation_lat')
                        ->label('Latitude')->numeric()->placeholder('ex: 5.3484')
                        ->helperText('Google Maps > clic droit > "Quelle est cette adresse ?"'),
                    TextInput::make('localisation_lng')
                        ->label('Longitude')->numeric()->placeholder('ex: -4.0167'),
                    TextInput::make('localisation_adresse')
                        ->label('Description de l\'emplacement')->maxLength(255)
                        ->placeholder('ex: Ferme de Yamoussoukro, Côte d\'Ivoire')
                        ->columnSpanFull(),
                ])->columns(2),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('imagePrincipale.chemin')
                    ->label('Photo')
                    ->disk('public')
                    ->height(60)
                    ->width(60)
                    ->defaultImageUrl(url('/images/logo.jpeg'))
                    ->extraImgAttributes(['style' => 'object-fit:contain;background:#f9fafb;border-radius:6px;']),
                Tables\Columns\TextColumn::make('race')
                    ->label('Race')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('categorie.nom_categorie')
                    ->label('Catégorie')->sortable(),
                Tables\Columns\TextColumn::make('prix')
                    ->label('Prix (FCFA)')
                    ->formatStateUsing(fn ($state) => number_format($state, 0, ',', ' ') . ' FCFA')
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantite')
                    ->label('Stock')->sortable(),
                Tables\Columns\IconColumn::make('disponibilite')
                    ->label('Disponible')->boolean(),
                Tables\Columns\IconColumn::make('localisation_lat')
                    ->label('GPS')
                    ->icon(fn ($state) => $state ? 'heroicon-o-map-pin' : 'heroicon-o-x-mark')
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->tooltip(fn ($state) => $state ? 'Localisation active' : 'Pas de localisation'),
            ])
            ->defaultSort('id_betail', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('disponibilite')
                    ->options(['1' => 'Disponible', '0' => 'Indisponible'])
                    ->label('Disponibilité'),
                Tables\Filters\SelectFilter::make('id_categorie_betail')
                    ->label('Catégorie')
                    ->options(\App\Models\Categorie::all()->pluck('nom_categorie', 'id_categorie')),
            ])
            ->actions([
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
