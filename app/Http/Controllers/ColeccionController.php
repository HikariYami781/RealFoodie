<?php
// 1. ACTUALIZA tu ColeccionController.php - Añade el método helper

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
    
    // Obtener las colecciones del usuario autenticado 
    $colecciones = Coleccion::where('user_id', Auth::id())
                            ->with(['recetas.user', 'recetas.categoria', 'user'])
                            ->orderBy('created_at', 'desc')
                            ->get();
    
    // Añadir la URL de la imagen de perfil a cada colección
    foreach ($colecciones as $coleccion) {
        if ($coleccion->user) {
            $coleccion->user->profile_image_url = $this->getProfileImage($coleccion->user);
        }
    }
    
    return view('colecciones.index', compact('colecciones'));
}

    public function show(Coleccion $coleccion)
    {
        
        $coleccion->load(['recetas.user', 'recetas.categoria', 'user']);
        // Verificar si el usuario actual es el propietario
        $isOwner = Auth::check() && Auth::id() === $coleccion->user_id;
        $coleccion->user->profile_image_url = $this->getProfileImage($coleccion->user);
        
        return view('colecciones.show', compact('coleccion', 'isOwner'));
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
        
        if ($request->has('add_recipe_automatically') && !empty($validatedData['receta_id'])) {
            $receta = Receta::find($validatedData['receta_id']);
            
            if ($receta) {
                // Añadir la receta a la colección
                $coleccion->recetas()->attach($validatedData['receta_id']);
                
                return redirect()->back()->with('success', 
                    "Colección '{$coleccion->nombre}' creada y receta '{$receta->titulo}' añadida correctamente.");
            }
        }
        
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
	
	
    /**
     * Helper method para obtener la imagen de perfil o la por defecto
     */
    private function getProfileImage($user)
    {
        if ($user->foto_perfil && file_exists(storage_path('app/public/fotos_perfil/' . $user->foto_perfil))) {
            return asset('storage/fotos_perfil/' . $user->foto_perfil);
        }
        
        // Verifica que la imagen por defecto existe
        $defaultImage = public_path('images/x_defecto.jpg');
        if (file_exists($defaultImage)) {
            return asset('images/x_defecto.jpg');
        }
        
        // Fallback a una imagen en línea si no existe localmente
        return 'https://via.placeholder.com/50x50/007bff/ffffff?text=' . substr($user->nombre, 0, 1);
    }
}
