<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RealFoodie - {{ $receta->titulo }}</title>
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
    </style>
</head>
<body>
    @include('header')

    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <h1 class="card-title">{{ $receta->titulo }}</h1>
                            
                            <!-- Imagen de la receta -->
                            @if($receta->imagen)
                                <div class="ms-3">
                                    <img src="{{ asset('storage/' . $receta->imagen) }}" 
                                        alt="{{ $receta->titulo }}" 
                                        class="img-fluid rounded" 
                                        style="max-width: 300px; max-height: 200px;">
                                </div>
                            @endif
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

                        <!-- Pasos/Instrucciones -->
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

                        <!-- Botones de acción -->
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
            </div>
        </div>
    </div>

    @include('footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>