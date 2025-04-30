<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class betail extends Model
{
    protected $table = 'betail';
    protected $primaryKey = 'id_betail';

    public function categorie_betail()
    {
        return $this->belongsTo(categorie_betail::class, 'id_categorie_betail');
    }


}
