<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultas Avanzadas</title>
    <style>
        body {
            background-image: url('/images/consultas_avanzadas.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    
    <style>
        .hover-card {
            transition: transform 0.2s ease-in-out;
        }
        
        .hover-card:hover {
            transform: translateY(-5px);
        }

        .card {
            border-radius: 15px;
        }

        .btn {
            border-radius: 25px;
            padding: 8px 20px;
        }
    </style>
</head>
<body>
    @include('header')

    <div class="container py-5">
        <h1 class="text-center mb-5">Consultas Avanzadas</h1>

        <div class="row justify-content-center">

            <!-- Búsqueda por fecha -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm hover-card">
                    <div class="card-body text-center d-flex flex-column">
                        <div class="mb-4">
                            <i class="fas fa-calendar-alt fa-3x text-primary"></i>
                        </div>
                        <h5 class="card-title">Buscar por Fecha</h5>
                        <p class="card-text flex-grow-1">
                            Encuentra recetas publicadas en un rango de fechas específico.
                        </p>
                        <a href="{{ route('consultas.recetas-fecha') }}" class="btn btn-primary mt-auto">
                            Buscar por Fecha
                        </a>
                    </div>
                </div>
            </div>

            <!-- Búsqueda por número de ingredientes -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm hover-card">
                    <div class="card-body text-center d-flex flex-column">
                        <div class="mb-4">
                            <i class="fas fa-list-ol fa-3x text-success"></i>
                        </div>
                        <h5 class="card-title">Buscar por Cantidad de Ingredientes</h5>
                        <p class="card-text flex-grow-1">
                            Encuentra recetas según la cantidad de ingredientes que contienen.
                        </p>
                        <a href="{{ route('consultas.recetas-ingredientes') }}" class="btn btn-success mt-auto">
                            Buscar por Cantidad
                        </a>
                    </div>
                </div>
            </div>

            <!-- Búsqueda por ingredientes específicos -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm hover-card">
                    <div class="card-body text-center d-flex flex-column">
                        <div class="mb-4">
                            <i class="fas fa-search fa-3x text-info"></i>
                        </div>
                        <h5 class="card-title">Buscar por Ingredientes Específicos</h5>
                        <p class="card-text flex-grow-1">
                            Encuentra recetas que contengan ingredientes específicos.
                        </p>
                        <a href="{{ route('consultas.recetas-por-ingredientes') }}" class="btn btn-info mt-auto">
                            Buscar por Ingredientes
                        </a>
                    </div>
                </div>
            </div>

            <!-- Usuarios más activos -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm hover-card">
                    <div class="card-body text-center d-flex flex-column">
                        <div class="mb-4">
                            <i class="fas fa-users fa-3x text-warning"></i>
                        </div>
                        <h5 class="card-title">Usuarios más Activos</h5>
                        <p class="card-text flex-grow-1">
                            Descubre los usuarios que más recetas han compartido.
                        </p>
                        <a href="{{ route('consultas.usuarios-activos') }}" class="btn btn-warning mt-auto">
                            Ver Usuarios Activos
                        </a>
                    </div>
                </div>
            </div>

            <!-- Ingredientes populares -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm hover-card">
                    <div class="card-body text-center d-flex flex-column">
                        <div class="mb-4">
                            <i class="fas fa-star fa-3x text-danger"></i>
                        </div>
                        <h5 class="card-title">Ingredientes Populares</h5>
                        <p class="card-text flex-grow-1">
                            Descubre los ingredientes más utilizados en las recetas.
                        </p>
                        <a href="{{ route('consultas.ingredientes-populares') }}" class="btn btn-danger mt-auto">
                            Ver Ingredientes Populares
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>