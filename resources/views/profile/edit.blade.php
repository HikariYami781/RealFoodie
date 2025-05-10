@extends('layouts.app')

@section('content')
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
                        
                        <div class="mb-4">
                            <label for="foto_perfil" class="form-label">Foto de Perfil</label>
                            <input type="file" class="form-control" id="foto_perfil" name="foto_perfil">
                            @error('foto_perfil')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                            
                            @if(isset($user->foto_perfil) && $user->foto_perfil)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/fotos_perfil/' . $user->foto_perfil) }}" 
                                        alt="Foto de perfil" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                                </div>
                            @endif
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
                    
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        <i class="fas fa-trash-alt me-1"></i>Eliminar Cuenta
                    </button>
                    
                    <!-- Modal para confirmar eliminación -->
                    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteAccountModalLabel">Confirmar eliminación</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>¿Estás seguro de que quieres eliminar tu cuenta?</p>
                                    <p class="text-muted small">Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán permanentemente borrados.
                                    Por favor, ingresa tu contraseña para confirmar que deseas eliminar permanentemente tu cuenta.</p>
                                    
                                    <form id="delete-account-form" method="post" action="{{ route('profile.destroy') }}">
                                        @csrf
                                        @method('delete')
                                        
                                        <div class="mb-3">
                                            <label for="delete-password" class="form-label">Contraseña</label>
                                            <input type="password" class="form-control" id="delete-password" name="password">
                                            @error('password', 'userDeletion')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" form="delete-account-form" class="btn btn-danger">Eliminar Cuenta</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <a href="{{ route('users.show', Auth::user()) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Volver a mi perfil
                </a>
            </div>
        </div>
    </div>
</div>
@endsection