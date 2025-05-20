<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\betail;

class BetailFactory extends Factory
{
    protected $model = betail::class;

    public function definition(): array
    {
        return [
            'race' => $this->faker->randomElement(['Brahman', 'Sahelien', 'N\'dama']),
            'age' => $this->faker->numberBetween(1, 10),
            'poids' => $this->faker->randomFloat(2, 100, 500),
            'prix' => $this->faker->randomFloat(2, 100000, 900000),
            'origine' => $this->faker->country(),
            'photo' => $this->faker->image('public/storage/images', 640, 480, null, false),
            'video' => $this->faker->url(),
            'disponibilite' => $this->faker->boolean(),
            'id_categorie_betail' => \App\Models\categorie_betail::inRandomOrder()->first()?->id_categorie ?? 1,
        ];
    }
}
