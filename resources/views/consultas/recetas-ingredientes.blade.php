<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recetas por Número de Ingredientes</title>
    <style>
        body {
            background-image: url('/images/num_ing.jpg');
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
        <h1 class="mb-4">Buscar por número de ingredientes</h1>
        
        <div class="mb-4">
            <a href="{{ route('consultas.index') }}" class="btn btn-secondary">
                Volver a Consultas
            </a>
        </div>

        <form action="{{ route('consultas.recetas-ingredientes') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-10">

                    <div class="form-group">
                        <label for="num_ingredientes">Número mínimo de ingredientes:</label>
                        <input type="number" class="form-control" id="num_ingredientes" name="num_ingredientes" 
                               min="1" value="{{ request('num_ingredientes') }}" required>
                    </div>

                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Buscar</button>
                </div>
            </div>
        </form>

        @if(isset($recetas))
            @if($recetas->isEmpty())

                <div class="alert alert-info">
                    No se encontraron recetas con el número de ingredientes especificado.
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
                                        Número de ingredientes: {{ $receta->ingredientes_count }}
                                    </p>

                                    <p class="card-text">
                                        <small class="text-muted">
                                            Ingredientes: {{ $receta->ingredientes->pluck('nombre')->implode(', ') }}
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
