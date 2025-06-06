<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show()
    {
        $user = auth()->user();
        
        // Cargar las relaciones necesarias incluyendo las recetas favoritas
        $user->load([
            'recetas.categoria', 
            'recetas.valoraciones', 
            'recetas.user', 
            'recetasFavoritas.categoria',
            'recetasFavoritas.valoraciones', 
            'recetasFavoritas.user', 
            'colecciones'
        ]);
        
        // Obtener las recetas del usuario (públicas) con paginación
        $recetas = $user->recetas()->where('publica', true)->paginate(9, ['*'], 'recetas_page');
        
        // Obtener las recetas favoritas con paginación
        $favoritas = $user->recetasFavoritas()->where('publica', true)->paginate(9, ['*'], 'favoritas_page');
        
        return view('profile.show', compact('user', 'recetas', 'favoritas'));
    }
    

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }
    

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();
        
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'descripcion' => 'nullable|string',
            'fotos_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);
        
        try {
            $dataToUpdate = [
                'nombre' => $validatedData['nombre'],
                'email' => $validatedData['email'],
                'descripcion' => $validatedData['descripcion'] ?? $user->descripcion,
            ];
            
            if ($request->hasFile('foto_perfil')) {
                $file = $request->file('foto_perfil');
                
                Log::info('Procesando archivo: ' . $file->getClientOriginalName());

                if ($file->isValid()) {te
                    $publicDir = public_path('fotos_perfil');
                    if (!file_exists($publicDir)) {
                        mkdir($publicDir, 0755, true);
                        Log::info('Directorio creado: ' . $publicDir);
                    }

                    if ($user->foto_perfil) {
                        $oldFilePath = public_path('fotos_perfil/' . $user->foto_perfil);
                        if (file_exists($oldFilePath)) {
                            unlink($oldFilePath);
                            Log::info('Foto anterior eliminada: ' . $oldFilePath);
                        }
                    }
                    
                    $extension = $file->getClientOriginalExtension();
                    $filename = 'perfil_' . $user->id . '_' . time() . '.' . $extension;
                    
                    $destinationPath = public_path('fotos_perfil');
                    $moved = $file->move($destinationPath, $filename);
                    
                    if ($moved) {
                        $fullPath = public_path('fotos_perfil/' . $filename);
                        if (file_exists($fullPath)) {
                            chmod($fullPath, 0644);
                            $dataToUpdate['foto_perfil'] = $filename;
                            Log::info('Archivo guardado exitosamente: ' . $fullPath);
                        } else {
                            throw new \Exception('El archivo no se encontró después de moverlo');
                        }
                    } else {
                        throw new \Exception('No se pudo mover el archivo');
                    }
                } else {
                    throw new \Exception('El archivo no es válido');
                }
            }
            
            if ($user->email !== $validatedData['email']) {
                $dataToUpdate['email_verified_at'] = null;
            }
            
            $updated = $user->update($dataToUpdate);
            
            if ($updated) {
                Log::info('Usuario actualizado correctamente. ID: ' . $user->id);
                
                $user->refresh();
                Log::info('Foto de perfil en BD después de actualizar: ' . ($user->foto_perfil ?? 'null'));
                
                return Redirect::route('profile.edit')->with('status', 'profile-updated');
            } else {
                throw new \Exception('No se pudo actualizar el usuario en la base de datos');
            }
            
        } catch (\Exception $e) {
            Log::error('Error en update de perfil: ' . $e->getMessage());
            
            if (isset($filename)) {
                $errorPath = public_path('fotos_perfil/' . $filename);
                if (file_exists($errorPath)) {
                    unlink($errorPath);
                    Log::info('Archivo de error eliminado: ' . $errorPath);
                }
            }
            
            return Redirect::route('profile.edit')->withErrors([
                'foto_perfil' => 'Error al procesar la imagen: ' . $e->getMessage()
            ]);
        }
    }
    

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        $user = Auth::user();
        
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
        }
        
        $user->password = Hash::make($request->password);
        $user->save();
        
        return redirect()->route('profile.edit')
                        ->with('success', 'Contraseña actualizada correctamente.');
    }
    

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        $user = $request->user();
        
        if (!Hash::check($request->password, $user->password)) {
            return Redirect::route('profile.edit')
                ->withErrors(['delete_password' => 'La contraseña no es correcta.'])
                ->with('show_delete_modal', true);
        }

        try {
            if ($user->foto_perfil) {
                $photoPath = public_path('fotos_perfil/' . $user->foto_perfil);
                if (file_exists($photoPath)) {
                    unlink($photoPath);
                }
            }
            
            Auth::logout();
            $user->delete();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return Redirect::to('/')->with('success', 'Tu cuenta ha sido eliminada correctamente.');
            
        } catch (\Exception $e) {
            Log::error('Error al eliminar cuenta: ' . $e->getMessage());
            
            return Redirect::route('profile.edit')
                ->withErrors(['delete_password' => 'Hubo un error al eliminar la cuenta. Inténtalo de nuevo.'])
                ->with('show_delete_modal', true);
        }
    }
}
