@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-5">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">

                    @if($user->foto_perfil)
                        <img src="{{ asset('storage/fotos_perfil/' . $user->foto_perfil) }}" 
                            class="rounded-circle img-fluid mb-3" style="width: 150px; height: 150px; object-fit: cover;" 
                            alt="Foto de perfil de {{ $user->nombre }}">
                    @else
                        <img src="{{ asset('images/default-profile.jpg') }}" 
                            class="rounded-circle img-fluid mb-3" style="width: 150px; height: 150px; object-fit: cover;"
                            alt="Foto de perfil por defecto">
                    @endif

                    
                    <h3 class="card-title">{{ $user->nombre }}</h3>

                    
                    @if($user->descripcion)
                        <p class="card-text">{{ $user->descripcion }}</p>
                    @else
                        <p class="card-text text-muted">Sin descripción</p>
                    @endif

                    
                    <div class="d-flex justify-content-around mt-4">
                        <a href="{{ route('users.followers', $user) }}" class="text-decoration-none">
                            <div class="text-center">
                                <h5>{{ $user->seguidores->count() }}</h5>
                                <span>Seguidores</span>
                            </div>
                        </a>
                        

                        <a href="{{ route('users.following', $user) }}" class="text-decoration-none">
                            <div class="text-center">
                                <h5>{{ $user->siguiendo->count() }}</h5>
                                <span>Siguiendo</span>
                            </div>
                        </a>
                    </div>

                    
                    @if(Auth::check() && Auth::id() !== $user->id)
                        <div class="mt-4">
                            <form action="{{ route('users.toggleFollow', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn {{ Auth::user()->siguiendo->contains($user->id) ? 'btn-outline-primary' : 'btn-primary' }}">
                                    {{ Auth::user()->siguiendo->contains($user->id) ? 'Dejar de seguir' : 'Seguir' }}
                                </button>
                            </form>
                        </div>

                    @elseif(Auth::check() && Auth::id() === $user->id)
                        <div class="mt-4">
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-edit me-1"></i>Editar perfil
                            </a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
        

        <div class="col-md-8">
            <ul class="nav nav-tabs mb-4" id="profileTab" role="tablist">

                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="recetas-tab" data-bs-toggle="tab" data-bs-target="#recetas" 
                        type="button" role="tab" aria-controls="recetas" aria-selected="true">
                        Mis recetas ({{ $recetas->count() }})
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="favoritas-tab" data-bs-toggle="tab" data-bs-target="#favoritas" 
                        type="button" role="tab" aria-controls="favoritas" aria-selected="false">
                        Favoritas ({{ $user->recetasFavoritas->count() }})
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="colecciones-tab" data-bs-toggle="tab" data-bs-target="#colecciones" 
                        type="button" role="tab" aria-controls="colecciones" aria-selected="false">
                        Colecciones ({{ $user->colecciones->count() }})
                    </button>
                </li>

            </ul>
            
            <div class="tab-content" id="profileTabContent">

                <!-- Recetas propias -->
                <div class="tab-pane fade show active" id="recetas" role="tabpanel" aria-labelledby="recetas-tab">
                    @if($recetas->count() > 0)

                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                            @foreach($recetas as $receta)
                                <div class="col">
                                    <div class="card h-100">

                                        @if($receta->imagen)
                                            <img src="{{ asset('storage/recetas/' . $receta->imagen) }}" 
                                                class="card-img-top" alt="{{ $receta->titulo }}" 
                                                style="height: 180px; object-fit: cover;">
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

                                            <div class="d-flex justify-content-between align-items-center">
                                                <a href="{{ route('recetas.show', $receta) }}" class="btn btn-sm btn-outline-primary">Ver receta</a>
                                                <small class="text-muted">
                                                    <i class="fas fa-star text-warning me-1"></i>
                                                    {{ $receta->valoraciones->avg('puntuacion') ? number_format($receta->valoraciones->avg('puntuacion'), 1) : 'N/A' }}
                                                </small>
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
                                <p>Este usuario aún no ha publicado recetas.</p>
                            @endif
                        </div>
                    @endif

                </div>
                
                <!-- Recetas favoritas -->
                <div class="tab-pane fade" id="favoritas" role="tabpanel" aria-labelledby="favoritas-tab">
                    @if($user->recetasFavoritas->count() > 0)

                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                            @foreach($user->recetasFavoritas as $favorita)
                                <div class="col">
                                    <div class="card h-100">

                                        @if($favorita->imagen)
                                            <img src="{{ asset('storage/recetas/' . $favorita->imagen) }}" 
                                                class="card-img-top" alt="{{ $favorita->titulo }}" 
                                                style="height: 180px; object-fit: cover;">
                                        @else
                                            <div class="bg-light text-center pt-4" style="height: 180px;">
                                                <i class="fas fa-utensils fa-4x text-muted"></i>
                                            </div>
                                        @endif

                                        
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $favorita->titulo }}</h5>
                                            <p class="card-text small text-muted">
                                                <i class="fas fa-user me-1"></i>{{ $favorita->user->nombre }}
                                            </p>

                                            <div class="d-flex justify-content-between align-items-center">
                                                <a href="{{ route('recetas.show', $favorita) }}" class="btn btn-sm btn-outline-primary">Ver receta</a>
                                                <small class="text-muted">
                                                    <i class="fas fa-star text-warning me-1"></i>
                                                    {{ $favorita->valoraciones->avg('puntuacion') ? number_format($favorita->valoraciones->avg('puntuacion'), 1) : 'N/A' }}
                                                </small>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else

                        <div class="text-center py-5">
                            <i class="fas fa-heart fa-4x text-muted mb-3"></i>
                            <h4>No hay recetas favoritas</h4>
                            @if(Auth::check() && Auth::id() === $user->id)
                                <p>Marca recetas como favoritas para encontrarlas fácilmente aquí.</p>
                                <a href="{{ route('home') }}" class="btn btn-primary mt-2">
                                    Explorar recetas
                                </a>
                            @else
                                <p>Este usuario aún no ha marcado recetas como favoritas.</p>
                            @endif
                        </div>

                    @endif
                </div>
                
                <!-- Colecciones -->
                <div class="tab-pane fade" id="colecciones" role="tabpanel" aria-labelledby="colecciones-tab">
                    @if($user->colecciones->count() > 0)

                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                            @foreach($user->colecciones as $coleccion)
                                <div class="col">
                                    <div class="card h-100">

                                        <div class="card-body">
                                            <h5 class="card-title">{{ $coleccion->nombre }}</h5>
                                            <p class="card-text small text-muted">
                                                {{ $coleccion->recetas->count() }} recetas
                                            </p>

                                            <a href="{{ route('colecciones.show', $coleccion) }}" class="btn btn-sm btn-outline-primary">
                                                Ver colección
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
                                <p>Organiza tus recetas favoritas en colecciones temáticas.</p>
                                <a href="{{ route('colecciones.create') }}" class="btn btn-primary mt-2">
                                    <i class="fas fa-plus me-1"></i>Crear colección
                                </a>
                            @else
                                <p>Este usuario aún no ha creado colecciones.</p>
                            @endif
                        </div>

                    @endif

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
