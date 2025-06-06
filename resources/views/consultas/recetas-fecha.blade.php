<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Búsqueda por Fecha</title>
    <style>
        body {
            background-image: url('/images/recetas_fecha.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 30px;
            margin-top: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Buscar recetas por fecha</h1>
        
        <div class="mb-4">
            <a href="{{ route('consultas.index') }}" class="btn btn-secondary">
                Volver a Consultas
            </a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('consultas.recetas-fecha') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="fecha_inicio">Fecha Inicio:</label>
                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" 
                               value="{{ request('fecha_inicio') }}" required>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="form-group">
                        <label for="fecha_fin">Fecha Fin:</label>
                        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" 
                               value="{{ request('fecha_fin') }}" required>
                    </div>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Buscar</button>
                </div>
            </div>
        </form>

        @if(isset($debug))
            <div class="alert alert-warning">
                <h5>Información de Debug:</h5>
                <ul>
                    <li><strong>Rango buscado:</strong> {{ $debug['fecha_inicio'] }} a {{ $debug['fecha_fin'] }}</li>
                    <li><strong>Total con whereBetween:</strong> {{ $debug['total_recetas_whereBetween'] }}</li>
                    <li><strong>Total con whereDate:</strong> {{ $debug['total_recetas_whereDate'] }}</li>
                    <li><strong>Fecha más antigua en BD:</strong> {{ $debug['min_fecha_bd'] }}</li>
                    <li><strong>Fecha más reciente en BD:</strong> {{ $debug['max_fecha_bd'] }}</li>
                    <li><strong>Total recetas en BD:</strong> {{ $debug['total_recetas_bd'] }}</li>
                </ul>
            </div>
        @endif

        @if(isset($recetas))
            <!-- Información de resultados -->
            <div class="alert alert-info">
                <strong>Resultados:</strong> 
                Se encontraron {{ $recetas->total() }} receta(s) 
                @if(request('fecha_inicio') && request('fecha_fin'))
                    entre {{ \Carbon\Carbon::parse(request('fecha_inicio'))->format('d/m/Y') }} 
                    y {{ \Carbon\Carbon::parse(request('fecha_fin'))->format('d/m/Y') }}
                @endif
                <br>
                <small>Mostrando página {{ $recetas->currentPage() }} de {{ $recetas->lastPage() }}</small>
            </div>

            @if($recetas->isEmpty())
                <div class="alert alert-warning">
                    No se encontraron recetas en el rango de fechas especificado.
                </div>
            @else
                <div class="row">
                    @foreach($recetas as $receta)
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $receta->titulo }}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        Por: {{ $receta->user->nombre }}
                                    </h6>
                                    <p class="card-text">
                                        <small class="text-muted">
                                            Creada el: {{ $receta->created_at->format('d/m/Y H:i') }}
                                        </small>
                                    </p>
                                    <a href="{{ route('recetas.show', $receta) }}" class="btn btn-primary">
                                        Ver Receta
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginación-->
                @if($recetas->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        <nav aria-label="Navegación de páginas">
                            <ul class="pagination">
                                {{-- Números de página --}}
                                @for ($i = 1; $i <= $recetas->lastPage(); $i++)
                                    @if ($i == $recetas->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $i }}</span></li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $recetas->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endif
                                @endfor
                            </ul>
                        </nav>
                    </div>
                @endif
            @endif
        @endif
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
