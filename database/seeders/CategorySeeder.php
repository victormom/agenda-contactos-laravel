<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Esto crea categorías predefinidas con colores
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Familia', 'color' => '#EF4444'], // Rojo
            ['name' => 'Amigos', 'color' => '#3B82F6'], // Azul
            ['name' => 'Trabajo', 'color' => '#10B981'], // Verde
            ['name' => 'Escuela', 'color' => '#F59E0B'], // Amarillo
            ['name' => 'Otros', 'color' => '#6B7280'], // Gris
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
