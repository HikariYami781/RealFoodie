<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RealFoodie - {{ $receta->titulo }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
            border-left: 4px solid #007bff;
            transition: all 0.3s ease;
        }
        
        .comentario:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .rating-stars {
            color: #ffc107;
            font-size: 1.2em;
            margin: 10px 0;
        }
        
        .rating-stars .far {
            color: #e0e0e0;
            cursor: pointer;
            transition: color 0.2s ease;
        }
        
        .rating-stars .fas {
            color: #ffc107;
            cursor: pointer;
        }
        
        .rating-stars .fa-star:hover {
            color: #ffc107 !important;
        }
        
        .rating-summary {
            background: linear-gradient(45deg, #d2691e, #f4a460);
            color: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            text-align: center;
        }
        
        
        .rating-summary .average-rating {
            font-size: 2.5em;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .rating-bar {
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            height: 8px;
            overflow: hidden;
            margin: 5px 0;
            width: 100px;
        }
        
        .rating-bar-fill {
            background-color: #ffc107;
            height: 100%;
            border-radius: 10px;
            transition: width 0.3s ease;
        }
        
        .user-rating-form {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 25px;
        }
        
        .comment-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .user-name {
            font-weight: 600;
            color: #495057;
            text-decoration: none;
        }
        
        .user-name:hover {
            color: #007bff;
        }
        
        .comment-rating {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .rating-badge {
            background: linear-gradient(45deg,#d2691e, #f4a460);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 500;
        }
        
        .rating-distribution {
            font-size: 0.9em;
        }
        
        .rating-distribution .row {
            margin-bottom: 5px;
        }
        
        .small-stars {
            font-size: 0.9em;
        }


        .author-card {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .author-card:hover {
            background-color: #f8f9fa !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .author-link:hover {
            color: #007bff !important;
        }

        .author-avatar {
            transition: transform 0.3s ease;
        }

        .author-card:hover .author-avatar {
            transform: scale(1.05);
        }

        .follow-author-btn {
            transition: all 0.3s ease;
            border-radius: 20px;
            font-weight: 500;
            padding: 6px 16px;
        }

        .follow-author-btn:hover {
            transform: scale(1.05);
        }

        .author-card {
            position: relative;
        }

        .author-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
        }

        .follow-author-btn {
            position: relative;
            z-index: 2;
        }
		
		/* Responsive*/
        @media (max-width: 768px) {
            .card {
                padding: 15px;
            }
            
            .author-card .d-flex {
                flex-direction: column;
                align-items: center !important;
                text-align: center;
            }
            
            .author-card .me-3 {
                margin-right: 0 !important;
                margin-bottom: 15px;
            }
            
            .author-card .ms-3 {
                margin-left: 0 !important;
                margin-top: 15px;
            }
            
            .comment-meta {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .comment-rating {
                align-self: flex-end;
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
									<img src="{{ file_exists(public_path($receta->imagen)) ? asset($receta->imagen) : asset('storage/' . 												  $receta->imagen) }}" 
											 alt="{{ $receta->titulo }}" 
											 class="img-fluid rounded" 
											 style="max-height: 200px; width: 100%; object-fit: cover;" 
											 onerror="this.src='{{ asset('/images/no-image-placeholder.jpg') }}'">
								</div>
							@endif

                        </div>

                     <!--Autor-->           
                    <div class="mb-4">
                        <h5 class="mb-3">
                            <i class="fas fa-chef-hat me-2"></i>Creado por
                        </h5>
                        <div class="author-card p-3 bg-light rounded-3 border">
                            <div class="d-flex align-items-center">
                        <!-- Foto de perfil del autor -->
                        <div class="me-3">
						  @if($receta->user->foto_perfil)
							<img src="{{ isset($receta->user->foto_perfil) && $receta->user->foto_perfil ? asset('fotos_perfil/' . $receta->user->foto_perfil) : asset('images/x_defecto.jpg') }}" 
									 class="rounded-circle author-avatar" 
									 alt="Foto de perfil de {{ $receta->user->nombre }}"
									 style="width: 60px; height: 60px; object-fit: cover; border: 2px solid #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.1);"
									 onerror="this.src='{{ asset('images/x_defecto.jpg') }}';this.onerror=null;">
						@else
							<div class="rounded-circle author-avatar d-flex align-items-center justify-content-center"
								 style="width: 60px; height: 60px; background-color: #6c757d; border: 2px solid #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
								<i class="fas fa-user text-white"></i>
							</div>
						@endif
                        </div>

                    
                        <!-- Información del autor -->
                        <div class="flex-grow-1">
                            <h6 class="mb-1">
                                <a href="{{ route('users.show', $receta->user) }}" 
                                class="text-decoration-none fw-bold author-link"
                                style="color: #495057; transition: color 0.3s ease;">
                                    {{ $receta->user->nombre }}
                                </a>
                            </h6>
                            <div class="d-flex align-items-center text-muted small">
                                <span class="me-3">
                                    <i class="fas fa-utensils me-1"></i>
                                    {{ $receta->user->recetas->count() }} recetas
                                </span>
                                <span class="me-3">
                                    <i class="fas fa-users me-1"></i>
                                    {{ $receta->user->seguidores->count() }} seguidores
                                </span>
                                <span>
                                    <i class="fas fa-calendar me-1"></i>
                                    Publicada {{ $receta->created_at->diffForHumans() }}
                                </span>
                            </div>
                            
                            @if($receta->user->descripcion)
                                <p class="mb-0 mt-2 text-muted small">
                                    "{{ Str::limit($receta->user->descripcion, 80) }}"
                                </p>
                            @endif
                        </div>
                        
                        <!-- Botón seguir/dejar de seguir -->
                        @auth
                            @if(Auth::id() !== $receta->user->id)
                                <div class="ms-3">
                                    <form action="{{ route('users.toggleFollow', $receta->user) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ Auth::user()->siguiendo->contains($receta->user->id) ? 'btn-outline-danger' : 'btn-primary' }} follow-author-btn">
                                            <i class="{{ Auth::user()->siguiendo->contains($receta->user->id) ? 'fas fa-user-minus' : 'fas fa-user-plus' }} me-1"></i>
                                            {{ Auth::user()->siguiendo->contains($receta->user->id) ? 'Dejar de seguir' : 'Seguir' }}
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @else
                            <div class="ms-3">
                                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-sign-in-alt me-1"></i>Seguir
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
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
                                        @if($receta->dificultad == 'Fácil')
                                            Fácil
                                        @elseif($receta->dificultad == 'Media')
                                            Media
                                        @elseif($receta->dificultad == 'Difícil')
                                            Difícil
                                        @else
                                            {{ $receta->dificultad ?? 'No especificada' }}
                                        @endif
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
                
                <!-- Resumen de Valoraciones -->
                @if($totalValoraciones > 0)
                    <div class="rating-summary">
                        <div class="average-rating">{{ number_format($puntuacionPromedio, 1) }}</div>
                        <div class="rating-stars small-stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($puntuacionPromedio))
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        <p class="mb-3">Basado en {{ $totalValoraciones }} valoración{{ $totalValoraciones != 1 ? 'es' : '' }}</p>
                        
                        <div class="rating-distribution">
                            @for($i = 5; $i >= 1; $i--)
                                <div class="row align-items-center justify-content-center mb-1">
                                    <div class="col-auto">
                                        <small>{{ $i }} estrella{{ $i != 1 ? 's' : '' }}</small>
                                    </div>
                                    <div class="col-auto">
                                        <div class="rating-bar">
                                            <div class="rating-bar-fill" style="width: {{ $totalValoraciones > 0 ? ($distribuccionValoraciones[$i] / $totalValoraciones) * 100 : 0 }}%"></div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <small>{{ $distribuccionValoraciones[$i] }}</small>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                @endif
                
                <!-- Comentarios y Valoraciones -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h3>Comentarios y Valoraciones ({{ $receta->comentarios->count() }})</h3>                        

                        <!-- Formulario comentario y valoración (usuarios autenticados) -->
                        @auth
                            <div class="user-rating-form">
                                <h5 class="mb-3">Comparte tu experiencia</h5>
        
                                <!-- Verificar si ya comentó/valoró -->
                                @php
                                    $yaComento = $receta->comentarios()->where('user_id', Auth::id())->exists();
                                    $yaValoro = $receta->valoraciones()->where('user_id', Auth::id())->exists();
                                @endphp
                                
                                @if($yaComento || $yaValoro)
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Ya has valorado y comentado esta receta. ¡Gracias por tu participación!
                                    </div>
                                @else
                            <form action="{{ route('comentarios.storeWithRating', $receta) }}" method="POST" id="rating-comment-form">
                        @csrf
                
                <!-- Valoración con estrellas (OBLIGATORIA) -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Tu valoración <span class="text-danger">*</span>:</label>
                            <div class="rating-stars" id="user-rating">
                                <i class="far fa-star" data-rating="1"></i>
                                <i class="far fa-star" data-rating="2"></i>
                                <i class="far fa-star" data-rating="3"></i>
                                <i class="far fa-star" data-rating="4"></i>
                                <i class="far fa-star" data-rating="5"></i>
                            </div>
                            <input type="hidden" name="puntuacion" id="puntuacion-input" value="" required>
                            <small class="text-muted">Haz clic en las estrellas para valorar (obligatorio)</small>
                            @error('puntuacion')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                
                <!-- Comentario-->
                        <div class="mb-3">
                            <label for="contenido" class="form-label fw-bold">Tu comentario <span class="text-danger">*</span>:</label>
                            <textarea name="contenido" id="contenido" rows="4" 
                                      class="form-control @error('contenido') is-invalid @enderror" 
                                      placeholder="Comparte tu experiencia con esta receta..." required>{{ old('contenido') }}</textarea>
                            @error('contenido')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        
                                    <button type="submit" class="btn btn-primary" id="submit-button" disabled>
                                        <i class="fas fa-paper-plane me-2"></i>Publicar Comentario y Valoración
                                    </button>
                                    <small class="text-muted d-block mt-2">* Ambos campos son obligatorios</small>
                                </form>
                            @endif
                        </div>
                    @else
                        <div class="alert alert-info">
                            <a href="{{ route('login') }}">Inicia sesión</a> para dejar un comentario y valoración.
                        </div>
                    @endauth
                        

                        <!-- Lista comentarios -->
                         <div class="comentarios-lista mt-4">
                            @forelse($receta->comentarios->sortByDesc('fecha') as $comentario)
                                <div class="comentario mb-3 p-3 border rounded bg-light">
                                    <div class="comment-meta">
                                        <div>
                                            <a href="{{ route('users.show', $comentario->user) }}" class="user-name">{{ $comentario->user->nombre }}</a>
                                            <small class="text-muted d-block">{{ $comentario->fecha->format('d/m/Y H:i') }}</small>
                                        </div>
                                        
                                        @php
                                            $valoracionComentario = $receta->valoraciones->where('user_id', $comentario->user_id)->first();
                                        @endphp
                                        
                                        @if($valoracionComentario)
                                            <div class="comment-rating">
                                                <div class="rating-stars small-stars">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $valoracionComentario->puntuacion)
                                                            <i class="fas fa-star"></i>
                                                        @else
                                                            <i class="far fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <span class="rating-badge">{{ $valoracionComentario->puntuacion }}/5</span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div id="comentario-content-{{ $comentario->id }}">
                                            <p class="mb-0">{{ $comentario->contenido }}</p>
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
                                                    <i class="fas fa-edit me-1"></i>Editar
                                                </button>
                                                <form action="{{ route('comentarios.destroy', $comentario) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                            onclick="return confirm('¿Estás seguro de que quieres eliminar este comentario?')">
                                                        <i class="fas fa-trash me-1"></i>Eliminar
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

    // Sistema de valoración obligatoria con comentario
    document.addEventListener('DOMContentLoaded', function() {
        const ratingStars = document.querySelectorAll('#user-rating .fa-star');
        const puntuacionInput = document.getElementById('puntuacion-input');
        const contenidoTextarea = document.getElementById('contenido');
        const submitButton = document.getElementById('submit-button');
        let selectedRating = 0;
        
        // Función para validar formulario
        function validateForm() {
            const hasRating = selectedRating > 0;
            const hasComment = contenidoTextarea && contenidoTextarea.value.trim().length > 0;
            
            if (submitButton) {
                submitButton.disabled = !(hasRating && hasComment);
            }
        }
        
        // Eventos para las estrellas
        if (ratingStars.length > 0) {
            ratingStars.forEach(star => {
                star.addEventListener('mouseenter', function() {
                    const rating = parseInt(this.getAttribute('data-rating'));
                    highlightStars(rating);
                });
                
                star.addEventListener('mouseleave', function() {
                    highlightStars(selectedRating);
                });
                
                star.addEventListener('click', function() {
                    selectedRating = parseInt(this.getAttribute('data-rating'));
                    highlightStars(selectedRating);
                    if (puntuacionInput) {
                        puntuacionInput.value = selectedRating;
                    }
                    validateForm();
                });
            });
        }
        
        // Evento para el textarea
        if (contenidoTextarea) {
            contenidoTextarea.addEventListener('input', validateForm);
        }
        
        function highlightStars(rating) {
            ratingStars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('far');
                    star.classList.add('fas');
                } else {
                    star.classList.remove('fas');
                    star.classList.add('far');
                }
            });
        }
        
        // Validación inicial
        validateForm();
    });

    // Hacer clickeable toda la tarjeta del autor
    document.addEventListener('DOMContentLoaded', function() {
        const authorCard = document.querySelector('.author-card');
        if (authorCard) {
            authorCard.addEventListener('click', function(e) {
                if (!e.target.closest('.follow-author-btn')) {
                    const authorLink = this.querySelector('.author-link');
                    if (authorLink) {
                        window.location.href = authorLink.href;
                    }
                }
            });
        }
    });
</script>

</html>
