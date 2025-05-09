<x-layout>
    <x-slot name="title">
        Editar Perfil
    </x-slot>
    
    <x-slot name="content">
        <h1 class="text-2xl font-bold mb-6">Editar Perfil</h1>
        
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
        
        <!-- Sección para eliminar cuenta -->
        <div class="mt-8 pt-8 border-t">
            <h2 class="text-xl font-bold mb-4 text-red-600">Eliminar Cuenta</h2>
            
            <p class="mb-4 text-gray-600">
                Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán permanentemente borrados.
                Antes de eliminar tu cuenta, por favor descarga cualquier dato o información que desees conservar.
            </p>
            
            <button type="button" 
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded"
                    onclick="document.getElementById('confirm-delete-modal').classList.remove('hidden')">
                Eliminar Cuenta
            </button>
            
            <!--confirmar eliminación -->
            <div id="confirm-delete-modal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4">
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
                    <h3 class="text-lg font-bold mb-4">¿Estás seguro de que quieres eliminar tu cuenta?</h3>
                    
                    <p class="mb-4 text-gray-600">
                        Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán permanentemente borrados.
                        Por favor, ingresa tu contraseña para confirmar que deseas eliminar permanentemente tu cuenta.
                    </p>
                    
                    <form method="post" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('delete')
                        
                        <div class="mb-4">
                            <label for="delete_password" class="sr-only">Contraseña</label>
                            <input type="password" id="delete_password" name="password" 
                                   class="w-full px-3 py-2 border rounded" placeholder="Contraseña">
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="button" 
                                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded mr-2"
                                    onclick="document.getElementById('confirm-delete-modal').classList.add('hidden')">
                                Cancelar
                            </button>
                            
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                                Eliminar Cuenta
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>
</x-layout>