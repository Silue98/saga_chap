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
        return $this->belongsTo(Categorie::class, 'id_categorie_betail');
    }
    public function cart()
    {
        return $this->hasMany(Cart::class, 'id_betail');}
}
