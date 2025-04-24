<?php
namespace App\Http\Controllers;

use App\Models\Coleccion;
use App\Models\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColeccionController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $colecciones = Auth::user()->colecciones()->withCount('recetas')->paginate(12);
        
        return view('colecciones.index', compact('colecciones'));
    }
    
    public function show(Coleccion $coleccion)
    {
        if (Auth::id() !== $coleccion->user_id) {
            abort(403);
        }
        
        $coleccion->load(['recetas.user', 'recetas.categoria']);
        
        return view('colecciones.show', compact('coleccion'));
    }
    
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        return view('colecciones.create');
    }
    
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);
        
        $coleccion = new Coleccion($validatedData);
        $coleccion->user_id = Auth::id();
        $coleccion->save();
        
        return redirect()->route('colecciones.show', $coleccion)
                        ->with('success', 'Colección creada correctamente.');
    }
    
    public function edit(Coleccion $coleccion)
    {
        if (Auth::id() !== $coleccion->user_id) {
            abort(403);
        }
        
        return view('colecciones.edit', compact('coleccion'));
    }
    
    public function update(Request $request, Coleccion $coleccion)
    {
        if (Auth::id() !== $coleccion->user_id) {
            abort(403);
        }
        
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);
        
        $coleccion->update($validatedData);
        
        return redirect()->route('colecciones.show', $coleccion)
                        ->with('success', 'Colección actualizada correctamente.');
    }
    
    public function destroy(Coleccion $coleccion)
    {
        if (Auth::id() !== $coleccion->user_id) {
            abort(403);
        }
        
        $coleccion->delete();
        
        return redirect()->route('colecciones.index')
                        ->with('success', 'Colección eliminada correctamente.');
    }
    
    public function addReceta(Request $request, Coleccion $coleccion)
    {
        if (Auth::id() !== $coleccion->user_id) {
            abort(403);
        }
        
        $request->validate([
            'receta_id' => 'required|exists:recetas,id',
        ]);
        
        $recetaId = $request->input('receta_id');
        
        if (!$coleccion->recetas()->where('receta_id', $recetaId)->exists()) {
            $coleccion->recetas()->attach($recetaId);
            $message = 'Receta añadida a la colección.';
        } else {
            $message = 'Esta receta ya está en la colección.';
        }
        
        return back()->with('success', $message);
    }
    
    public function removeReceta(Coleccion $coleccion, Receta $receta)
    {
        if (Auth::id() !== $coleccion->user_id) {
            abort(403);
        }
        
        $coleccion->recetas()->detach($receta->id);
        
        return back()->with('success', 'Receta eliminada de la colección.');
    }
}
