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
        .max-height-200 {
            max-height: 200px;
        }
        .overflow-auto {
            overflow-y: auto;
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
                                            <button type="submit" class="btn btn-sm text-danger" title="Favorito">
                                                @if(isset($favoritasIds) && in_array($receta->id, $favoritasIds))
                                                    <i class="fas fa-heart"></i>
                                                @else
                                                    <i class="far fa-heart"></i>
                                                @endif
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-sm text-secondary" title="Favorito (Requiere login)">
                                            <i class="far fa-heart"></i>
                                        </a>
                                    @endauth
                                        
                                    <!-- Botón para añadir a colección (Muestra modal) -->
                                    @auth
                                        @php
                                            $enColeccion = false;
                                            if(Auth::user()->colecciones) {
                                                foreach(Auth::user()->colecciones as $coleccion) {
                                                    if($coleccion->recetas->contains($receta->id)) {
                                                        $enColeccion = true;
                                                        break;
                                                    }
                                                }
                                            }
                                        @endphp
                                        
                                        <button type="button" class="btn btn-sm {{ $enColeccion ? 'text-success' : 'text-secondary' }}" 
                                                title="{{ $enColeccion ? 'Ya está en una colección' : 'Añadir a colección' }}" 
                                                data-bs-toggle="modal" data-bs-target="#coleccionModal{{ $receta->id }}">
                                            @if($enColeccion)
                                                <i class="fas fa-check-circle"></i>
                                            @else
                                                <i class="fas fa-plus-circle"></i>
                                            @endif
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
                                        <h5 class="modal-title" id="coleccionModalLabel{{ $receta->id }}">Gestionar "{{ $receta->titulo }}" en colecciones</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Sección para crear nueva colección -->
                                        <div class="mb-4">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="mb-0">Crear nueva colección de Recetas:</h6>
                                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="toggleCrearColeccion({{ $receta->id }})">
                                                    <i class="fas fa-plus"></i> Nueva
                                                </button>
                                            </div>
                                            
                                            <!-- Formulario para crear colección (inicialmente oculto) -->
                                            <div id="formCrearColeccion{{ $receta->id }}" style="display: none;">
                                                <div class="card border-primary">
                                                    <div class="card-body p-3">
                                                        <form id="nuevaColeccionForm{{ $receta->id }}">
                                                            <div class="mb-3">
                                                                <label for="nombreColeccion{{ $receta->id }}" class="form-label">Nombre de la colección:</label>
                                                                <input type="text" class="form-control" id="nombreColeccion{{ $receta->id }}" 
                                                                       placeholder="Ej: Mis favoritas, Postres, etc." required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="descripcionColeccion{{ $receta->id }}" class="form-label">Descripción (opcional):</label>
                                                                <textarea class="form-control" id="descripcionColeccion{{ $receta->id }}" 
                                                                          rows="2" placeholder="Describe tu colección..."></textarea>
                                                            </div>
                                                            <div class="d-flex gap-2">
                                                                <button type="button" class="btn btn-primary btn-sm" 
                                                                        onclick="crearYAñadirColeccion({{ $receta->id }})">
                                                                    <i class="fas fa-save"></i> Crear y Añadir Receta
                                                                </button>
                                                                <button type="button" class="btn btn-secondary btn-sm" 
                                                                        onclick="toggleCrearColeccion({{ $receta->id }})">
                                                                    Cancelar
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Separador -->
                                        @if(Auth::user()->colecciones->count() > 0)
                                            <hr class="my-3">
                                        @endif

                                        <!-- Colecciones existentes -->
                                        @if(Auth::user()->colecciones->count() > 0)
                                            <div class="mb-3">
                                                <h6>Colecciones existentes:</h6>
                                                <div class="max-height-200 overflow-auto">
                                                    @foreach(Auth::user()->colecciones as $coleccion)
                                                        @php
                                                            $tieneReceta = $coleccion->recetas->contains($receta->id);
                                                        @endphp
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox" 
                                                                   id="coleccion{{ $coleccion->id }}_receta{{ $receta->id }}"
                                                                   {{ $tieneReceta ? 'checked' : '' }}
                                                                   onchange="toggleRecetaEnColeccion({{ $receta->id }}, {{ $coleccion->id }}, this.checked)">
                                                            <label class="form-check-label d-flex align-items-center justify-content-between" 
                                                                   for="coleccion{{ $coleccion->id }}_receta{{ $receta->id }}">
                                                                <span>
                                                                    {{ $coleccion->nombre }}
                                                                    @if($coleccion->descripcion)
                                                                        <small class="text-muted d-block">{{ Str::limit($coleccion->descripcion, 50) }}</small>
                                                                    @endif
                                                                </span>
                                                                @if($tieneReceta)
                                                                    <i class="fas fa-check-circle text-success"></i>
                                                                @endif
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @else
                                            <div class="alert alert-info">
                                                <i class="fas fa-info-circle"></i> 
                                                No tienes colecciones aún. ¡Crea tu primera colección arriba!
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
    function toggleCrearColeccion(recetaId) {
        const form = document.getElementById('formCrearColeccion' + recetaId);
        if (form.style.display === 'none') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
            // Limpiar el formulario al cerrar
            document.getElementById('nombreColeccion' + recetaId).value = '';
            document.getElementById('descripcionColeccion' + recetaId).value = '';
        }
    }

    function crearYAñadirColeccion(recetaId) {
        const nombre = document.getElementById('nombreColeccion' + recetaId).value.trim();
        const descripcion = document.getElementById('descripcionColeccion' + recetaId).value.trim();
        
        if (!nombre) {
            alert('Por favor, ingresa un nombre para la colección');
            return;
        }
        
        // Crear formulario para crear la colección
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/colecciones';
        
        // CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
        
        // Nombre de la colección
        const nombreInput = document.createElement('input');
        nombreInput.type = 'hidden';
        nombreInput.name = 'nombre';
        nombreInput.value = nombre;
        
        // Descripción de la colección
        const descripcionInput = document.createElement('input');
        descripcionInput.type = 'hidden';
        descripcionInput.name = 'descripcion';
        descripcionInput.value = descripcion;
        
        // ID de la receta para añadir automáticamente
        const recetaInput = document.createElement('input');
        recetaInput.type = 'hidden';
        recetaInput.name = 'receta_id';
        recetaInput.value = recetaId;
        
        // Campo para indicar que queremos añadir la receta automáticamente
        const autoAddInput = document.createElement('input');
        autoAddInput.type = 'hidden';
        autoAddInput.name = 'add_recipe_automatically';
        autoAddInput.value = '1';
        
        form.appendChild(csrfToken);
        form.appendChild(nombreInput);
        form.appendChild(descripcionInput);
        form.appendChild(recetaInput);
        form.appendChild(autoAddInput);
        
        document.body.appendChild(form);
        form.submit();
    }

    function toggleRecetaEnColeccion(recetaId, coleccionId, agregar) {
        const form = document.createElement('form');
        form.method = 'POST';
        
        if (agregar) {
            form.action = '/colecciones/' + coleccionId + '/recetas';
        } else {
            form.action = '/colecciones/' + coleccionId + '/recetas/' + recetaId;
            // Añadir método DELETE para quitar de colección
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            form.appendChild(methodField);
        }
        
        // CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
        
        // Receta ID (solo si es para agregar)
        if (agregar) {
            const receta = document.createElement('input');
            receta.type = 'hidden';
            receta.name = 'receta_id';
            receta.value = recetaId;
            form.appendChild(receta);
        }
        
        form.appendChild(csrfToken);
        document.body.appendChild(form);
        form.submit();
    }

    // Función legacy mantenida por compatibilidad
    function addToCollection(recetaId) {
        const coleccionId = document.getElementById('coleccion_select' + recetaId).value;
        if (!coleccionId) {
            alert('Por favor, selecciona una colección');
            return;
        }
        
        toggleRecetaEnColeccion(recetaId, coleccionId, true);
    }
    </script>
</body>
</html>