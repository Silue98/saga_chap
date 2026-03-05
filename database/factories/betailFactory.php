<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Betail;
use App\Models\Categorie;

class BetailFactory extends Factory
{
    protected $model = Betail::class;

    public function definition(): array
    {
        return [
            'id_categorie_betail' => Categorie::inRandomOrder()->first()?->id_categorie ?? 1,
            'race' => $this->faker->randomElement([
                'Brahman', 'Sahelien', "N'dama", 'Zébu', 'Bali-bali',
                'Peulh', 'Djakoré', 'Azawak', 'Lagune', 'Kouri'
            ]),
            'age' => $this->faker->numberBetween(1, 10),
            'poids' => $this->faker->randomFloat(2, 30, 600),
            'prix' => $this->faker->randomElement([50000, 75000, 100000, 150000, 200000, 300000, 500000, 750000]),
            'origine' => $this->faker->randomElement(['Mali', 'Sénégal', 'Burkina Faso', 'Niger', 'Côte d\'Ivoire', 'Guinée']),
            'photo' => null,
            'video' => null,
            'quantite' => $this->faker->numberBetween(1, 20),
            'disponibilite' => true,
        ];
    }
}

