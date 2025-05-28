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

        // Cargar colecciones con sus recetas para evitar consultas N+1
        $colecciones = Auth::user()->colecciones()
            ->with(['recetas'])
            ->orderBy('updated_at', 'desc')
            ->get();
        
        return view('colecciones.index', compact('colecciones'));
    }
    
    public function show(Coleccion $coleccion)
    {
        // Verificar que el usuario actual es el propietario de la colección
        if (Auth::id() !== $coleccion->user_id) {
            abort(403, 'No tienes permiso para ver esta colección.');
        }
        
        // Cargar las relaciones necesarias
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
            'descripcion' => 'nullable|string|max:1000',
            'receta_id' => 'nullable|exists:recetas,id',
            'add_recipe_automatically' => 'nullable|string',
        ]);
        
        $coleccion = new Coleccion([
            'nombre' => $validatedData['nombre'],
            'descripcion' => $validatedData['descripcion'] ?? null,
        ]);
        $coleccion->user_id = Auth::id();
        $coleccion->save();
        
        // Si viene el parámetro para añadir receta automáticamente
        if ($request->has('add_recipe_automatically') && !empty($validatedData['receta_id'])) {
            $receta = Receta::find($validatedData['receta_id']);
            
            if ($receta) {
                // Añadir la receta a la colección
                $coleccion->recetas()->attach($validatedData['receta_id']);
                
                return redirect()->back()->with('success', 
                    "Colección '{$coleccion->nombre}' creada y receta '{$receta->titulo}' añadida correctamente.");
            }
        }
        
        // Si es una creación normal (desde formulario de crear colección)
        if ($request->expectsJson() || $request->has('add_recipe_automatically')) {
            return redirect()->back()->with('success', "Colección '{$coleccion->nombre}' creada correctamente.");
        }
        
        return redirect()->route('colecciones.show', $coleccion)
                        ->with('success', 'Colección creada correctamente.');
    }
    
    public function edit(Coleccion $coleccion)
    {
        if (Auth::id() !== $coleccion->user_id) {
            abort(403, 'No tienes permiso para editar esta colección.');
        }
        
        return view('colecciones.edit', compact('coleccion'));
    }
    
    public function update(Request $request, Coleccion $coleccion)
    {
        if (Auth::id() !== $coleccion->user_id) {
            abort(403, 'No tienes permiso para actualizar esta colección.');
        }
        
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
        ]);
        
        $coleccion->update($validatedData);
        
        return redirect()->route('colecciones.show', $coleccion)
                        ->with('success', 'Colección actualizada correctamente.');
    }
    
    public function destroy(Coleccion $coleccion)
    {
        if (Auth::id() !== $coleccion->user_id) {
            abort(403, 'No tienes permiso para eliminar esta colección.');
        }
        
        $nombreColeccion = $coleccion->nombre;
        $coleccion->delete();
        
        return redirect()->route('colecciones.index')
                        ->with('success', "Colección '{$nombreColeccion}' eliminada correctamente.");
    }
    
    public function addReceta(Request $request, Coleccion $coleccion)
    {
        if (Auth::id() !== $coleccion->user_id) {
            abort(403, 'No tienes permiso para modificar esta colección.');
        }
        
        $request->validate([
            'receta_id' => 'required|exists:recetas,id',
        ]);
        
        $recetaId = $request->input('receta_id');
        
        // Verificar que la receta existe
        $receta = Receta::find($recetaId);
        if (!$receta) {
            return back()->with('error', 'La receta no existe.');
        }
        
        // Verificar si ya está en la colección
        if (!$coleccion->recetas()->where('receta_id', $recetaId)->exists()) {
            $coleccion->recetas()->attach($recetaId);
            $message = "Receta '{$receta->titulo}' añadida a la colección.";
            $type = 'success';
        } else {
            $message = 'Esta receta ya está en la colección.';
            $type = 'warning';
        }
        
        return back()->with($type, $message);
    }
    
    public function removeReceta(Coleccion $coleccion, Receta $receta)
    {
        if (Auth::id() !== $coleccion->user_id) {
            abort(403, 'No tienes permiso para modificar esta colección.');
        }
        
        // Verificar que la receta está en la colección
        if ($coleccion->recetas()->where('receta_id', $receta->id)->exists()) {
            $coleccion->recetas()->detach($receta->id);
            $message = "Receta '{$receta->titulo}' eliminada de la colección.";
        } else {
            $message = 'La receta no está en esta colección.';
        }
        
        return back()->with('success', $message);
    }
}