<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RealFoodie - {{ $receta->titulo }}</title> <!--Pongo esto para que en la pestaña salga el nombre de la receta-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
         body {
            background-image: url('/images/show_recetas.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        
        .card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        
        .comentario {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    @include('header')

    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">

                <!-- Mensaje de éxito/error -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                
                <!--Receta-->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <h1 class="card-title">{{ $receta->titulo }}</h1>
                            

                            <!-- Imagen-->
                            @if($receta->imagen)
                                <div class="ms-3">
                                    <img src="{{ asset('storage/' . $receta->imagen) }}" 
                                        alt="{{ $receta->titulo }}" 
                                        class="img-fluid rounded" 
                                        style="max-width: 300px; max-height: 200px;">
                                </div>
                            @endif

                        </div>

                        
                        <div class="mb-3">
                            <h5>Autor</h5>
                            <p>{{ $receta->user->name }}</p>
                        </div>


                        <div class="mb-4">
                            <h4>Descripción</h4>
                            <p class="card-text">{{ $receta->descripcion }}</p>
                        </div>


                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h5>Tiempo de Preparación</h5>
                                    <p>{{ $receta->preparacion }} minutos</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h5>Tiempo de Cocción</h5>
                                    <p>{{ $receta->coccion }} minutos</p>
                                </div>
                            </div>
                        </div>


                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <h5>Dificultad</h5>
                                    <p>
                                        @switch($receta->dificultad)
                                            @case(1)
                                                Muy fácil
                                                @break
                                            @case(2)
                                                Fácil
                                                @break
                                            @case(3)
                                                Media
                                                @break
                                            @case(4)
                                                Difícil
                                                @break
                                            @case(5)
                                                Muy difícil
                                                @break
                                            @default
                                                No especificada
                                        @endswitch
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <h5>Porciones</h5>
                                    <p>{{ $receta->porciones }}</p>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <h5>Categoría</h5>
                                    <p>{{ $receta->categoria->nombre ?? 'Sin categoría' }}</p>
                                </div>
                            </div>

                        </div>

                        <div class="mb-4">
                            <h4>Ingredientes</h4>
                            <ul class="list-group list-group-flush">
                                @foreach($receta->ingredientes as $ingrediente)
                                <li class="list-group-item">
                                    <strong>{{ $ingrediente->nombre }}</strong> - 
                                    {{ $ingrediente->pivot->cantidad }}
                                    {{ $ingrediente->pivot->unidad ?? '' }}
                                </li>
                                @endforeach
                            </ul>
                        </div>


                        
                        <h3>Instrucciones</h3>
                        <div class="mt-3">
                            @forelse($receta->pasos->sortBy('orden') as $paso)
                                <div class="mb-3">
                                    <strong>Paso {{ $paso->orden }}:</strong> {{ $paso->descripcion }}
                                </div>
                            @empty
                                <p>No hay instrucciones disponibles para esta receta.</p>
                            @endforelse
                        </div>


                        <!-- Botones-->
                        <div class="mt-4">
                            <a href="{{ route('home') }}" class="btn btn-secondary">Volver al listado</a>
                            
                            @if(Auth::check() && Auth::id() == $receta->user_id)
                                <a href="{{ route('recetas.edit', $receta) }}" class="btn btn-primary">Editar</a>
                                
                                <form action="{{ route('recetas.destroy', $receta) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta receta?')">
                                        Eliminar
                                    </button>
                                </form>
                            @endif
                        </div>

                    </div>
                </div>
                
                <!-- Comentarios -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h3>Comentarios ({{ $receta->comentarios->count() }})</h3>                        

                        <!-- Formulario comentario (usuarios autenticados) -->
                        @auth
                            <form action="{{ route('comentarios.store', $receta) }}" method="POST" class="mb-4">
                                @csrf
                                <div class="form-group">
                                    <label for="contenido">Deja tu comentario:</label>
                                    <textarea name="contenido" id="contenido" rows="3" class="form-control @error('contenido') is-invalid @enderror" required>{{ old('contenido') }}</textarea>
                                    @error('contenido')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary mt-2">Publicar comentario</button>
                            </form>
                        @else
                            <div class="alert alert-info">
                                <a href="{{ route('login') }}">Inicia sesión</a> para dejar un comentario.
                            </div>
                        @endauth
                        

                        <!-- Lista comentarios -->
                         <div class="comentarios-lista mt-4">
                            @forelse($receta->comentarios->sortByDesc('fecha') as $comentario)
                                <div class="comentario mb-3 p-3 border rounded bg-light">
                                    <div class="d-flex justify-content-between">
                                        <h5><a href="{{ route('users.show', $comentario->user) }}" class="text-decoration-none">{{ $comentario->user->nombre }}</a></h5>
                                        <small class="text-muted">{{ $comentario->fecha->format('d/m/Y H:i') }}</small>
                                    </div>
                                    
                                    <div id="comentario-content-{{ $comentario->id }}">
                                            <p>{{ $comentario->contenido }}</p>
                                    </div>

                                    <div id="comentario-edit-{{ $comentario->id }}" style="display: none;">
                                        <form action="{{ route('comentarios.update', $comentario) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <textarea name="contenido" class="form-control" rows="2" required>{{ $comentario->contenido }}</textarea>
                                            </div>
                                            <div class="mt-2">
                                                <button type="submit" class="btn btn-sm btn-success">Guardar</button>
                                                <button type="button" class="btn btn-sm btn-secondary" onclick="toggleEditComment({{ $comentario->id }})">Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                    
                                    <!-- Opciones para el comentario-->
                                    @auth
                                        @if(Auth::id() == $comentario->user_id)
                                            <div class="mt-2 text-end">
                                                <button class="btn btn-sm btn-outline-primary" onclick="toggleEditComment({{ $comentario->id }})">
                                                    Editar
                                                </button>
                                                <form action="{{ route('comentarios.destroy', $comentario) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                            onclick="return confirm('¿Estás seguro de que quieres eliminar este comentario?')">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    @endauth
                                    
                                </div>

                            @empty
                                <p class="text-muted">Aún no hay comentarios. ¡Sé el primero!</p>
                            @endforelse
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

<script>
    function toggleEditComment(commentId) {
        const contentElement = document.getElementById(`comentario-content-${commentId}`);
        const editElement = document.getElementById(`comentario-edit-${commentId}`);
        
        if (contentElement.style.display === 'none') {
            contentElement.style.display = 'block';
            editElement.style.display = 'none';
        } else {
            contentElement.style.display = 'none';
            editElement.style.display = 'block';
        }
    }
</script>

</html>