<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingredientes Populares</title>
    <style>
        body {
            background-image: url('/images/ing_fam.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 10px;
            margin-top: 80px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        

        
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Ingredientes más populares</h1>
        
        <div class="mb-4">
            <a href="{{ route('consultas.index') }}" class="btn btn-secondary">
                Volver a Consultas
            </a>
        </div>

        @if(!isset($ingredientes) || $ingredientes->isEmpty())
            <div class="alert alert-info">
                No se encontraron ingredientes registrados.
            </div>
        @else

            <div class="table-responsive">
                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th>Ingrediente</th>
                            <th class="text-center">Usado en recetas</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($ingredientes as $ingrediente)
                            <tr>
                                <td class="align-middle">{{ $ingrediente->nombre }}</td>
                                <td class="text-center align-middle">{{ $ingrediente->recetas_count }}</td>
                                <td class="text-end">
                                    <a href="{{ route('ingredientes.show', $ingrediente->id) }}" 
                                       class="btn btn-primary btn-sm">
                                        Ver Detalles
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

           <!-- Paginación -->
                @if($ingredientes->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        <nav aria-label="Navegación de páginas">
                            <ul class="pagination">
                                {{-- Números de página --}}
                                @for ($i = 1; $i <= $ingredientes->lastPage(); $i++)
                                    @if ($i == $ingredientes->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $i }}</span></li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $ingredientes->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endif
                                @endfor
                            </ul>
                        </nav>
                    </div>
                @endif
        @endif
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
