<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorieBetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categorie_betail')->insert([
            [
                'nom_categorie' => 'Mouton',
                'description' => 'Bétail de type mouton.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_categorie' => 'Boeuf',
                'description' => 'Bétail de type boeuf.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_categorie' => 'Cabri',
                'description' => 'Bétail de type cabri.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
