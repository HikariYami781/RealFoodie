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

    public function destroy(Comentario $comentario)
    {
        if (Auth::id() !== $comentario->user_id && Auth::id() !== $comentario->receta->user_id) {
            abort(403);
        }

        $comentario->delete();

        return back()->with('success', 'Comentario eliminado correctamente.');
    }
}
