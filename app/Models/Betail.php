<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Betail extends Model
{
    use HasFactory;

    protected $table      = 'betail';
    protected $primaryKey = 'id_betail';
    public $timestamps    = false;

    protected $fillable = [
        'id_categorie_betail',
        'race',
        'age',
        'poids',
        'prix',
        'origine',
        'photo',
        'video',
        'quantite',
        'disponibilite',
        'localisation_lat',
        'localisation_lng',
        'localisation_updated_at',
        'localisation_adresse',
    ];

    protected $casts = [
        'disponibilite'           => 'boolean',
        'localisation_lat'        => 'float',
        'localisation_lng'        => 'float',
        'localisation_updated_at' => 'datetime',
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'id_categorie_betail', 'id_categorie');
    }

    public function cart()
    {
        return $this->hasMany(Cart::class, 'id_betail', 'id_betail');
    }

    public function medias()
    {
        return $this->hasMany(BetailMedia::class, 'id_betail', 'id_betail')->orderBy('ordre');
    }

    public function images()
    {
        return $this->hasMany(BetailMedia::class, 'id_betail', 'id_betail')
                    ->where('type', 'image')
                    ->orderBy('ordre');
    }

    public function video_media()
    {
        return $this->hasOne(BetailMedia::class, 'id_betail', 'id_betail')
                    ->where('type', 'video');
    }

    /**
     * Relation utilisée par Filament ImageColumn::make('imagePrincipale.chemin').
     * Trie par principale DESC puis ordre ASC :
     * → si une image est marquée principale=true, elle sort en premier
     * → sinon, la première image (ordre 0) est retournée comme fallback automatique
     */
    public function imagePrincipale()
    {
        return $this->hasOne(BetailMedia::class, 'id_betail', 'id_betail')
                    ->where('type', 'image')
                    ->orderByDesc('principale')
                    ->orderBy('ordre');
    }

    public function getPhotoUrlAttribute(): ?string
    {
        $principale = $this->imagePrincipale;
        if ($principale) return asset('storage/' . $principale->chemin);
        if ($this->photo) return asset('storage/' . $this->photo);
        return null;
    }

    public function hasLocalisation(): bool
    {
        return !is_null($this->localisation_lat) && !is_null($this->localisation_lng);
    }
}
