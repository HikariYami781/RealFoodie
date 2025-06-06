@extends('layouts.app')

@section('title', 'Perfil')

@section('content')
<style>
    body {
        background: linear-gradient( to left, #E0C3FC,#8EC5FC); 
        position: relative
    }
    
    main {
        position: relative;
        z-index: 1;
    }
    
    .card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
    }
    
    .nav-tabs .nav-link.active {
        border-bottom: 3px solid #0d6efd;
        font-weight: bold;
    }

     .counter-link {
        text-decoration: none !important;
        color: inherit;
        cursor: pointer;
        position: relative;
    }
    
    .counter-link:hover {
        text-decoration: none !important;
        color: inherit;
    }
    
    /* Tooltip que aparece al hacer hover */
    .counter-link:hover::after {
        content: '👆 Click para ver';
        position: absolute;
        bottom: -35px;
        left: 50%;
        transform: translateX(-50%);
        background-color: #333;
        color: white;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 0.75rem;
        white-space: nowrap;
        z-index: 1000;
        animation: fadeInTooltip 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    @keyframes fadeInTooltip {
        from { opacity: 0; transform: translateX(-50%) translateY(-10px); }
        to { opacity: 1; transform: translateX(-50%) translateY(0); }
    }
</style>

<div class="container">
    <div class="row mb-5">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <!-- Foto de perfil -->
                   <img src="{{ isset($user->foto_perfil) && $user->foto_perfil ? asset('fotos_perfil/' . $user->foto_perfil) : asset('images/x_defecto.jpg') }}" 
                        class="rounded-circle img-fluid mb-3" style="width: 150px; height: 150px; object-fit: cover;" 
                        alt="Foto de perfil de {{ $user->nombre }}"
                        onerror="this.src='{{ asset('images/x_defecto.jpg') }}';this.onerror=null;">

                    <!-- Nombre de usuario -->
                    <h3 class="card-title">{{ $user->nombre }}</h3>

                    <!-- Descripción del usuario -->
                    @if($user->descripcion && !empty(trim($user->descripcion)))
                        <p class="card-text">{{ $user->descripcion }}</p>
                    @else
                        <p class="card-text text-muted">Sin descripción</p>
                    @endif

                    <!-- Contadores de seguidores y seguidos -->
                    <div class="d-flex justify-content-around mt-4">
                        <a href="{{ route('users.followers', $user) }}" class="counter-link">
                            <div class="text-center">
                                <h5>{{ $user->seguidores->count() ?? 0 }}</h5>
                                <span>Seguidores</span>
                            </div>
                        </a>
                        
                        <a href="{{ route('users.following', $user) }}" class="counter-link">
                            <div class="text-center">
                                <h5>{{ $user->siguiendo->count() ?? 0 }}</h5>
                                <span>Siguiendo</span>
                            </div>
                        </a>
                    </div>

                    <!-- Botones de seguir o editar perfil -->
                    @if(Auth::check() && Auth::id() !== $user->id)
                        <div class="mt-4">
                            <form action="{{ route('users.toggleFollow', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn {{ Auth::user()->siguiendo->contains($user->id) ? 'btn-outline-primary' : 'btn-primary' }} w-100">
                                    <i class="{{ Auth::user()->siguiendo->contains($user->id) ? 'fas fa-user-minus' : 'fas fa-user-plus' }} me-1"></i>
                                    {{ Auth::user()->siguiendo->contains($user->id) ? 'Dejar de seguir' : 'Seguir' }}
                                </button>
                            </form>
                        </div>
                    @elseif(Auth::check() && Auth::id() === $user->id)
                        <div class="mt-4">
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary w-100 mb-2">
                                <i class="fas fa-edit me-1"></i>Editar perfil
                            </a>
                            <!-- Botón para ir a Mis Colecciones - solo aparece aquí -->
                            <a href="{{ route('colecciones.index') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-folder me-1"></i>Mis Colecciones
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Contenido de pestañas -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs mb-4" id="profileTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="recetas-tab" data-bs-toggle="tab" data-bs-target="#recetas" 
                                type="button" role="tab" aria-controls="recetas" aria-selected="true">
                                <i class="fas fa-utensils me-1"></i>Mis recetas ({{ $recetas->total() ?? 0 }})
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="favoritas-tab" data-bs-toggle="tab" data-bs-target="#favoritas" 
                                type="button" role="tab" aria-controls="favoritas" aria-selected="false">
                                <i class="fas fa-heart me-1"></i>Favoritas ({{ $favoritas->total() ?? 0 }})
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="colecciones-tab" data-bs-toggle="tab" data-bs-target="#colecciones" 
                                type="button" role="tab" aria-controls="colecciones" aria-selected="false">
                                <i class="fas fa-folder me-1"></i>Colecciones ({{ $user->colecciones->count() ?? 0 }})
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="profileTabContent">
                        <!-- Tab: Recetas propias -->
                        <div class="tab-pane fade show active" id="recetas" role="tabpanel" aria-labelledby="recetas-tab">
                            @if(isset($recetas) && $recetas->count() > 0)
                                <div class="row row-cols-1 row-cols-md-2 g-4">
                                    @foreach($recetas as $receta)
                                        <div class="col">
                                            <div class="card h-100">
                                                @if($receta->imagen && !empty($receta->imagen))
                                                    <img src="{{ file_exists(public_path($receta->imagen)) ? asset($receta->imagen) : asset('storage/' . $receta->imagen) }}" 
                                                        alt="{{ $receta->titulo }}" 
                                                        class="card-img-top" 
                                                        style="height: 180px; object-fit: cover;"
                                                        onerror="this.src='{{ asset('/images/no-image-placeholder.jpg') }}'">
                                                @else
                                                    <div class="bg-light text-center pt-4" style="height: 180px;">
                                                        <i class="fas fa-utensils fa-4x text-muted"></i>
                                                    </div>
                                                @endif
                                                
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $receta->titulo }}</h5>
                                                    <p class="card-text small text-muted">
                                                        <i class="fas fa-tag me-1"></i>{{ $receta->categoria->nombre ?? 'Sin categoría' }}
                                                    </p>

                                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                                        <a href="{{ route('recetas.show', $receta) }}" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-eye me-1"></i>Ver receta
                                                        </a>
                                                        <span class="badge bg-warning text-dark">
                                                            <i class="fas fa-star me-1"></i>
                                                            {{ $receta->valoraciones->avg('puntuacion') ? number_format($receta->valoraciones->avg('puntuacion'), 1) : 'N/A' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $recetas->links() }}
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-cookie-bite fa-4x text-muted mb-3"></i>
                                    <h4>No hay recetas aún</h4>
                                    @if(Auth::check() && Auth::id() === $user->id)
                                        <p>¡Comparte tu primera receta con la comunidad!</p>
                                        <a href="{{ route('recetas.create') }}" class="btn btn-primary mt-2">
                                            <i class="fas fa-plus me-1"></i>Crear receta
                                        </a>
                                    @else
                                        <p class="text-muted">Este usuario aún no ha publicado recetas.</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                        
                       <!-- Tab: Favoritas -->
                        <div class="tab-pane fade" id="favoritas" role="tabpanel" aria-labelledby="favoritas-tab">
                            @if(isset($favoritas) && $favoritas->count() > 0)
                                <div class="row row-cols-1 row-cols-md-2 g-4">
                                    @foreach($favoritas as $favorita)
                                        <div class="col">
                                            <div class="card h-100">
                                                @if($favorita->imagen && !empty($favorita->imagen))
                                                    <img src="{{ file_exists(public_path($favorita->imagen)) ? asset($favorita->imagen) : asset('storage/' . $favorita->imagen) }}" 
                                                        alt="{{ $favorita->titulo }}" 
                                                        class="card-img-top" 
                                                        style="height: 180px; object-fit: cover;"
                                                        onerror="this.src='{{ asset('/images/no-image-placeholder.jpg') }}'">
                                                @else
                                                    <div class="bg-light text-center pt-4" style="height: 180px;">
                                                        <i class="fas fa-utensils fa-4x text-muted"></i>
                                                    </div>
                                                @endif
                                                
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $favorita->titulo }}</h5>
                                                    <p class="card-text small text-muted">
                                                        <i class="fas fa-user me-1"></i>{{ $favorita->user->nombre ?? 'Usuario desconocido' }}
                                                    </p>

                                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                                        <a href="{{ route('recetas.show', $favorita) }}" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-eye me-1"></i>Ver receta
                                                        </a>
                                                        <span class="badge bg-warning text-dark">
                                                            <i class="fas fa-star me-1"></i>
                                                            {{ $favorita->valoraciones->avg('puntuacion') ? number_format($favorita->valoraciones->avg('puntuacion'), 1) : 'N/A' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <!-- Paginación para favoritas -->
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $favoritas->links() }}
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-heart fa-4x text-muted mb-3"></i>
                                    <h4>No hay recetas favoritas</h4>
                                    @if(Auth::check() && Auth::id() === $user->id)
                                        <p class="text-muted">Marca recetas como favoritas para encontrarlas fácilmente aquí.</p>
                                        <a href="{{ route('home') }}" class="btn btn-primary mt-2">
                                            <i class="fas fa-search me-1"></i>Explorar recetas
                                        </a>
                                    @else
                                        <p class="text-muted">Este usuario aún no ha marcado recetas como favoritas.</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                        
                        <!-- Tab: Colecciones -->
                        <div class="tab-pane fade" id="colecciones" role="tabpanel" aria-labelledby="colecciones-tab">
                            @if(isset($user->colecciones) && $user->colecciones->count() > 0)
                                <div class="row row-cols-1 row-cols-md-2 g-4">
                                    @foreach($user->colecciones as $coleccion)
                                        <div class="col">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <h5 class="card-title">
                                                        <i class="fas fa-folder me-2 text-primary"></i>
                                                        {{ $coleccion->nombre }}
                                                    </h5>
                                                    @if($coleccion->descripcion && !empty(trim($coleccion->descripcion)))
                                                        <p class="card-text small text-muted mb-2">{{ Str::limit($coleccion->descripcion, 100) }}</p>
                                                    @endif
                                                    <p class="card-text small text-muted">
                                                        <i class="fas fa-book-open me-1"></i>{{ $coleccion->recetas->count() ?? 0 }} recetas
                                                    </p>

                                                    <a href="{{ route('colecciones.show', $coleccion) }}" class="btn btn-sm btn-outline-primary mt-2">
                                                        <i class="fas fa-eye me-1"></i>Ver colección
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                                    <h4>No hay colecciones</h4>

                                    @if(Auth::check() && Auth::id() === $user->id)
                                        <p class="text-muted">Organiza tus recetas favoritas en colecciones temáticas.</p>
                                        <a href="{{ route('colecciones.create') }}" class="btn btn-primary mt-2">
                                            <i class="fas fa-plus me-1"></i>Crear colección
                                        </a>
                                    @else
                                        <p class="text-muted">Este usuario aún no ha creado colecciones.</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Verificar si Bootstrap está cargado
    if (typeof bootstrap !== 'undefined') {
        // Inicializar tooltips si existen
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
    
    // Manejar errores de carga de imágenes
    const images = document.querySelectorAll('img[onerror]');
    images.forEach(img => {
        img.addEventListener('error', function() {
            console.log('Error cargando imagen:', this.src);
        });
    });
});
</script>

@endsection
