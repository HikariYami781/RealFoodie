<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
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
        // Mantener la implementación exacta del método original
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
        
        if ($request->hasFile('foto_perfil')) {
            // Eliminar foto anterior si existe
            if ($user->foto_perfil) {
                Storage::delete('public/fotos_perfil/' . $user->foto_perfil);
            }
            
            $fotoPath = $request->file('foto_perfil')->store('public/fotos_perfil');
            $validatedData['foto_perfil'] = basename($fotoPath);
        }
        
        $user->fill($validatedData);
        
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        
        $user->save();
        
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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