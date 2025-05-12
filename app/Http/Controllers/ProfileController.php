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
        $user->load(['recetas.categoria', 'recetas.valoraciones', 'recetas.user', 'recetasFavoritas.user', 'recetasFavoritas.valoraciones', 'colecciones']);
        $recetas = $user->recetas()->where('publica', true)->paginate(9);
        
        return view('profile.show', compact('user', 'recetas'));
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
            'foto_perfil' => 'nullable|image|max:2048',
        ]);
        
        try {
            // Extraer datos validados para actualizar el usuario
            $dataToUpdate = [
                'nombre' => $validatedData['nombre'],
                'email' => $validatedData['email'],
                'descripcion' => $validatedData['descripcion'] ?? $user->descripcion,
            ];
            
            // Verificar si hay archivo y es válido
            if ($request->hasFile('foto_perfil') && $request->file('foto_perfil')->isValid()) {
                // Eliminar foto anterior si existe
                if ($user->foto_perfil) {
                    Storage::disk('public')->delete('fotos_perfil/' . $user->foto_perfil);
                }
                
                // Generar un nombre único para el archivo
                $filename = time() . '_' . $request->file('foto_perfil')->getClientOriginalName();
                
                // Almacenar el archivo en el disco público (no incluir 'public/' en la ruta)
                $request->file('foto_perfil')->storeAs('fotos_perfil', $filename, 'public');
                
                // Actualizar el nombre del archivo en la base de datos
                $dataToUpdate['foto_perfil'] = $filename;
                
                // Registrar éxito para depuración
                Log::info('Archivo subido correctamente: ' . $filename);
            }
            
            // Verificar si el email ha cambiado
            if ($user->email !== $validatedData['email']) {
                $dataToUpdate['email_verified_at'] = null;
            }
            
            // Actualizar el usuario
            $user->update($dataToUpdate);
            
            return Redirect::route('profile.edit')->with('status', 'profile-updated');
        } catch (\Exception $e) {
            // Registrar el error para depuración
            Log::error('Error al actualizar el perfil: ' . $e->getMessage());
            
            return Redirect::route('profile.edit')->withErrors([
                'foto_perfil' => 'Hubo un problema al subir la imagen: ' . $e->getMessage()
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
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}