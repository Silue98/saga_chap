<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Betail extends Model
{
    use HasFactory;

    protected $table = 'betail';
    protected $primaryKey = 'id_betail';
    public $timestamps = false;

    // 👇 Ajout de la propriété fillable
    protected $fillable = [
        'id_categorie_betail',
        // Ajoute ici d'autres champs si tu veux les rendre assignables
    ];

    public function Categorie()
    {
        return $this->belongsTo(Categorie::class, 'id_categorie_betail');
    }
}
