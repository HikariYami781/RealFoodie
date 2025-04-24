<?php

namespace App\Http\Controllers;

use App\Models\Ingrediente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IngredienteController extends Controller
{
    /**
     * Summary of index
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {   
        $ingredientes = Ingrediente::withCount('recetas')->paginate(20);
        return view('ingredientes.index', compact('ingredientes'));
    }
    /**
     * Summary of create
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('ingredientes.create');
    }

    /**
     * Summary of store
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|unique:ingredientes|max:50|min:2'
        ]);
    
        Ingrediente::create($data);
        return redirect()->route('ingredientes.index')
            ->with('success', 'Ingrediente creado correctamente');
    }

    /**
     * Summary of show
     * @param \App\Models\Ingrediente $ingrediente
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Ingrediente $ingrediente)
    {
        $recetas = $ingrediente->recetas()
            ->with('user')  
            ->paginate(5);
    
        return view('ingredientes.show', compact('ingrediente', 'recetas'));
    }

    /**
     * Summary of edit
     * @param \App\Models\Ingrediente $ingrediente
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Ingrediente $ingrediente)
    {
        return view('ingredientes.edit', compact('ingrediente'));
    }

    /**
     * Summary of update
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Ingrediente $ingrediente
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Ingrediente $ingrediente)
    {
        $data = $request->validate([
            'nombre' => 'required|unique:ingredientes,nombre,'.$ingrediente->id.'|max:50|min:2'
        ]);
    
        $ingrediente->update($data);
        return redirect()->route('ingredientes.index')
            ->with('success', 'Ingrediente actualizado correctamente');
    }

    /**
     * Summary of destroy
     * @param \App\Models\Ingrediente $ingrediente
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Ingrediente $ingrediente)
    {
        $ingrediente->delete();
        return redirect()->route('ingredientes.index');
    }
    /**
     * Summary of ingredientesPopulares
     * @return \Illuminate\Contracts\View\View
     */
    public function ingredientesPopulares()
    {
        $ingredientes = Ingrediente::select([
            'ingredientes.id',
            'ingredientes.nombre',
            'ingredientes.created_at',
            'ingredientes.updated_at',
            DB::raw('COUNT(receta_ingrediente.receta_id) as recetas_count')
        ])
        ->leftJoin('receta_ingrediente', 'ingredientes.id', '=', 'receta_ingrediente.ingrediente_id')
        ->groupBy('ingredientes.id', 'ingredientes.nombre', 'ingredientes.created_at', 'ingredientes.updated_at')
        ->orderByDesc('recetas_count')
        ->paginate(5);
        
        return view('consultas.ingredientes-populares', compact('ingredientes'));
    }
}
