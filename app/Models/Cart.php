<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    protected $fillable = [
        'id_betail',
        'user_id',
        'session_id',
        'quantite',
    ];

    public function betail()
    {
        return $this->belongsTo(Betail::class, 'id_betail', 'id_betail');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
