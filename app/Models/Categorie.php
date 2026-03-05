<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $table      = 'categorie_betail';
    protected $primaryKey = 'id_categorie';

    protected $fillable = [
        'nom_categorie',
        'description',
    ];

    public function betail()
    {
        return $this->hasMany(Betail::class, 'id_categorie_betail', 'id_categorie');
    }
}
