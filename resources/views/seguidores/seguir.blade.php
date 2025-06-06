@extends('layouts.app')

@section('title', 'Seguidores')

@section('content')
<style>
    body {
        background: linear-gradient(to left, #E0C3FC, #8EC5FC); 
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
    
    .user-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 15px;
        overflow: hidden;
    }
    
    .user-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .profile-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border: 3px solid #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        background-color: #f8f9fa; /* Fallback color */
    }
    
    .stats-badge {
        background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.85em;
        font-weight: 500;
    }
    
    .follow-btn {
        transition: all 0.3s ease;
        border-radius: 25px;
        padding: 8px 20px;
        font-weight: 500;
    }
    
    .follow-btn:hover {
        transform: scale(1.05);
    }
    
    .breadcrumb {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 10px;
        padding: 15px;
        border: none;
    }
    
    .breadcrumb-item a {
        color: #333;
        text-decoration: none;
        font-weight: 500;
    }
    
    .breadcrumb-item a:hover {
        color: #007bff;
    }
</style>

<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">
                    <i class="fas fa-home me-1"></i>Inicio
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('users.show', $user) }}">
                    <i class="fas fa-user me-1"></i>{{ $user->nombre }}
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <i class="fas fa-users me-1"></i>Seguidores
            </li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-4">
                    <!-- Foto de perfil del usuario principal -->
                    <img src="{{ isset($user->foto_perfil) && $user->foto_perfil ? asset('fotos_perfil/' . $user->foto_perfil) : 											asset('images/x_defecto.jpg') }}" 
								class="rounded-circle profile-img mb-3" 
								alt="Foto de perfil de {{ $user->nombre }}"
								onerror="this.src='{{ asset('images/x_defecto.jpg') }}';this.onerror=null;">
                    
                    <h2 class="mb-2">Seguidores de {{ $user->nombre }}</h2>
                    <p class="text-muted mb-3">{{ $seguidores->total() }} personas siguen a {{ $user->nombre }}</p>
                    
                    <!-- Navegación entre seguidores y siguiendo -->
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('users.followers', $user) }}" class="btn btn-primary">
                            <i class="fas fa-users me-1"></i>
                            Seguidores ({{ $user->seguidores_count }})
                        </a>
                        <a href="{{ route('users.following', $user) }}" class="btn btn-outline-primary">
                            <i class="fas fa-user-friends me-1"></i>
                            Siguiendo ({{ $user->siguiendo_count }})
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Seguidores -->
    @if($seguidores->count() > 0)
        <div class="row">
            @foreach($seguidores as $seguidor)
                <div class="col-lg-6 col-xl-4 mb-4">
                    <div class="card user-card h-100">
                        <div class="card-body text-center">
                            <!-- Foto de perfil del seguidor con múltiples fallbacks -->
                            <img src="{{ isset($seguidor->foto_perfil) && $seguidor->foto_perfil ? asset('fotos_perfil/' . $seguidor->foto_perfil) : asset('images/x_defecto.jpg') }}" 
                                        class="rounded-circle profile-img mb-3" 
                                        alt="Foto de perfil de {{ $seguidor->nombre }}"
                                        onerror="this.src='{{ asset('images/x_defecto.jpg') }}';this.onerror=null;">

                            <!-- Nombre del seguidor -->
                            <h5 class="card-title mb-2">
                                <a href="{{ route('users.show', $seguidor) }}" class="text-decoration-none">
                                    {{ $seguidor->nombre }}
                                </a>
                            </h5>

                            <!-- Descripción -->
                            @if($seguidor->descripcion)
                                <p class="card-text text-muted small mb-3">{{ Str::limit($seguidor->descripcion, 60) }}</p>
                            @else
                                <p class="card-text text-muted small mb-3">Sin descripción</p>
                            @endif

                            <!-- Estadísticas usando contadores -->
                            <div class="d-flex justify-content-center gap-3 mb-3">
                                <span class="stats-badge">
                                    <i class="fas fa-utensils me-1"></i>
                                    {{ $seguidor->recetas_count }} recetas
                                </span>
                                <span class="stats-badge">
                                    <i class="fas fa-users me-1"></i>
                                    {{ $seguidor->seguidores_count }} seguidores
                                </span>
                            </div>

                            <!-- Botón de seguir/dejar de seguir -->
                            @auth
                                @if(Auth::id() !== $seguidor->id)
                                    <form action="{{ route('users.toggleFollow', $seguidor) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="follow-btn btn btn-sm {{ Auth::user()->siguiendo->contains($seguidor->id) ? 'btn-outline-danger' : 'btn-primary' }}">
                                            <i class="{{ Auth::user()->siguiendo->contains($seguidor->id) ? 'fas fa-user-minus' : 'fas fa-user-plus' }} me-1"></i>
                                            {{ Auth::user()->siguiendo->contains($seguidor->id) ? 'Dejar de seguir' : 'Seguir' }}
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary follow-btn">
                                    <i class="fas fa-sign-in-alt me-1"></i>Iniciar sesión para seguir
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paginación -->
        <div class="d-flex justify-content-center mt-4">
            {{ $seguidores->links() }}
        </div>
    @else
        <!-- Estado vacío -->
        <div class="text-center py-5">
            <div class="card">
                <div class="card-body py-5">
                    <i class="fas fa-user-friends fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted">No hay seguidores aún</h4>
                    <p class="text-muted">{{ $user->nombre }} aún no tiene seguidores.</p>
                    
                    @auth
                        @if(Auth::id() !== $user->id && !Auth::user()->siguiendo->contains($user->id))
                            <form action="{{ route('users.toggleFollow', $user) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-primary mt-3">
                                    <i class="fas fa-user-plus me-1"></i>¡Sé el primero en seguir!
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    @endif
</div>

<script>
// Script adicional para manejar errores de carga de imágenes
document.addEventListener('DOMContentLoaded', function() {
    const images = document.querySelectorAll('.profile-img');
    images.forEach(function(img) {
        img.addEventListener('error', function() {
            // Si falla la carga, usar imagen por defecto
            this.src = '{{ asset('images/x_defecto.jpg') }}';
        });
    });
});
</script>

@endsection
