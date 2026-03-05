<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BetailMedia extends Model
{
    protected $table    = 'betail_medias';
    protected $fillable = [
        'id_betail',
        'type',
        'chemin',
        'principale',
        'ordre',
    ];

    protected function casts(): array
    {
        return [
            'principale' => 'boolean',
        ];
    }

    public function betail()
    {
        return $this->belongsTo(Betail::class, 'id_betail', 'id_betail');
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->chemin);
    }
}
