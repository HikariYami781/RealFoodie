<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            CategoriaSeeder::class,
            IngredienteSeeder::class,
            RecetaSeeder::class,
        ]);
    }
}
