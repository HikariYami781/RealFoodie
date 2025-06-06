<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\User;
use App\Models\Ingrediente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ConsultasController extends Controller
{
    /**
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
        $recetas = null;
        
        if ($request->has('fecha_inicio') && $request->has('fecha_fin')) {
            $request->validate([
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
            ]);

            // Ver qué fechas estamos recibiendo
            Log::info('Búsqueda por fechas:', [
                'fecha_inicio_raw' => $request->fecha_inicio,
                'fecha_fin_raw' => $request->fecha_fin
            ]);

            // Crear fechas con Carbon para mayor precisión
            $fechaInicio = Carbon::createFromFormat('Y-m-d', $request->fecha_inicio)->startOfDay();
            $fechaFin = Carbon::createFromFormat('Y-m-d', $request->fecha_fin)->endOfDay();
            
            Log::info('Fechas procesadas:', [
                'fecha_inicio' => $fechaInicio->format('Y-m-d H:i:s'),
                'fecha_fin' => $fechaFin->format('Y-m-d H:i:s')
            ]);

            
            $recetas = Receta::where('created_at', '>=', $fechaInicio)
                ->where('created_at', '<=', $fechaFin)
                ->with(['user', 'ingredientes'])
                ->orderBy('created_at', 'DESC')
                ->paginate(10) // Aumenté de 5 a 10 para mostrar más resultados
                ->appends($request->query()); // Importante: mantener parámetros en paginación

            
            Log::info('Resultados de búsqueda:', [
                'total_encontradas' => $recetas->total(),
                'por_pagina' => $recetas->perPage(),
                'pagina_actual' => $recetas->currentPage(),
                'total_paginas' => $recetas->lastPage(),
                'tiene_mas_paginas' => $recetas->hasMorePages()
            ]);

            
            if ($recetas->count() > 0) {
                $fechasRecetas = $recetas->pluck('created_at')->map(function($fecha) {
                    return $fecha->format('Y-m-d H:i:s');
                })->toArray();
                Log::info('Fechas de recetas encontradas:', $fechasRecetas);
            }
        }

        return view('consultas.recetas-fecha', compact('recetas'));
    }
    

    /**
     * Método alternativo para debugging - puedes usar este temporalmente
     */
    public function recetasPorFechaDebug(Request $request)
    {
        $recetas = null;
        $debug = [];
        
        if ($request->has('fecha_inicio') && $request->has('fecha_fin')) {
            $fechaInicio = $request->fecha_inicio;
            $fechaFin = $request->fecha_fin;
            
            // Contar todas las recetas en el rango
            $totalRecetas = Receta::whereBetween('created_at', [
                $fechaInicio . ' 00:00:00',
                $fechaFin . ' 23:59:59'
            ])->count();
            
            // Contar todas las recetas usando whereDate
            $totalRecetasDate = Receta::whereDate('created_at', '>=', $fechaInicio)
                ->whereDate('created_at', '<=', $fechaFin)
                ->count();
            
            // Obtener min y max fecha de toda la tabla
            $minFecha = Receta::min('created_at');
            $maxFecha = Receta::max('created_at');
            
            $debug = [
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
                'total_recetas_whereBetween' => $totalRecetas,
                'total_recetas_whereDate' => $totalRecetasDate,
                'min_fecha_bd' => $minFecha,
                'max_fecha_bd' => $maxFecha,
                'total_recetas_bd' => Receta::count()
            ];
            
            $recetas = Receta::whereBetween('created_at', [
                    $fechaInicio . ' 00:00:00',
                    $fechaFin . ' 23:59:59'
                ])
                ->with(['user'])
                ->orderBy('created_at', 'DESC')
                ->paginate(10)
                ->appends($request->query());
        }
        
        return view('consultas.recetas-fecha', compact('recetas', 'debug'));
    }

    /*
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function recetasPorIngredientes(Request $request)
    {
        $recetas = null;
        
        if ($request->has('num_ingredientes')) {
            $request->validate([
                'num_ingredientes' => 'required|integer|min:1'
            ]);

            $recetas = Receta::withCount('ingredientes')
                ->having('ingredientes_count', '>=', $request->num_ingredientes)
                ->with(['user', 'ingredientes'])
                ->orderBy('ingredientes_count', 'DESC')
                ->paginate(10) // Aumenté de 5 a 10
                ->appends($request->query());
        }

        return view('consultas.recetas-ingredientes', compact('recetas'));
    }
    

    /**
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
            ->paginate(10); // Aumenté de 5 a 10
    
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
        
		$recetas->appends($request->query());

		return view('consultas.recetas-por-ingredientes', compact('recetas'));
	}
}
