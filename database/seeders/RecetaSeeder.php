<?php
namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Comentario;
use App\Models\Ingrediente;
use App\Models\Paso;
use App\Models\Receta;
use App\Models\User;
use App\Models\Valoracion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class RecetaSeeder extends Seeder
{
    public function run()
    {
        // Obtener datos existentes
        $users = User::all();
        $categorias = Categoria::all();
        $ingredientes = Ingrediente::all();
        
        // Crear algunas recetas de ejemplo
        for ($i = 1; $i <= 20; $i++) {
            $receta = Receta::create([
                'user_id' => $users->random()->id,
                'categoria_id' => $categorias->random()->id,
                'titulo' => 'Receta de ejemplo ' . $i,
                'descripcion' => 'Esta es una descripción para la receta de ejemplo ' . $i,
                'preparacion' => 'Preparación detallada para la receta ' . $i,
                'dificultad' => rand(1, 5),
                'coccion' => rand(10, 120),
                'fecha_publicacion' => Carbon::now()->subDays(rand(1, 30)),
                'porciones' => rand(1, 6),
                'publica' => rand(0, 1),
            ]);

            // Añadir de 3 a 8 ingredientes aleatorios
            $ingredientesAleatorios = $ingredientes->random(rand(3, 8));
            foreach ($ingredientesAleatorios as $ingrediente) {
                $receta->ingredientes()->attach($ingrediente->id, [
                    'cantidad' => rand(1, 500),
                ]);
            }

            // Añadir de 3 a 6 pasos
            for ($j = 1; $j <= rand(3, 6); $j++) {
                Paso::create([
                    'receta_id' => $receta->id,
                    'descripcion' => 'Paso ' . $j . ' para la receta ' . $i,
                    'orden' => $j,
                ]);
            }

            // Añadir algunos comentarios
            for ($k = 1; $k <= rand(0, 5); $k++) {
                Comentario::create([
                    'user_id' => $users->random()->id,
                    'receta_id' => $receta->id,
                    'contenido' => 'Este es un comentario de ejemplo #' . $k . ' para la receta ' . $i,
                    'fecha' => Carbon::now()->subDays(rand(0, 29)),
                ]);
            }

            // Añadir algunas valoraciones
            $usersForRating = $users->random(rand(0, 8));
            foreach ($usersForRating as $user) {
                Valoracion::create([
                    'user_id' => $user->id,
                    'receta_id' => $receta->id,
                    'puntuacion' => rand(1, 5),
                ]);
            }
        }
    }
}