@extends('layouts.app')

@section('title', 'Crear Nueva Colección')

@section('content')
<style>
    .cooking-bg {
        background: linear-gradient(135deg, #dda0dd 0%, #9370db 100%);
        min-height: 100vh;
        padding:  40px 0;
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
        background: linear-gradient(45deg, #667eea, #764ba2);
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
        background: linear-gradient(45deg, #5a67d8, #6b46c1);
    }
    
    .btn-secondary-custom {
        background: rgba(108, 117, 125, 0.1);
        border: 2px solid rgba(108, 117, 125, 0.2);
        border-radius: 12px;
        padding: 15px 30px;
        font-weight: 600;
        color: #6c757d;
        transition: all 0.3s ease;
    }
    
    .btn-secondary-custom:hover {
        background: rgba(108, 117, 125, 0.2);
        transform: translateY(-2px);
        color: #495057;
    }
    
    .info-card {
        background: linear-gradient(135deg, #ffeaa7, #fab1a0);
        border-radius: 15px;
        border: none;
        box-shadow: 0 10px 25px rgba(255, 234, 167, 0.3);
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
</style>

<div class="cooking-bg">
    <!-- Iconos flotantes decorativos -->
    <div class="floating-icons" style="top: 10%; left: 10%;">
        <i class="fas fa-utensils"></i>
    </div>
    <div class="floating-icons" style="top: 20%; right: 15%;">
        <i class="fas fa-cookie-bite"></i>
    </div>
    <div class="floating-icons" style="bottom: 30%; left: 5%;">
        <i class="fas fa-birthday-cake"></i>
    </div>
    <div class="floating-icons" style="bottom: 10%; right: 10%;">
        <i class="fas fa-pizza-slice"></i>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="content-wrapper">
                    <!-- Header mejorado -->
                    <div class="text-center mb-5">
                        <div class="mb-4">
                            <i class="fas fa-book-open cooking-icon" style="font-size: 4rem;"></i>
                        </div>
                        <h1 class="display-4 fw-bold text-white mb-3">
                            <i class="fas fa-plus-circle me-2"></i>
                            Crear Nueva Colección
                        </h1>
                    </div>

                    <!-- Formulario principal -->
                    <div class="recipe-card p-5 mb-4">
                        <form action="{{ route('colecciones.store') }}" method="POST">
                            @csrf

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
                                    value="{{ old('nombre') }}"
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
                                    placeholder="Cuéntanos sobre tu colección... ¿Qué tipo de recetas incluirá? ¿Para qué ocasiones?"
                                >{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="form-text text-muted mt-2">
                                    <i class="fas fa-lightbulb me-1"></i>
                                    Puedes agregar recetas a tu colección después de crearla.
                                </small>
                            </div>

                            <!-- Botones de acción -->
                            <div class="d-flex flex-column flex-md-row gap-3 justify-content-between align-items-center">
                                <a href="{{ url()->previous() != url()->current() ? url()->previous() : route('home') }}" 
                                   class="btn btn-secondary-custom order-2 order-md-1">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Cancelar
                                </a>
                                
                                <button type="submit" class="btn btn-primary-custom order-1 order-md-2">
                                    <i class="fas fa-plus-circle me-2"></i>
                                    Crear Mi Colección
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Tarjeta informativa mejorada -->
                    <div class="info-card p-4">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="text-center mb-3 mb-md-0">
                                    <i class="fas fa-chef-hat" style="font-size: 3rem; color: #e17055;"></i>
                                </div>
                            </div>
                            <div class="col">
                                <h5 class="fw-bold text-dark mb-3">
                                    <i class="fas fa-star me-2 text-warning"></i>
                                    ¿Sabías que...?
                                </h5>
                                <div class="mb-2">
                                    <small class="text-dark d-flex align-items-center">                                        
                                        <span>Aprendemos a cocinar con la cocina de otros y en un momento dado, hacemos la nuestra</span>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection