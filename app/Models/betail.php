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
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'id_categorie_betail', 'id_categorie');
    }

    public function cart()
    {
        return $this->hasMany(Cart::class, 'id_betail', 'id_betail');
    }

    // Tous les médias (images + vidéo)
    public function medias()
    {
        return $this->hasMany(BetailMedia::class, 'id_betail', 'id_betail')->orderBy('ordre');
    }

    // Images uniquement
    public function images()
    {
        return $this->hasMany(BetailMedia::class, 'id_betail', 'id_betail')
                    ->where('type', 'image')
                    ->orderBy('ordre');
    }

    // Vidéo uniquement (une seule)
    public function video_media()
    {
        return $this->hasOne(BetailMedia::class, 'id_betail', 'id_betail')
                    ->where('type', 'video');
    }

    // Image principale pour les cartes
    public function imagePrincipale()
    {
        return $this->hasOne(BetailMedia::class, 'id_betail', 'id_betail')
                    ->where('type', 'image')
                    ->where('principale', true)
                    ->orderBy('ordre');
    }

    // Accessor : retourne l'URL de la photo principale (compatibilité avec l'ancien code)
    public function getPhotoUrlAttribute(): ?string
    {
        $principale = $this->imagePrincipale;
        if ($principale) return asset('storage/' . $principale->chemin);
        $first = $this->images->first();
        if ($first) return asset('storage/' . $first->chemin);
        if ($this->photo) return asset('storage/' . $this->photo);
        return null;
    }
}
