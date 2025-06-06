<?php
namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Ingrediente;
use App\Models\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RecetaController extends Controller
{
    public function index()
    {
        // Cargamos las recetas públicas con sus relaciones
        $recetas = Receta::where('publica', true)
                ->orderBy('fecha_publicacion', 'desc')
                ->with(['user', 'categoria', 'valoraciones', 'ingredientes']) // Agregar ingredientes
                ->paginate(6);
        
        // Si el usuario está autenticado, verificamos qué recetas son favoritas
        if (Auth::check()) {
            $favoritasIds = DB::table('favoritos')
                ->where('user_id', Auth::id())
                ->pluck('receta_id')
                ->toArray();
                
            return view('index', compact('recetas', 'favoritasIds'));
        }
        
        return view('index', compact('recetas'));
    }
    

    public function search(Request $request)
    {
        $query = trim($request->input('query'));
        
        if (empty($query)) {
            return $this->index();
        }
        
        $recetas = Receta::where(function($q) use ($query) {
                // Búsqueda exacta en título
                $q->where('titulo', 'LIKE', '%' . $query . '%')
                  // Búsqueda exacta en ingredientes
                  ->orWhereHas('ingredientes', function($ingredienteQuery) use ($query) {
                      $ingredienteQuery->where('nombre', 'LIKE', '%' . $query . '%');
                  });
            })
            ->where('publica', true)
            ->with(['user', 'categoria', 'valoraciones', 'ingredientes'])
            ->orderBy('fecha_publicacion', 'desc')
            ->paginate(6)
            ->appends(['query' => $query]);
        
        if (Auth::check()) {
            $favoritasIds = DB::table('favoritos')
                ->where('user_id', Auth::id())
                ->pluck('receta_id')
                ->toArray();
                
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
        if (!File::exists(public_path('images/recetas'))) {
            File::makeDirectory(public_path('images/recetas'), 0755, true);
        }

        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'pasos.*' => 'required|string',
            'ingredientes.*' => 'required|string',
            'cantidades.*' => 'required|numeric|min:0.01',  
            'unidades.*' => 'nullable|string|max:20',
            'dificultad' => 'required|string',
            'preparacion' => 'required|integer|min:1|max:1440',
            'coccion' => 'required|integer|min:0|max:1440',     
            'categoria_id' => 'required|exists:categorias,id',
            'porciones' => 'required|integer|min:1',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'titulo.required' => 'El título es obligatorio.',
            'titulo.max' => 'El título no puede exceder 255 caracteres.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'pasos.*.required' => 'Todos los pasos son obligatorios.',
            'ingredientes.*.required' => 'Todos los ingredientes son obligatorios.',
            'cantidades.*.required' => 'Todas las cantidades son obligatorias.',
            'cantidades.*.numeric' => 'Las cantidades deben ser números válidos.',
            'cantidades.*.min' => 'Las cantidades deben ser mayor a 0.',
            'unidades.*.max' => 'Las unidades no pueden exceder 20 caracteres.',
            'dificultad.required' => 'La dificultad es obligatoria.',
            'preparacion.required' => 'El tiempo de preparación es obligatorio.',
            'preparacion.integer' => 'El tiempo de preparación debe ser un número entero de minutos.',
            'preparacion.min' => 'El tiempo de preparación debe ser al menos 1 minuto.',
            'preparacion.max' => 'El tiempo de preparación no puede exceder 1440 minutos (24 horas).',
            'coccion.required' => 'El tiempo de cocción es obligatorio.',
            'coccion.integer' => 'El tiempo de cocción debe ser un número entero de minutos.',
            'coccion.max' => 'El tiempo de cocción no puede exceder 1440 minutos (24 horas).',
            'categoria_id.required' => 'La categoría es obligatoria.',
            'categoria_id.exists' => 'La categoría seleccionada no es válida.',
            'porciones.required' => 'El número de porciones es obligatorio.',
            'porciones.integer' => 'El número de porciones debe ser un número entero.',
            'porciones.min' => 'Debe haber al menos 1 porción.',
            'imagen.image' => 'El archivo debe ser una imagen.',
            'imagen.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, gif.',
            'imagen.max' => 'La imagen no puede ser mayor a 2MB.',
        ]);

        try {
            DB::beginTransaction();

            // Crear receta principal
            $receta = Receta::create([
                'titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'dificultad' => $request->dificultad,
                'preparacion' => (int) $request->preparacion,  
                'coccion' => (int) $request->coccion,          
                'categoria_id' => $request->categoria_id,
                'porciones' => $request->porciones,      
                'user_id' => auth()->id(),
                'publica' => true, 
                'fecha_publicacion' => now()
            ]);

            // Procesar imagen
            if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
                try {
                    $imagen = $request->file('imagen');
                    $nombreImagen = 'receta_' . $receta->id . '_' . time() . '.' . $imagen->getClientOriginalExtension();
                    
                    $rutaDestino = public_path('images/recetas');
                    $imagen->move($rutaDestino, $nombreImagen);
                    
                    if (File::exists(public_path('images/recetas/' . $nombreImagen))) {
                        $receta->imagen = 'images/recetas/' . $nombreImagen;
                        $receta->save();
                    } else {
                        throw new \Exception('Error al guardar la imagen en el servidor');
                    }
                } catch (\Exception $e) {
                    \Log::error('Error al subir imagen de receta: ' . $e->getMessage());
                }
            }

            $ingredientes = $request->input('ingredientes');
            $cantidades = $request->input('cantidades');
            $unidades = $request->input('unidades');

            foreach ($ingredientes as $index => $nombre) {
                $nombreLimpio = trim($nombre);
                $cantidadLimpia = isset($cantidades[$index]) ? trim($cantidades[$index]) : '';
                
                if (!empty($nombreLimpio) && !empty($cantidadLimpia)) {
                    // Validar que la cantidad sea un número válido y mayor a 0
                    $cantidadNumerica = floatval($cantidadLimpia);
                    
                    if ($cantidadNumerica <= 0) {
                        throw new \Exception("La cantidad para el ingrediente '{$nombreLimpio}' debe ser mayor a 0.");
                    }
                    
                    $ingrediente = Ingrediente::firstOrCreate(['nombre' => $nombreLimpio]);

                    $receta->ingredientes()->attach($ingrediente->id, [
                        'cantidad' => $cantidadNumerica,
                        'unidad' => isset($unidades[$index]) && !empty(trim($unidades[$index])) ? trim($unidades[$index]) : null,
                    ]);
                }
            }

            // Verificar que se guardó al menos un ingrediente
            if ($receta->ingredientes()->count() === 0) {
                throw new \Exception('Debe agregar al menos un ingrediente válido.');
            }

            // Guardar pasos
            if ($request->filled('pasos')) {
                $pasos = $request->input('pasos');
                
                // Filtrar pasos vacíos y eliminar duplicados
                $pasosLimpios = [];
                foreach ($pasos as $descripcion) {
                    $descripcionLimpia = trim($descripcion);
                    if (!empty($descripcionLimpia) && !in_array($descripcionLimpia, $pasosLimpios)) {
                        $pasosLimpios[] = $descripcionLimpia;
                    }
                }
                
                // Verificar que hay al menos un paso
                if (empty($pasosLimpios)) {
                    throw new \Exception('Debe agregar al menos un paso válido.');
                }
                
                // Guardar solo los pasos únicos y no vacíos
                foreach ($pasosLimpios as $orden => $descripcion) {
                    $receta->pasos()->create([
                        'descripcion' => $descripcion,
                        'orden' => $orden + 1,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('home')->with('success', 'Receta creada con éxito');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            if (isset($receta)) {
                if ($receta->imagen && File::exists(public_path($receta->imagen))) {
                    File::delete(public_path($receta->imagen));
                }
                $receta->delete();
            }
            
            return back()->withErrors(['error' => 'Error al crear la receta: ' . $e->getMessage()])
                       ->withInput();
        }
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
        
        // Validación 
        $request->validate([
			'titulo' => 'required|max:255',
			'descripcion' => 'required',
			'ingredientes' => 'required|array|min:1', 
			'ingredientes.*' => 'required|string|min:1', 
			'cantidades' => 'required|array|min:1',
			'cantidades.*' => 'required|numeric|min:0.01',
			'unidades' => 'nullable|array',
			'unidades.*' => 'nullable|string|max:20',
			'pasos' => 'required|array|min:1', 
			'pasos.*' => 'required|string|min:1', 
			'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
			'preparacion' => 'required|integer|min:1|max:1440',
			'coccion' => 'required|integer|min:0|max:1440',
		], [
			'titulo.required' => 'El título es obligatorio.',
			'titulo.max' => 'El título no puede exceder 255 caracteres.',
			'descripcion.required' => 'La descripción es obligatoria.',
			'ingredientes.required' => 'Debe agregar al menos un ingrediente.',
			'ingredientes.min' => 'Debe agregar al menos un ingrediente.',
			'ingredientes.*.required' => 'El nombre del ingrediente es obligatorio.',
			'ingredientes.*.min' => 'El nombre del ingrediente no puede estar vacío.',
			'cantidades.required' => 'Las cantidades son obligatorias.',
			'cantidades.min' => 'Debe agregar al menos una cantidad.',
			'cantidades.*.required' => 'Todas las cantidades son obligatorias.',
			'cantidades.*.numeric' => 'Las cantidades deben ser números válidos.',
			'cantidades.*.min' => 'Las cantidades deben ser mayor a 0.',
			'unidades.*.max' => 'Las unidades no pueden exceder 20 caracteres.',
			'pasos.required' => 'Debe agregar al menos un paso.',
			'pasos.min' => 'Debe agregar al menos un paso.',
			'pasos.*.required' => 'La descripción del paso es obligatoria.',
			'pasos.*.min' => 'La descripción del paso no puede estar vacía.',
			'imagen.image' => 'El archivo debe ser una imagen.',
			'imagen.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, gif.',
			'imagen.max' => 'La imagen no puede ser mayor a 2MB.',
			'preparacion.required' => 'El tiempo de preparación es obligatorio.',
			'preparacion.integer' => 'El tiempo de preparación debe ser un número entero.',
			'preparacion.min' => 'El tiempo de preparación debe ser al menos 1 minuto.',
			'preparacion.max' => 'El tiempo de preparación no puede exceder 1440 minutos.',
			'coccion.required' => 'El tiempo de cocción es obligatorio.',
			'coccion.integer' => 'El tiempo de cocción debe ser un número entero.',
			'coccion.max' => 'El tiempo de cocción no puede exceder 1440 minutos.',
		]);
        
        try {
            DB::beginTransaction();

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
            
            if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
                try {
                    if ($receta->imagen && File::exists(public_path($receta->imagen))) {
                        File::delete(public_path($receta->imagen));
                    }
                    
                    $imagen = $request->file('imagen');
                    $nombreImagen = 'receta_' . $receta->id . '_' . time() . '.' . $imagen->getClientOriginalExtension();
                    
                    $rutaDestino = public_path('images/recetas');
                    $imagen->move($rutaDestino, $nombreImagen);
                    
                    if (File::exists(public_path('images/recetas/' . $nombreImagen))) {
                        $receta->imagen = 'images/recetas/' . $nombreImagen;
                        $receta->save();
                    }
                } catch (\Exception $e) {
                    \Log::error('Error al actualizar imagen de receta: ' . $e->getMessage());
                }
            }

            $receta->ingredientes()->detach();
            $ingredientes = $request->input('ingredientes');
            $cantidades = $request->input('cantidades');
            $unidades = $request->input('unidades', []);

            foreach ($ingredientes as $key => $nombreIngrediente) {
                $nombreLimpio = trim($nombreIngrediente);
                $cantidadLimpia = isset($cantidades[$key]) ? trim($cantidades[$key]) : '';
                
                if (!empty($nombreLimpio) && !empty($cantidadLimpia)) {
                    $cantidadNumerica = floatval($cantidadLimpia);
                    
                    if ($cantidadNumerica <= 0) {
                        throw new \Exception("La cantidad para el ingrediente '{$nombreLimpio}' debe ser mayor a 0.");
                    }
                    
                    $ingrediente = Ingrediente::firstOrCreate(['nombre' => $nombreLimpio]);
                    
                    $datosAdjuntos = [
                        'cantidad' => $cantidadNumerica
                    ];
                    
                    if (isset($unidades[$key]) && !empty(trim($unidades[$key]))) {
                        $datosAdjuntos['unidad'] = trim($unidades[$key]);
                    }
                    
                    $receta->ingredientes()->attach($ingrediente->id, $datosAdjuntos);
                }
            }
        
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

            DB::commit();
            return redirect()->route('recetas.show', $receta)
                            ->with('success', 'Receta actualizada correctamente.');
                            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al actualizar la receta: ' . $e->getMessage()])
                       ->withInput();
        }
    }
    

    public function destroy(Receta $receta)
    {
        if (Auth::id() != $receta->user_id) {
            return redirect()->route('recetas.show', $receta)
                ->with('error', 'No tienes permiso para eliminar esta receta');
        }
        

        if ($receta->imagen && File::exists(public_path($receta->imagen))) {
            File::delete(public_path($receta->imagen));
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
        
        $existe = DB::table('favoritos')
            ->where('user_id', $user->id)
            ->where('receta_id', $receta->id)
            ->exists();
        
        if ($existe) {
            DB::table('favoritos')
                ->where('user_id', $user->id)
                ->where('receta_id', $receta->id)
                ->delete();
            $message = 'Receta eliminada de favoritos.';
        } else {
            DB::table('favoritos')->insert([
                'user_id' => $user->id,
                'receta_id' => $receta->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $message = 'Receta añadida a favoritos.';
        }

        return back()->with('success', $message);
    }
    

    // Método para manejar valoración con comentario
    public function storeRatingWithComment(Request $request, Receta $receta)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'contenido' => 'required|string|max:1000',
            'puntuacion' => 'required|integer|between:1,5',
        ], [
            'puntuacion.required' => 'Debes valorar la receta para poder comentar.',
            'puntuacion.integer' => 'La puntuación debe ser un número entero.',
            'puntuacion.between' => 'La puntuación debe estar entre 1 y 5.',
            'contenido.required' => 'El comentario es obligatorio.',
            'contenido.max' => 'El comentario no puede exceder 1000 caracteres.',
        ]);

        $user = Auth::user();
        
        // Verificar si el usuario ya ha valorado/comentado esta receta
        $comentarioExistente = $receta->comentarios()->where('user_id', $user->id)->first();
        $valoracionExistente = $receta->valoraciones()->where('user_id', $user->id)->first();
        
        if ($comentarioExistente || $valoracionExistente) {
            return back()->with('error', 'Ya has valorado y comentado esta receta anteriormente.');
        }
        
        try {
            DB::beginTransaction();

            // Crear comentario
            $comentario = $receta->comentarios()->create([
                'user_id' => $user->id,
                'contenido' => $request->contenido,
                'fecha' => now()
            ]);

            // Crear valoración
            $receta->valoraciones()->create([
                'user_id' => $user->id,
                'puntuacion' => $request->puntuacion
            ]);

            DB::commit();
            return back()->with('success', 'Tu comentario y valoración han sido publicados.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al publicar tu comentario: ' . $e->getMessage());
        }
    }
}
