<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $table = 'commandes';
    protected $fillable = [
        'user_id',
        'nom',
        'prenom',
        'telephone',
        'adresse',
        'ville',
        'montant_total',
        'statut',
        'session_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items()
    {
        return $this->hasMany(CommandeItem::class, 'commande_id');
    }
}
