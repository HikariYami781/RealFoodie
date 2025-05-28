@extends('layouts.app')

@section('title', 'Editar Colección')

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
    
    .form-control-custom {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 15px 20px;
        font-size: 16px;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.9);
    }
    
    .form-control-custom:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        background: rgba(255, 255, 255, 1);
        transform: translateY(-2px);
    }
    
    .btn-primary-custom {
        background: #32cd32;
        border: none;
        border-radius: 12px;
        padding: 15px 30px;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }
    
    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(102, 126, 234, 0.4);
        background: #32cd32;
    }
    
    .btn-secondary-custom {
        background: #ffd700;
        border: 2px solid rgba(108, 117, 125, 0.2);
        border-radius: 12px;
        padding: 15px 30px;
        font-weight: 600;
        color: #008b8b;
        transition: all 0.3s ease;
    }
    
    .btn-secondary-custom:hover {
        background: #ffd700;
        transform: translateY(-2px);
        color: #008b8b;
    }
    
    .btn-danger-custom {
        background: linear-gradient(45deg, #dc3545, #c82333);
        border: none;
        border-radius: 12px;
        padding: 15px 30px;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(220, 53, 69, 0.3);
    }
    
    .btn-danger-custom:hover {
        background: linear-gradient(45deg, #c82333, #bd2130);
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(220, 53, 69, 0.4);
        color: white;
    }
    
    
    .stats-card {
        background: linear-gradient(135deg, #74EBD5,#9FACE6);
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
    
    .modal-overlay {
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
    }
    
    .modal-content {
        background: white;
        border-radius: 20px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
        transform: scale(0.9);
        transition: all 0.3s ease;
    }
    
    .modal-content.show {
        transform: scale(1);
    }
</style>

<div class="cooking-bg">
    <!-- Iconos flotantes decorativos -->
    <div class="floating-icons" style="top: 10%; left: 10%;">
        <i class="fas fa-edit"></i>
    </div>
    <div class="floating-icons" style="top: 20%; right: 15%;">
        <i class="fas fa-book-open"></i>
    </div>
    <div class="floating-icons" style="bottom: 30%; left: 5%;">
        <i class="fas fa-cog"></i>
    </div>
    <div class="floating-icons" style="bottom: 10%; right: 10%;">
        <i class="fas fa-heart"></i>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-8">
                <div class="content-wrapper">
                    <!-- Header mejorado -->
                    <div class="text-center mb-5">
                        <div class="mb-4">
                            <i class="fas fa-edit cooking-icon" style="font-size: 4rem;"></i>
                        </div>
                        <h1 class="display-4 fw-bold text-white mb-3">
                            Editar Colección
                        </h1>
                        <p class="text-white opacity-75 lead">
                            Modifica los detalles de tu colección favorita
                        </p>
                    </div>

                    <!-- Tarjeta de estadísticas -->
                    <div class="stats-card p-4 mb-4">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="text-white">
                                    <h3 class="fw-bold mb-1">{{ $coleccion->recetas->count() }}</h3>
                                    <small class="opacity-75">{{ $coleccion->recetas->count() === 1 ? 'Receta' : 'Recetas' }}</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-white">
                                    <h3 class="fw-bold mb-1">{{ $coleccion->created_at->diffForHumans() }}</h3>
                                    <small class="opacity-75">Creada</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-white">
                                    <h3 class="fw-bold mb-1">{{ $coleccion->updated_at->format('d/m/Y') }}</h3>
                                    <small class="opacity-75">Actualizada</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulario principal -->
                    <div class="recipe-card p-5 mb-4">
                        <form action="{{ route('colecciones.update', $coleccion) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Nombre de la colección -->
                            <div class="mb-4">
                                <label for="nombre" class="form-label fw-bold text-dark mb-3">
                                    <i class="fas fa-tag me-2 text-primary"></i>
                                    Nombre de la Colección *
                                </label>
                                <input 
                                    type="text" 
                                    id="nombre" 
                                    name="nombre" 
                                    value="{{ old('nombre', $coleccion->nombre) }}"
                                    class="form-control form-control-custom @error('nombre') is-invalid @enderror"
                                    placeholder="Ej: Postres Favoritos, Comida Italiana, Recetas Rápidas..."
                                    required
                                    maxlength="255"
                                >
                                @error('nombre')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Descripción -->
                            <div class="mb-5">
                                <label for="descripcion" class="form-label fw-bold text-dark mb-3">
                                    <i class="fas fa-align-left me-2 text-info"></i>
                                    Descripción
                                </label>
                                <textarea 
                                    id="descripcion" 
                                    name="descripcion" 
                                    rows="4"
                                    class="form-control form-control-custom @error('descripcion') is-invalid @enderror"
                                    placeholder="Cuéntanos sobre tu colección... ¿Qué tipo de recetas incluye? ¿Para qué ocasiones?"
                                >{{ old('descripcion', $coleccion->descripcion) }}</textarea>
                                @error('descripcion')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="form-text text-muted mt-2">
                                    <i class="fas fa-lightbulb me-1"></i>
                                    Puedes seguir agregando más recetas después de guardar los cambios.
                                </small>
                            </div>

                            <!-- Botones de acción -->
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <a href="{{ route('colecciones.show', $coleccion) }}" 
                                       class="btn btn-secondary-custom w-100">
                                        <i class="fas fa-arrow-left me-2"></i>
                                        Cancelar
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" 
                                            onclick="confirmDelete()"
                                            class="btn btn-danger-custom w-100">
                                        <i class="fas fa-trash-alt me-2"></i>
                                        Eliminar
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary-custom w-100">
                                        <i class="fas fa-save me-2"></i>
                                        Guardar Cambios
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación para eliminar -->
<div id="delete-modal" class="modal-overlay position-fixed top-0 start-0 w-100 h-100 d-none" style="z-index: 1050;">
    <div class="d-flex align-items-center justify-content-center h-100 p-4">
        <div class="modal-content p-5" style="max-width: 500px; width: 100%;">
            <div class="text-center">
                <div class="mb-4">
                    <div class="mx-auto d-flex align-items-center justify-content-center rounded-circle bg-danger bg-opacity-10" 
                         style="width: 80px; height: 80px;">
                        <i class="fas fa-exclamation-triangle text-danger" style="font-size: 2rem;"></i>
                    </div>
                </div>
                
                <h3 class="fw-bold text-dark mb-3">¿Eliminar Colección?</h3>
                
                <div class="mb-4">
                    <p class="text-muted mb-3">
                        Estás a punto de eliminar la colección 
                        <strong class="text-dark">"{{ $coleccion->nombre }}"</strong>
                    </p>
                    <div class="alert alert-warning border-0 bg-warning bg-opacity-10">
                        <i class="fas fa-info-circle me-2 text-warning"></i>
                        <small>Esta acción no se puede deshacer. Las recetas no se eliminarán, solo se quitarán de esta colección.</small>
                    </div>
                </div>
                
                <div class="d-flex gap-3 justify-content-center">
                    <button id="cancel-delete" 
                            class="btn btn-secondary-custom">
                        <i class="fas fa-times me-2"></i>
                        Cancelar
                    </button>
                    <button id="confirm-delete" 
                            class="btn btn-danger-custom">
                        <i class="fas fa-trash-alt me-2"></i>
                        Sí, Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Formulario oculto para eliminar -->
<form id="delete-form" action="{{ route('colecciones.destroy', $coleccion) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
function confirmDelete() {
    const modal = document.getElementById('delete-modal');
    const modalContent = modal.querySelector('.modal-content');
    
    modal.classList.remove('d-none');
    
    // Pequeño delay para la animación
    setTimeout(() => {
        modalContent.classList.add('show');
    }, 10);
}

document.getElementById('confirm-delete').addEventListener('click', function() {
    document.getElementById('delete-form').submit();
});

document.getElementById('cancel-delete').addEventListener('click', function() {
    hideModal();
});

// Cerrar modal al hacer clic fuera
document.getElementById('delete-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideModal();
    }
});

function hideModal() {
    const modal = document.getElementById('delete-modal');
    const modalContent = modal.querySelector('.modal-content');
    
    modalContent.classList.remove('show');
    
    setTimeout(() => {
        modal.classList.add('d-none');
    }, 300);
}

// Escape key para cerrar modal
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('delete-modal');
        if (!modal.classList.contains('d-none')) {
            hideModal();
        }
    }
});
</script>

@endsection