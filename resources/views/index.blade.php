<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                        
                        <!-- Botones de acción -->
                        <div class="card-footer bg-white">
                            <div class="row">
                                <div class="col-6 text-start">
                                    <!-- Botón de favoritos -->
                                    @auth
                                        <form action="{{ route('recetas.favorite', $receta) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm {{ Auth::user()->recetasFavoritas->contains($receta->id) ? 'text-danger' : 'text-secondary' }}" title="{{ Auth::user()->recetasFavoritas->contains($receta->id) ? 'Quitar de favoritos' : 'Añadir a favoritos' }}">
                                                <i class="fas fa-heart"></i>
                                            </button>
                                        </form>
                                        
                                        <!-- Botón para añadir a colección (Muestra modal) -->
                                        <button type="button" class="btn btn-sm text-secondary" title="Añadir a colección" data-bs-toggle="modal" data-bs-target="#coleccionModal{{ $receta->id }}">
                                            <i class="fas fa-plus-circle"></i>
                                        </button>
                                    @endauth
                                </div>
                                
                                <div class="col-6 text-end">
                                    <a href="{{ route('recetas.show', $receta->id) }}" 
                                    class="btn btn-sm btn-outline-info">Ver Detalles</a>
                                    
                                    @if(Auth::check() && $receta->user_id == Auth::id())
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
                        
                        <!-- Modal para añadir a colección -->
                        @auth
                        <div class="modal fade" id="coleccionModal{{ $receta->id }}" tabindex="-1" aria-labelledby="coleccionModalLabel{{ $receta->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="coleccionModalLabel{{ $receta->id }}">Añadir "{{ $receta->titulo }}" a una colección</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        @if(Auth::user()->colecciones->count() > 0)
                                            <form id="addToCollectionForm{{ $receta->id }}">
                                                <div class="mb-3">
                                                    <select class="form-select" id="coleccion_select{{ $receta->id }}">
                                                        <option selected disabled>Seleccione una colección</option>
                                                        @foreach(Auth::user()->colecciones as $coleccion)
                                                            <option value="{{ $coleccion->id }}">{{ $coleccion->nombre }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </form>
                                            <div class="text-center">
                                                <button type="button" class="btn btn-primary" onclick="addToCollection({{ $receta->id }})">Añadir</button>
                                            </div>
                                        @else
                                            <div class="alert alert-info">
                                                No tienes colecciones. <a href="{{ route('colecciones.create') }}">Crea una nueva colección</a>.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endauth
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
    
    <script>
    function addToCollection(recetaId) {
        const coleccionId = document.getElementById('coleccion_select' + recetaId).value;
        if (!coleccionId) {
            alert('Por favor, selecciona una colección');
            return;
        }
        
        // Crear formulario y enviarlo
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/colecciones/' + coleccionId + '/recetas';
        
        // CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
        
        // Receta ID
        const receta = document.createElement('input');
        receta.type = 'hidden';
        receta.name = 'receta_id';
        receta.value = recetaId;
        
        form.appendChild(csrfToken);
        form.appendChild(receta);
        document.body.appendChild(form);
        form.submit();
    }
    </script>
</body>
</html>