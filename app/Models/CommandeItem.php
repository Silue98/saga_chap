<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommandeItem extends Model
{
    protected $table = 'commande_items';
    protected $fillable = [
        'commande_id',
        'id_betail',
        'quantite',
        'prix_unitaire',
    ];

    public function commande()
    {
        return $this->belongsTo(Commande::class, 'commande_id');
    }

    public function betail()
    {
        return $this->belongsTo(Betail::class, 'id_betail', 'id_betail');
    }
}
