<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Usuario admin
        User::create([
            'nombre' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'descripcion' => 'Administrador del sitio',
        ]);

        // Crear algunos usuarios de ejemplo
        User::factory(10)->create();
    }
}
