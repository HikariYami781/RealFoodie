@extends('layouts.app')

@section('title', 'Mis Colecciones')

@section('content')
<style>
    .cooking-bg {
        background: linear-gradient(135deg, #dda0dd 0%, #9370db 100%);
        min-height: 100vh;
        padding: 40px 0;
    }
    
    .collection-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }
    
    .collection-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    }
    
    .collection-header {
        background: linear-gradient(135deg, #667eea, #764ba2);
        padding: 1.5rem;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .collection-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: rotate(45deg);
    }
    
    .collection-body {
        padding: 1.5rem;
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
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }
    
    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(102, 126, 234, 0.4);
        background: linear-gradient(45deg, #5a67d8, #6b46c1);
    }
    
    .btn-outline-custom {
        border: 2px solid #667eea;
        color: #667eea;
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 600;
        transition: all 0.3s ease;
        background: transparent;
    }
    
    .btn-outline-custom:hover {
        background: #667eea;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }
    
    .stats-badge {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
        font-weight: 600;
    }
    
    .empty-state {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 3rem;
        text-align: center;
    }
    
    .floating-icons {
        position: absolute;
        opacity: 0.1;
        font-size: 80px;
        z-index: 1;
    }
    
    .content-wrapper {
        position: relative;
        z-index: 2;
    }
    
    .recipe-preview {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        object-fit: cover;
        border: 3px solid rgba(255, 255, 255, 0.3);
    }
    
    .recipe-preview-placeholder {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        background: rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px dashed rgba(0, 0, 0, 0.2);
    }
    
    .search-box {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .search-box:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        transform: translateY(-2px);
    }
</style>

<div class="cooking-bg">
    <!-- Iconos flotantes decorativos -->
    <div class="floating-icons" style="top: 5%; left: 5%;">
        <i class="fas fa-book"></i>
    </div>
    <div class="floating-icons" style="top: 15%; right: 10%;">
        <i class="fas fa-heart"></i>
    </div>
    <div class="floating-icons" style="bottom: 20%; left: 8%;">
        <i class="fas fa-star"></i>
    </div>
    <div class="floating-icons" style="bottom: 5%; right: 5%;">
        <i class="fas fa-bookmark"></i>
    </div>

    <div class="container">
        <div class="content-wrapper">
            <!-- Header principal -->
            <div class="text-center mb-5">
                <div class="mb-4">
                    <i class="fas fa-books cooking-icon" style="font-size: 4rem;"></i>
                </div>
                <h1 class="display-4 fw-bold text-white mb-3">
                    <i class="fas fa-collection me-2"></i>
                    Mis Colecciones
                </h1>
                <p class="text-white opacity-75 lead mb-4">
                    Organiza y encuentra tus recetas favoritas fácilmente
                </p>
                
                <!-- Botón crear nueva colección -->
                <a href="{{ route('colecciones.create') }}" 
                   class="btn btn-primary-custom btn-lg">
                    <i class="fas fa-plus-circle me-2"></i>
                    Nueva Colección
                </a>
            </div>

            @if($colecciones && $colecciones->count() > 0)
                <!-- Barra de búsqueda y filtros -->
                <div class="row mb-4">
                    <div class="col-lg-8 mx-auto">
                        <div class="position-relative">
                            <input type="text" 
                                   id="search-collections" 
                                   placeholder="Buscar en mis colecciones..." 
                                   class="form-control search-box ps-5 pe-4 py-3">
                            <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        </div>
                    </div>
                </div>

                <!-- Estadísticas generales -->
                <div class="row mb-5" id="stats-section">
                    <div class="col-md-4 mb-3">
                        <div class="text-center text-white">
                            <h3 class="fw-bold mb-1">{{ $colecciones->count() }}</h3>
                            <small class="opacity-75">{{ $colecciones->count() === 1 ? 'Colección' : 'Colecciones' }}</small>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="text-center text-white">
                            <h3 class="fw-bold mb-1">{{ $colecciones->sum(function($col) { return $col->recetas->count(); }) }}</h3>
                            <small class="opacity-75">Recetas Guardadas</small>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="text-center text-white">
                            <h3 class="fw-bold mb-1">{{ number_format($colecciones->avg(function($col) { return $col->recetas->count(); }), 1) }}</h3>
                            <small class="opacity-75">Promedio por Colección</small>
                        </div>
                    </div>
                </div>

                <!-- Grid de colecciones -->
                <div class="row" id="collections-grid">
                    @foreach($colecciones as $coleccion)
                        <div class="col-lg-4 col-md-6 mb-4 collection-item" 
                             data-name="{{ strtolower($coleccion->nombre) }}" 
                             data-description="{{ strtolower($coleccion->descripcion ?? '') }}">
                            <div class="collection-card h-100">
                                <!-- Header de la colección -->
                                <div class="collection-header">
                                    <div class="d-flex justify-content-between align-items-start position-relative">
                                        <div class="flex-grow-1">
                                            <h5 class="fw-bold mb-2">{{ $coleccion->nombre }}</h5>
                                            <div class="d-flex gap-2">
                                                <span class="stats-badge">
                                                    <i class="fas fa-book-open me-1"></i>
                                                    {{ $coleccion->recetas->count() }} {{ $coleccion->recetas->count() === 1 ? 'receta' : 'recetas' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-sm text-white opacity-75" 
                                                    type="button" 
                                                    data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('colecciones.show', $coleccion) }}">
                                                        <i class="fas fa-eye me-2"></i>Ver Colección
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('colecciones.edit', $coleccion) }}">
                                                        <i class="fas fa-edit me-2"></i>Editar
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Cuerpo de la colección -->
                                <div class="collection-body">
                                    @if($coleccion->descripcion)
                                        <p class="text-muted mb-3">{{ Str::limit($coleccion->descripcion, 100) }}</p>
                                    @else
                                        <p class="text-muted mb-3 fst-italic">Sin descripción</p>
                                    @endif

                                    <!-- Preview de recetas -->
                                    @if($coleccion->recetas->count() > 0)
                                        <div class="mb-3">
                                            <small class="text-muted fw-bold mb-2 d-block">Últimas recetas:</small>
                                            <div class="d-flex gap-2 mb-3">
                                                @foreach($coleccion->recetas->take(3) as $receta)
                                                    @if($receta->imagen)
                                                        <img src="{{ asset('storage/' . $receta->imagen) }}" 
                                                             alt="{{ $receta->titulo }}" 
                                                             class="recipe-preview"
                                                             title="{{ $receta->titulo }}">
                                                    @else
                                                        <div class="recipe-preview-placeholder" title="{{ $receta->titulo }}">
                                                            <i class="fas fa-utensils text-muted"></i>
                                                        </div>
                                                    @endif
                                                @endforeach
                                                @if($coleccion->recetas->count() > 3)
                                                    <div class="recipe-preview-placeholder">
                                                        <small class="text-muted fw-bold">+{{ $coleccion->recetas->count() - 3 }}</small>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Información adicional -->
                                    <div class="d-flex justify-content-between align-items-center text-sm text-muted mb-3">
                                        <small>
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $coleccion->created_at->format('d/m/Y') }}
                                        </small>
                                        @if($coleccion->updated_at != $coleccion->created_at)
                                            <small>
                                                <i class="fas fa-edit me-1"></i>
                                                Actualizada {{ $coleccion->updated_at->diffForHumans() }}
                                            </small>
                                        @endif
                                    </div>

                                    <!-- Botones de acción -->
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('colecciones.show', $coleccion) }}" 
                                           class="btn btn-primary-custom flex-grow-1">
                                            <i class="fas fa-eye me-2"></i>
                                            Ver Colección
                                        </a>
                                        <a href="{{ route('colecciones.edit', $coleccion) }}" 
                                           class="btn btn-outline-custom">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Mensaje cuando no hay resultados de búsqueda -->
                <div id="no-results" class="empty-state" style="display: none;">
                    <div class="mb-4">
                        <i class="fas fa-search text-muted" style="font-size: 4rem;"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-3">No se encontraron colecciones</h3>
                    <p class="text-muted mb-4">
                        No hay colecciones que coincidan con tu búsqueda.
                    </p>
                    <button onclick="clearSearch()" class="btn btn-outline-custom">
                        <i class="fas fa-times me-2"></i>
                        Limpiar búsqueda
                    </button>
                </div>

            @else
                <!-- Estado vacío - sin colecciones -->
                <div class="empty-state">
                    <div class="mb-4">
                        <i class="fas fa-book-open cooking-icon" style="font-size: 5rem;"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-3">¡Crea tu primera colección!</h3>
                    <p class="text-muted mb-4 lead">
                        Las colecciones te ayudan a organizar tus recetas favoritas por tema, ocasión o cualquier criterio que prefieras.
                    </p>
                    
                    <div class="row justify-content-center mb-4">
                        <div class="col-md-8">
                            <div class="row text-center">
                                <div class="col-4">
                                    <i class="fas fa-birthday-cake text-primary mb-2" style="font-size: 2rem;"></i>
                                    <p class="small text-muted">Postres</p>
                                </div>
                                <div class="col-4">
                                    <i class="fas fa-pizza-slice text-success mb-2" style="font-size: 2rem;"></i>
                                    <p class="small text-muted">Principales</p>
                                </div>
                                <div class="col-4">
                                    <i class="fas fa-heart text-danger mb-2" style="font-size: 2rem;"></i>
                                    <p class="small text-muted">Favoritas</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('colecciones.create') }}" 
                           class="btn btn-primary-custom btn-lg">
                            <i class="fas fa-plus-circle me-2"></i>
                            Crear Mi Primera Colección
                        </a>
                        <a href="{{ route('home') }}" 
                           class="btn btn-outline-custom btn-lg">
                            <i class="fas fa-utensils me-2"></i>
                            Explorar Recetas
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- JavaScript para búsqueda -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-collections');
    const collectionsGrid = document.getElementById('collections-grid');
    const noResults = document.getElementById('no-results');
    const statsSection = document.getElementById('stats-section');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            const collections = document.querySelectorAll('.collection-item');
            let visibleCount = 0;

            collections.forEach(function(collection) {
                const name = collection.getAttribute('data-name');
                const description = collection.getAttribute('data-description');
                
                if (name.includes(query) || description.includes(query)) {
                    collection.style.display = 'block';
                    visibleCount++;
                } else {
                    collection.style.display = 'none';
                }
            });

            // Mostrar/ocultar mensaje de sin resultados
            if (visibleCount === 0 && query !== '') {
                if (collectionsGrid) collectionsGrid.style.display = 'none';
                if (noResults) noResults.style.display = 'block';
                if (statsSection) statsSection.style.opacity = '0.5';
            } else {
                if (collectionsGrid) collectionsGrid.style.display = 'flex';
                if (noResults) noResults.style.display = 'none';
                if (statsSection) statsSection.style.opacity = '1';
            }
        });
    }
});

function clearSearch() {
    const searchInput = document.getElementById('search-collections');
    if (searchInput) {
        searchInput.value = '';
        searchInput.dispatchEvent(new Event('input'));
        searchInput.focus();
    }
}

// Animación de entrada para las tarjetas
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.collection-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>

@endsection