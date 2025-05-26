<?php
namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Ingrediente;
use App\Models\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RecetaController extends Controller
{
    public function index()
    {
        // Cargamos las recetas públicas con sus relaciones
        $recetas = Receta::where('publica', true)
                ->orderBy('fecha_publicacion', 'desc')
                ->with(['user', 'categoria', 'valoraciones'])
                ->paginate(6);
        
        // Si el usuario está autenticado, verificamos qué recetas son favoritas
        if (Auth::check()) {
            $favoritasIds = Auth::user()->recetasFavoritas()->pluck('receta_id')->toArray();
            return view('index', compact('recetas', 'favoritasIds'));
        }
        
        return view('index', compact('recetas'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $recetas = Receta::where(function($q) use ($query) {
                    $q->where('titulo', 'LIKE', '%' . $query . '%')
                      ->orWhere('descripcion', 'LIKE', '%' . $query . '%');
                })
                ->where('publica', true) // Solo recetas públicas
                ->with(['user', 'categoria', 'valoraciones'])
                ->paginate(6) // Mantener consistencia con index
                ->appends(['query' => $query]);
        
        // Verificamos también los favoritos en la búsqueda
        if (Auth::check()) {
            $favoritasIds = Auth::user()->recetasFavoritas()->pluck('receta_id')->toArray();
            return view('index', compact('recetas', 'favoritasIds'));
        }
        
        return view('index', compact('recetas'));
    }

    public function show(Receta $receta)
    {
        // Solo permite ver recetas públicas o propias
        if (!$receta->publica && (!Auth::check() || Auth::id() != $receta->user_id)) {
            abort(403);
        }

        $receta->load(['ingredientes', 'pasos', 'user', 'categoria', 'comentarios.user', 'valoraciones.user']);
        
        // Calcula estadísticas de valoraciones
        $valoraciones = $receta->valoraciones;
        $puntuacionPromedio = $valoraciones->avg('puntuacion');
        $totalValoraciones = $valoraciones->count();
        $distribuccionValoraciones = [];
        
        // Calcular distribución de valoraciones (1-5 estrellas)
        for ($i = 1; $i <= 5; $i++) {
            $distribuccionValoraciones[$i] = $valoraciones->where('puntuacion', $i)->count();
        }
        
        // Verificar si el usuario actual ya ha valorado esta receta
        $valoracionUsuario = null;
        if (Auth::check()) {
            $valoracionUsuario = $valoraciones->where('user_id', Auth::id())->first();
        }

        return view('recetas.show', compact(
            'receta', 
            'puntuacionPromedio', 
            'totalValoraciones',
            'distribuccionValoraciones',
            'valoracionUsuario'
        ));
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view('recetas.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'pasos.*' => 'required|string',
            'ingredientes.*' => 'required|string',
            'cantidades.*' => 'required|string',
            'unidades.*' => 'nullable|string',
            'dificultad' => 'required|string',
            'preparacion' => 'required|numeric',  
            'coccion' => 'required|numeric',      
            'categoria_id' => 'required|exists:categorias,id',
            'porciones' => 'required|integer|min:1',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Crear receta principal
        $receta = Receta::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'dificultad' => $request->dificultad,
            'preparacion' => $request->preparacion,  
            'coccion' => $request->coccion,          
            'categoria_id' => $request->categoria_id,
            'porciones' => $request->porciones,      
            'user_id' => auth()->id(),
            'publica' => true, 
            'fecha_publicacion' => now()
        ]);
    
        // Procesar imagen
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
            $rutaImagen = $imagen->storeAs('recetas', $nombreImagen, 'public');
            $receta->imagen = $rutaImagen;
            $receta->save();
        }

        // Guardar ingredientes
        $ingredientes = $request->input('ingredientes');
        $cantidades = $request->input('cantidades');
        $unidades = $request->input('unidades');

        foreach ($ingredientes as $index => $nombre) {
            if (!empty($nombre)) {
                $ingrediente = Ingrediente::firstOrCreate(['nombre' => $nombre]);

                $receta->ingredientes()->attach($ingrediente->id, [
                    'cantidad' => $cantidades[$index],
                    'unidad' => $unidades[$index] ?? null,
                ]);
            }
        }

        // Guardar pasos
        if ($request->filled('pasos')) {
            foreach ($request->pasos as $orden => $descripcion) {
                $receta->pasos()->create([
                    'descripcion' => $descripcion,
                    'orden' => $orden + 1,
                ]);
            }
        }

        return redirect()->route('home')->with('success', 'Receta creada con éxito');
    }

    public function edit(Receta $receta) 
    {
        // Verificar si el usuario actual es el propietario
        if (Auth::id() != $receta->user_id) {
            return redirect()->route('recetas.show', $receta)
                ->with('error', 'No tienes permiso para editar esta receta');
        }
        
        $categorias = Categoria::all();
        
        return view('recetas.edit', compact('receta', 'categorias'));
    }

    public function update(Request $request, Receta $receta)
    {
        if (Auth::id() != $receta->user_id) {
            return redirect()->route('recetas.show', $receta)
                ->with('error', 'No tienes permiso para editar esta receta');
        }
        
        // Validación básica 
        $request->validate([
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'ingredientes' => 'required|array',
            'cantidades' => 'required|array',
            'pasos' => 'required|array',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Actualizar datos básicos de la receta
        $receta->update([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'preparacion' => $request->preparacion ?? $receta->preparacion,
            'coccion' => $request->coccion ?? $receta->coccion,
            'dificultad' => $request->dificultad ?? $receta->dificultad,
            'porciones' => $request->porciones ?? $receta->porciones,
            'categoria_id' => $request->categoria_id ?? $receta->categoria_id
        ]);
        
        // Procesar la imagen si se ha subido una nueva
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior si existe
            if ($receta->imagen) {
                Storage::disk('public')->delete($receta->imagen);
            }
            
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
            $rutaImagen = $imagen->storeAs('recetas', $nombreImagen, 'public');
            $receta->imagen = $rutaImagen;
            $receta->save();
        }
        
        // Actualizar ingredientes
        $receta->ingredientes()->detach();
        $ingredientes = $request->input('ingredientes');
        $cantidades = $request->input('cantidades');
        $unidades = $request->input('unidades', []);

        foreach ($ingredientes as $key => $nombreIngrediente) {
            if (!empty($nombreIngrediente) && isset($cantidades[$key])) {
                $ingrediente = Ingrediente::firstOrCreate(['nombre' => $nombreIngrediente]);
                
                $datosAdjuntos = [
                    'cantidad' => $cantidades[$key]
                ];
                
                if (isset($unidades[$key])) {
                    $datosAdjuntos['unidad'] = $unidades[$key];
                }
                
                $receta->ingredientes()->attach($ingrediente->id, $datosAdjuntos);
            }
        }
    
        // Actualizar pasos
        $receta->pasos()->delete(); 
        $pasos = $request->input('pasos');
        
        foreach ($pasos as $orden => $descripcion) {
            if (!empty(trim($descripcion))) {
                $receta->pasos()->create([
                    'descripcion' => trim($descripcion),
                    'orden' => $orden + 1
                ]);
            }
        }
    
        return redirect()->route('recetas.show', $receta)
                        ->with('success', 'Receta actualizada correctamente.');
    }

    public function destroy(Receta $receta)
    {
        if (Auth::id() != $receta->user_id) {
            return redirect()->route('recetas.show', $receta)
                ->with('error', 'No tienes permiso para eliminar esta receta');
        }
        
        $receta->delete();
        
        return redirect()->route('home')
                        ->with('success', 'Receta eliminada correctamente.');
    }

    public function favorite(Receta $receta)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        if ($user->recetasFavoritas()->where('receta_id', $receta->id)->exists()) {
            $user->recetasFavoritas()->detach($receta->id);
            $message = 'Receta eliminada de favoritos.';
        } else {
            $user->recetasFavoritas()->attach($receta->id);
            $message = 'Receta añadida a favoritos.';
        }

        return back()->with('success', $message);
    }

    public function rate(Request $request, Receta $receta)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'puntuacion' => 'required|integer|between:1,5',
        ]);

        $user = Auth::user();
        
        $valoracion = $receta->valoraciones()->updateOrCreate(
            ['user_id' => $user->id],
            ['puntuacion' => $request->puntuacion]
        );

        return back()->with('success', 'Tu valoración ha sido registrada.');
    }

    // Nuevo método para manejar valoración con comentario
    public function storeRatingWithComment(Request $request, Receta $receta)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'contenido' => 'required|string|max:1000',
            'puntuacion' => 'nullable|integer|between:1,5',
        ]);

        $user = Auth::user();
        
        // Crear o actualizar comentario
        $comentario = $receta->comentarios()->create([
            'user_id' => $user->id,
            'contenido' => $request->contenido,
            'fecha' => now()
        ]);

        // Si se proporcionó valoración, crearla o actualizarla
        if ($request->filled('puntuacion')) {
            $receta->valoraciones()->updateOrCreate(
                ['user_id' => $user->id],
                ['puntuacion' => $request->puntuacion]
            );
            
            $message = 'Tu comentario y valoración han sido publicados.';
        } else {
            $message = 'Tu comentario ha sido publicado.';
        }

        return back()->with('success', $message);
    }
}