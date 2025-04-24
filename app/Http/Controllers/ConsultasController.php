<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\User;
use App\Models\Ingrediente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsultasController extends Controller
{
    /**
     * 
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('consultas.index');
    }

    /**
     * Summary of recetasPorFecha
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function recetasPorFecha(Request $request)
    {
        if (!$request->has('fecha_inicio') || !$request->has('fecha_fin')) {
            return view('consultas.recetas-fecha');
        }

        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
        ]);

        $recetas = Receta::whereBetween('created_at', [
                $request->fecha_inicio . ' 00:00:00',
                $request->fecha_fin . ' 23:59:59'
            ])
            ->with(['user', 'ingredientes'])
            ->orderBy('created_at', 'DESC')
            ->paginate(5);

        return view('consultas.recetas-fecha', compact('recetas'));
    }

    /**
     * 
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function recetasPorIngredientes(Request $request)
    {
        if (!$request->has('num_ingredientes')) {
            return view('consultas.recetas-ingredientes');
        }

        $request->validate([
            'num_ingredientes' => 'required|integer|min:1'
        ]);

        $recetas = Receta::withCount('ingredientes')
            ->having('ingredientes_count', '>=', $request->num_ingredientes)
            ->with(['user', 'ingredientes'])
            ->orderBy('ingredientes_count', 'DESC')
            ->paginate(5);

        return view('consultas.recetas-ingredientes', compact('recetas'));
    }

    /**
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function usuariosActivos()
    {
        $usuarios = User::withCount('recetas')
            ->having('recetas_count', '>', 0)
            ->orderBy('recetas_count', 'DESC')
            ->paginate(10);

        return view('consultas.usuarios-activos', compact('usuarios'));
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
    
    /**
     * Summary of buscarPorIngredientes
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function buscarPorIngredientes(Request $request)
    {
        if (!$request->has('ingredientes')) {
            return view('consultas.recetas-por-ingredientes');
        }

        // Convierte la cadena de ingredientes en un array
        $ingredientes = array_map('trim', explode(',', $request->ingredientes));

        $recetas = Receta::whereHas('ingredientes', function($query) use ($ingredientes) {
                $query->whereIn('nombre', $ingredientes);
            }, '>=', count($ingredientes))
            ->with(['user', 'ingredientes'])
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('consultas.recetas-por-ingredientes', compact('recetas'));
    }
}