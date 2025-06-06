@extends('layouts.app')

@section('title', 'Editar Perfil')

@section('content')
<style>
    body {
        background:linear-gradient( to left, #E0C3FC,#8EC5FC);
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
    
    .image-preview-container {
        position: relative;
        display: inline-block;
    }
    
    .image-preview {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #dee2e6;
        transition: all 0.3s ease;
    }
    
    .image-preview:hover {
        transform: scale(1.05);
        border-color: #0d6efd;
    }
    
    .image-upload-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.6);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        cursor: pointer;
    }
    
    .image-preview-container:hover .image-upload-overlay {
        opacity: 1;
    }
    
    .upload-icon {
        color: white;
        font-size: 1.5rem;
    }
    
    .file-input-custom {
        display: none;
    }
    

    .custom-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        display: none;
        justify-content: center;
        align-items: center;
        animation: fadeIn 0.3s ease;
    }
    
    .custom-modal-overlay.show {
        display: flex;
    }
    
    .custom-modal {
        background: white;
        border-radius: 0.5rem;
        max-width: 500px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        animation: slideIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes slideIn {
        from { 
            opacity: 0; 
            transform: scale(0.9) translateY(-50px); 
        }
        to { 
            opacity: 1; 
            transform: scale(1) translateY(0); 
        }
    }
    
    .custom-modal-header {
        background-color: #dc3545;
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 0.5rem 0.5rem 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .custom-modal-body {
        padding: 1.5rem;
    }
    
    .custom-modal-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid #dee2e6;
        display: flex;
        justify-content: flex-end;
        gap: 0.5rem;
    }
    
    .close-btn {
        background: none;
        border: none;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: background-color 0.2s;
    }
    
    .close-btn:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }
</style>

<div class="container">
    <div class="row mb-5 justify-content-center">
        <div class="col-md-10">
            <h2 class="text-center mb-4">Editar Perfil</h2>
            
            <!-- Sección para editar perfil -->
            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="card-title mb-4">Información personal</h3>
                    
                    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" 
                                value="{{ old('nombre', $user->nombre) }}">
                            @error('nombre')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                value="{{ old('email', $user->email) }}">
                            @error('email')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" 
                                rows="3">{{ old('descripcion', $user->descripcion ?? '') }}</textarea>
                            @error('descripcion')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Sección mejorada de foto de perfil -->
						<div class="mb-4">
							<label class="form-label">Foto de Perfil</label>

							<!-- Preview de la imagen -->
							<div class="text-center mb-3">
								<div class="image-preview-container" onclick="triggerFileInput()">
									<img id="imagePreview" 
										 src="{{ isset($user->foto_perfil) && $user->foto_perfil ? asset('fotos_perfil/' . $user->foto_perfil) : asset('images/x_defecto.jpg') }}" 
										 alt="Preview de foto de perfil" 
										 class="image-preview"
										 onerror="this.src='{{ asset('images/x_defecto.jpg') }}';this.onerror=null;">

									<div class="image-upload-overlay">
										<i class="fas fa-camera upload-icon"></i>
									</div>
								</div>

								<div class="mt-2">
									<small class="text-muted">Haz clic en la imagen para cambiarla</small>
								</div>
							</div>

							<!-- Input de archivo oculto -->
							<input type="file" 
								   class="file-input-custom @error('foto_perfil') is-invalid @enderror" 
								   id="foto_perfil" 
								   name="foto_perfil" 
								   accept="image/*"
								   onchange="previewImage(this)">

							<!-- Botones de acción -->
							<div class="text-center">
								<button type="button" class="btn btn-outline-primary btn-sm me-2" onclick="triggerFileInput()">
									<i class="fas fa-upload me-1"></i>Seleccionar imagen
								</button>

								@if(isset($user->foto_perfil) && $user->foto_perfil)
									<button type="button" class="btn btn-outline-danger btn-sm" onclick="removeImage()">
										<i class="fas fa-trash me-1"></i>Eliminar imagen
									</button>
								@endif
							</div>

							@error('foto_perfil')
								<div class="invalid-feedback d-block text-center mt-2">{{ $message }}</div>
							@enderror

							<div class="form-text text-center mt-2">
								Formatos aceptados: JPG, PNG, GIF. Tamaño máximo: 10MB.
							</div>
						</div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Guardar
                        </button>
                        
                        @if (session('status') === 'profile-updated')
                            <div class="alert alert-success mt-3" role="alert">
                                Perfil actualizado correctamente.
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Sección para actualizar contraseña -->
            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="card-title mb-4">Actualizar Contraseña</h3>
                    
                    <form method="post" action="{{ route('profile.updatePassword') }}">
                        @csrf
                        @method('put')
                        
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Contraseña Actual</label>
                            <input type="password" class="form-control" id="current_password" name="current_password">
                            @error('current_password')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Nueva Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password">
                            @error('password')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-lock me-1"></i>Actualizar Contraseña
                        </button>
                        
                        @if (session('success'))
                            <div class="alert alert-success mt-3" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Sección para eliminar cuenta -->
            <div class="card border-danger">
                <div class="card-body">
                    <h3 class="card-title text-danger mb-4">Eliminar Cuenta</h3>
                    
                    <p class="mb-4 text-muted">
                        Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán permanentemente borrados.
                        Antes de eliminar tu cuenta, por favor descarga cualquier dato o información que desees conservar.
                    </p>
                    
                    <button type="button" class="btn btn-danger" onclick="openDeleteModal()">
                        <i class="fas fa-trash-alt me-1"></i>Eliminar Cuenta
                    </button>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <a href="{{ route('users.show', Auth::user()) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Volver a mi perfil
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal personalizado para confirmar eliminación -->
<div id="deleteAccountModal" class="custom-modal-overlay" onclick="closeDeleteModal(event)">
    <div class="custom-modal" onclick="event.stopPropagation()">
        <div class="custom-modal-header">
            <h5>
                <i class="fas fa-exclamation-triangle me-2"></i>Confirmar eliminación
            </h5>
            <button type="button" class="close-btn" onclick="closeDeleteModal()" aria-label="Cerrar">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="custom-modal-body">
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <div>
                    <strong>¡Atención!</strong> Esta acción no se puede deshacer.
                </div>
            </div>
            
            <p class="mb-3">¿Estás seguro de que quieres eliminar tu cuenta permanentemente?</p>
            <p class="text-muted small mb-4">
                Todos tus datos, recetas, colecciones y configuraciones serán eliminados de forma permanente.
                Por favor, ingresa tu contraseña para confirmar esta acción.
            </p>
            
            <form id="delete-account-form" method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                
                <div class="mb-3">
                    <label for="delete-password" class="form-label">
                        <i class="fas fa-lock me-1"></i>Contraseña Actual
                    </label>
                    <input type="password" 
                           class="form-control" 
                           id="delete-password" 
                           name="password" 
                           placeholder="Ingresa tu contraseña actual"
                           required
                           autocomplete="current-password">
                    <div id="password-error" class="text-danger mt-1" style="display: none;"></div>
                </div>
            </form>
        </div>
        
        <div class="custom-modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">
                <i class="fas fa-times me-1"></i>Cancelar
            </button>
            <button type="button" class="btn btn-danger" id="confirm-delete-btn" onclick="submitDeleteForm()">
                <i class="fas fa-trash-alt me-1"></i>Eliminar Cuenta Permanentemente
            </button>
        </div>
    </div>
</div>

<script>
// Variables globales
const deleteModal = document.getElementById('deleteAccountModal');
const passwordInput = document.getElementById('delete-password');
const passwordError = document.getElementById('password-error');
const confirmBtn = document.getElementById('confirm-delete-btn');

// Variables para el preview de imagen
const imagePreview = document.getElementById('imagePreview');
const fileInput = document.getElementById('foto_perfil');
const defaultImageUrl = "{{ asset('images/x_defecto.jpg') }}";
let originalImageSrc = imagePreview.src;

// Funciones para el manejo de imágenes
function triggerFileInput() {
    fileInput.click();
}

function previewImage(input) {
    const file = input.files[0];
    
    if (file) {
        // Validar tipo de archivo
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        if (!validTypes.includes(file.type)) {
            alert('Por favor, selecciona un archivo de imagen válido (JPG, PNG, GIF).');
            input.value = '';
            return;
        }
        
        // Validar tamaño (10MB)
        const maxSize = 10 * 1024 * 1024; // 10MB in bytes
        if (file.size > maxSize) {
            alert('El archivo es demasiado grande. El tamaño máximo es 10MB.');
            input.value = '';
            return;
        }
        
        // Mostrar preview
        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreview.src = e.target.result;
            console.log('Preview actualizado con nueva imagen');
        };
        reader.onerror = function() {
            console.error('Error al leer el archivo');
            alert('Error al procesar la imagen. Inténtalo de nuevo.');
            imagePreview.src = defaultImageUrl;
        };
        reader.readAsDataURL(file);
    }
}

function removeImage() {
    if (confirm('¿Estás seguro de que quieres eliminar la imagen de perfil?')) {
        imagePreview.src = defaultImageUrl;
        fileInput.value = '';
        console.log('Imagen eliminada del preview');
    }
}

// Funciones del modal de eliminación
function openDeleteModal() {
    deleteModal.classList.add('show');
    document.body.style.overflow = 'hidden';
    
    setTimeout(() => {
        passwordInput.focus();
        passwordInput.select();
    }, 100);
}

function closeDeleteModal(event) {
    if (event && event.target !== deleteModal) {
        return;
    }
    
    deleteModal.classList.remove('show');
    document.body.style.overflow = '';
    
    passwordInput.value = '';
    passwordInput.classList.remove('is-invalid');
    passwordError.style.display = 'none';
    passwordError.textContent = '';
    
    confirmBtn.disabled = false;
    confirmBtn.innerHTML = '<i class="fas fa-trash-alt me-1"></i>Eliminar Cuenta Permanentemente';
}

function showPasswordError(message) {
    passwordInput.classList.add('is-invalid');
    passwordError.textContent = message;
    passwordError.style.display = 'block';
}

function hidePasswordError() {
    passwordInput.classList.remove('is-invalid');
    passwordError.style.display = 'none';
    passwordError.textContent = '';
}

function submitDeleteForm() {
    const password = passwordInput.value.trim();
    
    if (!password) {
        showPasswordError('Por favor, ingresa tu contraseña para confirmar la eliminación.');
        passwordInput.focus();
        return false;
    }
    
    hidePasswordError();
    
    if (confirm('¿Estás completamente seguro? Esta acción NO se puede deshacer.')) {
        confirmBtn.disabled = true;
        confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Eliminando...';
        
        document.getElementById('delete-account-form').submit();
    }
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado - Inicializando funciones de imagen');
    
    // Guardar la imagen original para referencia
    originalImageSrc = imagePreview.src;
    
    // Event listener para el input de archivo
    fileInput.addEventListener('change', function(e) {
        console.log('Archivo seleccionado:', e.target.files[0]);
        previewImage(this);
    });
    
    // Cerrar modal con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && deleteModal.classList.contains('show')) {
            closeDeleteModal();
        }
    });
    
    // Enter en el campo de contraseña
    passwordInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            submitDeleteForm();
        }
    });
    
    // Limpiar error cuando se escriba
    passwordInput.addEventListener('input', function() {
        if (this.value.trim().length > 0) {
            hidePasswordError();
        }
    });
    
    // Mostrar modal si hay errores del servidor
    @if($errors->has('delete_password') || session('show_delete_modal'))
        setTimeout(function() {
            openDeleteModal();
            @if($errors->has('delete_password'))
                showPasswordError('{{ $errors->first('delete_password') }}');
            @endif
        }, 100);
    @endif
});

    // Prevenir el scroll del body cuando el modal esté abierto
    deleteModal.addEventListener('wheel', function(e) {
        e.stopPropagation();
    });
    
    // Manejo de errores de carga de imagen 
    imagePreview.addEventListener('error', function() {
        console.log('Error cargando imagen, usando imagen por defecto');
        this.src = defaultImageUrl;
        this.onerror = null; // Evitar bucle infinito
    });
    
    // Agregar evento load para verificar que la imagen se carga correctamente
    imagePreview.addEventListener('load', function() {
        console.log('Imagen cargada correctamente:', this.src);
});
</script>
@endsection
