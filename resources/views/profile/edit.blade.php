<!-- Archivo: resources/views/profile/edit.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Editar Perfil</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Editar Perfil</h1>
        
        <!-- Alertas -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Editar -->
        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('put')
            
            <div class="mb-4">
                <label for="nombre" class="block text-gray-700 mb-2">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $user->nombre) }}" 
                       class="w-full px-3 py-2 border rounded">
                @error('nombre')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="email" class="block text-gray-700 mb-2">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" 
                       class="w-full px-3 py-2 border rounded">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="descripcion" class="block text-gray-700 mb-2">Descripción</label>
                <textarea id="descripcion" name="descripcion" class="w-full px-3 py-2 border rounded" rows="3">{{ old('descripcion', $user->descripcion ?? '') }}</textarea>
                @error('descripcion')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="foto_perfil" class="block text-gray-700 mb-2">Foto de Perfil</label>
                <input type="file" id="foto_perfil" name="foto_perfil" class="w-full">
                @error('foto_perfil')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                
                @if(isset($user->foto_perfil) && $user->foto_perfil)
                    <div class="mt-2">
                        <img src="{{ asset('storage/fotos_perfil/' . $user->foto_perfil) }}" 
                             alt="Foto de perfil" class="h-20 w-20 rounded-full object-cover">
                    </div>
                @endif
            </div>
            
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Guardar
            </button>
        </form>
        
        <!-- Actualizar Contraseña-->
        <div class="mt-8">
            <h2 class="text-xl font-bold mb-4">Actualizar Contraseña</h2>
            
            <form method="post" action="{{ route('profile.updatePassword') }}">
                @csrf
                @method('put')
                
                <div class="mb-4">
                    <label for="current_password" class="block text-gray-700 mb-2">Contraseña Actual</label>
                    <input type="password" id="current_password" name="current_password" 
                           class="w-full px-3 py-2 border rounded">
                    @error('current_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 mb-2">Nueva Contraseña</label>
                    <input type="password" id="password" name="password" 
                           class="w-full px-3 py-2 border rounded">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-gray-700 mb-2">Confirmar Contraseña</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" 
                           class="w-full px-3 py-2 border rounded">
                </div>
                
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Actualizar Contraseña
                </button>
            </form>
        </div>
    </div>
</body>
</html>