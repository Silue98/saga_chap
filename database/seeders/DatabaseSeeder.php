<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Utilisateur client normal
        User::factory()->create([
            'name'     => 'Test User',
            'email'    => 'test@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        // Administrateur Filament
        User::factory()->create([
            'name'     => 'Admin SagaChap',
            'email'    => 'admin@sagachap.com',
            'password' => Hash::make('admin1234'),
            'is_admin' => true,
        ]);

        $this->call([
            CategorieBetailSeeder::class,
            BetailSeeder::class,
        ]);
    }
}

