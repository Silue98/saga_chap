<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class categorie_betail extends Model
{
    //
    protected $table = 'categorie_betail';
    protected $primaryKey = 'id_categorie';

    function betail()
    {
        return $this->hasMany(betail::class, 'id_categorie_betail');
    }

}
