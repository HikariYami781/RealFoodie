@extends('layouts.app')

@section('title', $coleccion->nombre)

@section('content')
<style>
    .cooking-bg {
        background: linear-gradient(135deg, #dda0dd 0%, #9370db 100%);
        min-height: 100vh;
        padding: 40px 0;
    }
    
    .recipe-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .cooking-icon {
        background: linear-gradient(45deg, #ff4500, #ffff00);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .btn-primary-custom {
        background: linear-gradient(45deg, #667eea, #764ba2);
        border: none;
        border-radius: 12px;
        padding: 12px 25px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        color: white;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }
    
    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(102, 126, 234, 0.4);
        background: linear-gradient(45deg, #5a67d8, #6b46c1);
        color: white;
        text-decoration: none;
    }
    
    .btn-secondary-custom {
        background: rgba(108, 117, 125, 0.1);
        border: 2px solid rgba(108, 117, 125, 0.2);
        border-radius: 12px;
        padding: 12px 25px;
        font-weight: 600;
        color: #6c757d;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }
    
    .btn-secondary-custom:hover {
        background: rgba(108, 117, 125, 0.2);
        transform: translateY(-2px);
        color: #495057;
        text-decoration: none;
    }
    
    .btn-danger-custom {
        background: linear-gradient(45deg, #e74c3c, #c0392b);
        border: none;
        border-radius: 12px;
        padding: 8px 15px;
        font-weight: 600;
        font-size: 12px;
        transition: all 0.3s ease;
        box-shadow: 0 6px 15px rgba(231, 76, 60, 0.3);
        color: white;
        border: none;
    }
    
    .btn-danger-custom:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(231, 76, 60, 0.4);
        background: linear-gradient(45deg, #c0392b, #a93226);
    }
    
    .info-stats {
        background: linear-gradient(135deg, #a8e6cf, #88d8a3);
        border-radius: 15px;
        border: none;
        box-shadow: 0 10px 25px rgba(168, 230, 207, 0.3);
    }
    
    .floating-icons {
        position: absolute;
        opacity: 0.1;
        font-size: 100px;
        z-index: 1;
    }
    
    .content-wrapper {
        position: relative;
        z-index: 2;
    }
    
    .recipe-item {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(5px);
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.3s ease;
        overflow: hidden;
    }
    
    .recipe-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }
    
    .recipe-image {
        height: 200px;
        object-fit: cover;
        border-radius: 15px 15px 0 0;
    }
    
    .recipe-placeholder {
        height: 200px;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 15px 15px 0 0;
    }
    
    .rating-stars {
        color: #ffd700;
    }
    
    .category-badge {
        background: linear-gradient(45deg, #667eea, #764ba2);
        color: white;
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .empty-state {
        background: linear-gradient(135deg, #fff3cd, #ffeaa7);
        border-radius: 20px;
        border: none;
        box-shadow: 0 15px 35px rgba(255, 243, 205, 0.3);
    }
</style>

<div class="cooking-bg">
    <!-- Iconos flotantes decorativos -->
    <div class="floating-icons" style="top: 10%; left: 10%;">
        <i class="fas fa-book"></i>
    </div>
    <div class="floating-icons" style="top: 20%; right: 15%;">
        <i class="fas fa-heart"></i>
    </div>
    <div class="floating-icons" style="bottom: 30%; left: 5%;">
        <i class="fas fa-star"></i>
    </div>
    <div class="floating-icons" style="bottom: 10%; right: 10%;">
        <i class="fas fa-bookmark"></i>
    </div>

    <div class="container">
        <div class="content-wrapper">
            <!-- Breadcrumb y Header -->
            <div class="row justify-content-center mb-4">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb" style="background: transparent; margin-bottom: 0;">
                            <li class="breadcrumb-item">
                                <a href="{{ route('colecciones.index') }}" class="text-white-50 text-decoration-none">
                                    <i class="fas fa-collections me-1"></i>
                                    Mis Colecciones
                                </a>
                            </li>
                            <li class="breadcrumb-item active text-white" aria-current="page">
                                {{ $coleccion->nombre }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>

            <!-- Header de la colección -->
            <div class="row justify-content-center mb-5">
                <div class="col-lg-10">
                    <div class="recipe-card p-5 mb-4">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <div class="mb-3">
                                    <i class="fas fa-book-open cooking-icon me-3" style="font-size: 2.5rem;"></i>
                                    <h1 class="display-5 fw-bold text-dark d-inline-block mb-0">{{ $coleccion->nombre }}</h1>
                                </div>
                                
                                @if($coleccion->descripcion)
                                    <p class="text-muted mb-4 fs-6">{{ $coleccion->descripcion }}</p>
                                @endif
                                
                                <div class="d-flex flex-wrap gap-3 align-items-center text-muted">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-utensils me-2 text-primary"></i>
                                        <span>{{ $coleccion->recetas->count() }} {{ $coleccion->recetas->count() === 1 ? 'receta' : 'recetas' }}</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-calendar me-2 text-info"></i>
                                        <span>Creada {{ $coleccion->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                                <div class="d-flex flex-column flex-lg-row gap-2 justify-content-lg-end">
                                    <a href="{{ route('colecciones.edit', $coleccion) }}" class="btn-primary-custom">
                                        <i class="fas fa-edit me-2"></i>
                                        Editar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Estadísticas -->
                    <div class="info-stats p-4 mb-5">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <i class="fas fa-book text-success" style="font-size: 2rem;"></i>
                                </div>
                                <h4 class="fw-bold text-dark mb-1">{{ $coleccion->recetas->count() }}</h4>
                                <small class="text-dark">Recetas guardadas</small>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <i class="fas fa-clock text-warning" style="font-size: 2rem;"></i>
                                </div>
                                <h4 class="fw-bold text-dark mb-1">
                                    @php
                                        $tiempoTotal = $coleccion->recetas->sum(function($receta) {
                                            return $receta->preparacion + $receta->coccion;
                                        });
                                    @endphp
                                    {{ $tiempoTotal }} min
                                </h4>
                                <small class="text-dark">Tiempo total</small>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <i class="fas fa-star text-warning" style="font-size: 2rem;"></i>
                                </div>
                                <h4 class="fw-bold text-dark mb-1">
                                    @php
                                        $valoracionPromedio = 0;
                                        $totalValoraciones = 0;
                                        foreach($coleccion->recetas as $receta) {
                                            if($receta->valoraciones->count() > 0) {
                                                $valoracionPromedio += $receta->valoraciones->avg('puntuacion');
                                                $totalValoraciones++;
                                            }
                                        }
                                        $promedioFinal = $totalValoraciones > 0 ? round($valoracionPromedio / $totalValoraciones, 1) : 0;
                                    @endphp
                                    {{ $promedioFinal ?: 'N/A' }}
                                </h4>
                                <small class="text-dark">Valoración promedio</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenido de recetas -->
            @if($coleccion->recetas->count() > 0)
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="row g-4">
                            @foreach($coleccion->recetas as $receta)
                                <div class="col-md-6 col-lg-4">
                                    <div class="recipe-item h-100">
                                        <!-- Imagen -->
                                        <div class="position-relative">
                                            @if($receta->imagen)
                                                <img src="{{ asset('storage/' . $receta->imagen) }}" 
                                                     alt="{{ $receta->titulo }}" 
                                                     class="recipe-image w-100">
                                            @else
                                                <div class="recipe-placeholder">
                                                    <i class="fas fa-utensils text-muted" style="font-size: 3rem;"></i>
                                                </div>
                                            @endif
                                            
                                            <!-- Botón para quitar -->
                                            <div class="position-absolute top-0 end-0 p-2">
                                                <form action="{{ route('colecciones.removeReceta', [$coleccion, $receta]) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            onclick="return confirm('¿Quitar esta receta de la colección?')"
                                                            class="btn-danger-custom"
                                                            title="Quitar de la colección">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        
                                        <!-- Contenido -->
                                        <div class="p-4">
                                            <h5 class="fw-bold text-dark mb-2">
                                                <a href="{{ route('recetas.show', $receta) }}" 
                                                   class="text-decoration-none text-dark hover-primary">
                                                    {{ Str::limit($receta->titulo, 50) }}
                                                </a>
                                            </h5>
                                            
                                            <p class="text-muted small mb-3">
                                                {{ Str::limit($receta->descripcion, 80) }}
                                            </p>
                                            
                                            <!-- Información adicional -->
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <div class="d-flex align-items-center small text-muted">
                                                    <i class="fas fa-user me-1"></i>
                                                    <span>{{ $receta->user->nombre }}</span>
                                                </div>
                                                @if($receta->categoria)
                                                    <span class="category-badge">
                                                        {{ $receta->categoria->nombre }}
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            <!-- Valoración y tiempo -->
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    @if($receta->valoraciones->count() > 0)
                                                        @php
                                                            $promedio = $receta->valoraciones->avg('puntuacion');
                                                        @endphp
                                                        <div class="d-flex align-items-center">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <i class="fas fa-star {{ $i <= round($promedio) ? 'rating-stars' : 'text-muted' }}" style="font-size: 12px;"></i>
                                                            @endfor
                                                            <span class="small text-muted ms-1">({{ $receta->valoraciones->count() }})</span>
                                                        </div>
                                                    @else
                                                        <span class="small text-muted">Sin valoraciones</span>
                                                    @endif
                                                </div>
                                                
                                                <div class="d-flex align-items-center small text-muted">
                                                    <i class="fas fa-clock me-1"></i>
                                                    <span>{{ $receta->preparacion + $receta->coccion }} min</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <!-- Estado vacío -->
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="empty-state p-5 text-center">
                            <div class="mb-4">
                                <i class="fas fa-book-open" style="font-size: 4rem; color: #e17055;"></i>
                            </div>
                            <h3 class="fw-bold text-dark mb-3">Colección vacía</h3>
                            <p class="text-dark mb-4">
                                Esta colección no tiene recetas aún. Puedes agregar recetas visitando cualquier receta 
                                y usando el botón "Agregar a colección".
                            </p>
                            <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                                <a href="{{ route('home') }}" class="btn-primary-custom">
                                    <i class="fas fa-search me-2"></i>
                                    Explorar Recetas
                                </a>
                                <a href="{{ route('colecciones.edit', $coleccion) }}" class="btn-secondary-custom">
                                    <i class="fas fa-edit me-2"></i>
                                    Editar Colección
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Botón de regreso -->
            <div class="row justify-content-center mt-5">
                <div class="col-lg-10">
                    <div class="text-center">
                        <a href="{{ route('colecciones.index') }}" class="btn-secondary-custom">
                            <i class="fas fa-arrow-left me-2"></i>
                            Volver a Mis Colecciones
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-primary:hover {
    color: #667eea !important;
}
</style>
@endsection