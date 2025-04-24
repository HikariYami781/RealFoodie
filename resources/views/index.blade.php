<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RealFoodie</title>
    <style>
        body {
            background-image: url('/images/pagina_principal.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('header')

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Recetas</h1>
            </div>

            <!-- Buscador -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <form action="{{ route('recetas.search') }}" method="GET" class="d-flex">
                        <input type="text" name="query" class="form-control me-2" 
                            placeholder="Buscar recetas por nombre..." 
                            value="{{ request('query') }}">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </form>
                </div>
            </div>

            <!-- Lista de Recetas -->
            <div class="row">
                @forelse($recetas as $receta)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <!-- Solo la imagen -->
                        @if($receta->imagen)
                            <div class="text-center p-2">
                                <img src="{{ asset('storage/' . $receta->imagen) }}" 
                                    alt="{{ $receta->titulo }}" 
                                    class="img-fluid rounded" 
                                    style="max-height: 200px; width: 100%; object-fit: cover;">
                            </div>
                        @else
                            <!-- Placeholder si no hay imagen -->
                            <div class="text-center p-2 bg-light" style="height: 200px; display: flex; align-items: center; justify-content: center;">
                                <span class="text-muted">Sin imagen</span>
                            </div>
                        @endif
                        
                        <!-- Solo el título -->
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $receta->titulo }}</h5>
                        </div>
                        
                        <!-- Botón de Ver Detalles -->
                        <div class="card-footer bg-white text-center">
                            <a href="{{ route('recetas.show', $receta->id) }}" 
                            class="btn btn-sm btn-outline-info">Ver Detalles</a>
                            
                            @if($receta->user_id == session('user_id'))
                                <a href="{{ route('recetas.edit', $receta) }}" 
                                class="btn btn-sm btn-outline-primary">Editar</a>
                                <form action="{{ route('recetas.destroy', $receta) }}" 
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('¿Estás seguro de que deseas eliminar esta receta?')">
                                        Eliminar
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            No se encontraron recetas.
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Paginación-->
            @if($recetas->total() > $recetas->perPage())
                <div class="d-flex justify-content-center mt-4">
                    <nav>
                        <ul class="pagination">
                            @for($i = 1; $i <= $recetas->lastPage(); $i++)
                                <li class="page-item {{ $recetas->currentPage() == $i ? 'active' : '' }}">
                                    <a class="page-link text-decoration-none" href="{{ $recetas->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                        </ul>
                    </nav>
                </div>
            @endif
        </div>
    </div>

    @include('footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>