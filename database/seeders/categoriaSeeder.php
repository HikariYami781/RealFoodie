<?php
namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        $categorias = [
            ['nombre' => 'Desayunos', 'descripcion' => 'Recetas para empezar el día'],
            ['nombre' => 'Entradas', 'descripcion' => 'Platillos para comenzar'],
            ['nombre' => 'Platos principales', 'descripcion' => 'Platos fuertes para toda ocasión'],
            ['nombre' => 'Postres', 'descripcion' => 'Dulces finales'],
            ['nombre' => 'Bebidas', 'descripcion' => 'Refrescos y cócteles'],
            ['nombre' => 'Vegetarianas', 'descripcion' => 'Sin carne'],
            ['nombre' => 'Veganas', 'descripcion' => 'Sin productos animales'],
            ['nombre' => 'Sin gluten', 'descripcion' => 'Para personas con celiaquía'],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}

/**Lo podemos cambiar para más adelante */
