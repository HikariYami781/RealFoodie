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

        <form action="{{ route('consultas.recetas-fecha') }}" method="GET" class="mb-4">

            <div class="row">

                <div class="col-md-5">
                    <div class="form-group">
                        <label for="fecha_inicio">Fecha Inicio:</label>
                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{ request('fecha_inicio') }}" required>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="form-group">
                        <label for="fecha_fin">Fecha Fin:</label>
                        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="{{ request('fecha_fin') }}" required>
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
                                            Creada el: {{ $receta->created_at->format('d/m/Y') }}
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

                <div class="d-flex justify-content-center mt-4">
                    {{ $recetas->links('pagination::simple-bootstrap-4') }}
                </div>
                
            @endif
        @endif
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>