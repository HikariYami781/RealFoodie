<?php
namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller
{
    public function store(Request $request, Receta $receta)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $validatedData = $request->validate([
            'contenido' => 'required|min:3|max:500',
        ]);

        $comentario = new Comentario($validatedData);
        $comentario->user_id = Auth::id();
        $comentario->receta_id = $receta->id;
        $comentario->fecha = now();
        $comentario->save();

        return back()->with('success', 'Comentario añadido correctamente.');
    }
    
    // Nuevo método para actualizar un comentario
    public function update(Request $request, Comentario $comentario)
    {
        // Verificar que el usuario autenticado es el autor del comentario
        if (Auth::id() !== $comentario->user_id) {
            abort(403, 'No tienes permiso para editar este comentario.');
        }

        $validatedData = $request->validate([
            'contenido' => 'required|min:3|max:500',
        ]);

        $comentario->contenido = $validatedData['contenido'];
        $comentario->save();

        return back()->with('success', 'Comentario actualizado correctamente.');
    }

    public function destroy(Comentario $comentario)
    {
        // Ahora solo el autor del comentario puede eliminarlo
        if (Auth::id() !== $comentario->user_id) {
            abort(403, 'No tienes permiso para eliminar este comentario.');
        }

        $comentario->delete();

        return back()->with('success', 'Comentario eliminado correctamente.');
    }
}