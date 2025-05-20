<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\betail;

class Betailseeder extends Seeder
{
    public function run(): void
    {
        // Créer 20 enregistrements de betail aléatoires
        betail::factory()->count(20)->create();
    }
    
}
