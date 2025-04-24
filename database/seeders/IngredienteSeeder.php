<?php
namespace Database\Seeders;

use App\Models\Ingrediente;
use Illuminate\Database\Seeder;

class IngredienteSeeder extends Seeder
{
    public function run()
    {
        $ingredientes = [
            ['nombre' => 'Harina', 'unidad_medida' => 'gramos'],
            ['nombre' => 'Azúcar', 'unidad_medida' => 'gramos'],
            ['nombre' => 'Sal', 'unidad_medida' => 'gramos'],
            ['nombre' => 'Levadura', 'unidad_medida' => 'gramos'],
            ['nombre' => 'Huevos', 'unidad_medida' => 'unidades'],
            ['nombre' => 'Leche', 'unidad_medida' => 'mililitros'],
            ['nombre' => 'Mantequilla', 'unidad_medida' => 'gramos'],
            ['nombre' => 'Aceite de oliva', 'unidad_medida' => 'mililitros'],
            ['nombre' => 'Tomates', 'unidad_medida' => 'unidades'],
            ['nombre' => 'Cebolla', 'unidad_medida' => 'unidades'],
            ['nombre' => 'Ajo', 'unidad_medida' => 'dientes'],
            ['nombre' => 'Pimiento', 'unidad_medida' => 'unidades'],
            ['nombre' => 'Zanahoria', 'unidad_medida' => 'unidades'],
            ['nombre' => 'Pollo', 'unidad_medida' => 'gramos'],
            ['nombre' => 'Carne molida', 'unidad_medida' => 'gramos'],
            ['nombre' => 'Arroz', 'unidad_medida' => 'gramos'],
            ['nombre' => 'Pasta', 'unidad_medida' => 'gramos'],
            ['nombre' => 'Queso', 'unidad_medida' => 'gramos'],
            ['nombre' => 'Patatas', 'unidad_medida' => 'unidades'],
            ['nombre' => 'Pescado', 'unidad_medida' => 'gramos'],
        ];

        foreach ($ingredientes as $ingrediente) {
            Ingrediente::create($ingrediente);
        }
    }
}

/**Se supone que hay unas recetas del sistema por defecto y el resto las crean los usuarios */
