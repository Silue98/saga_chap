<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Betail;

class BetailSeeder extends Seeder
{
    public function run(): void
    {
        Betail::factory()->count(20)->create();
    }
}

