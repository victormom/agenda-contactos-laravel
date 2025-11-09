<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Este es el punto de entrada principal para los seeders
     */
    public function run(): void
    {
        // Llamar al seeder de categorías
        $this->call([
            CategorySeeder::class,
        ]);
    }
}
