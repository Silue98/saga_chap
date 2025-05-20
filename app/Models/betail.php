<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class betail extends Model
{
            use HasFactory;

    protected $table = 'betail';
    protected $primaryKey = 'id_betail';
    public $timestamps = false; // 👈 Ajoute cette ligne

    public function categorie_betail()
    {
        return $this->belongsTo(categorie_betail::class, 'id_categorie_betail');
    }



}
