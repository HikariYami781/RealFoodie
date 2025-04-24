<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function show(User $user)
    {
        $user->load('recetas.categoria');
        $recetas = $user->recetas()->where('publica', true)->paginate(9);
        
        return view('recetas.usu', compact('user', 'recetas'));
    }
    
    public function edit()
    {
        $user = Auth::user();
        return view('users.edit', compact('user'));
    }
    
    public function update(Request $request)
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
        
        $user->update($validatedData);
        
        return redirect()->route('profile.edit')
                        ->with('success', 'Perfil actualizado correctamente.');
    }
    
    public function updatePassword(Request $request)
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
    
    public function toggleFollow(User $user)
    {
        if (!Auth::check() || Auth::id() === $user->id) {
            return back();
        }
        
        $loggedUser = Auth::user();
        
        if ($loggedUser->siguiendo()->where('seguido_id', $user->id)->exists()) {
            $loggedUser->siguiendo()->detach($user->id);
            $message = 'Has dejado de seguir a este usuario.';
        } else {
            $loggedUser->siguiendo()->attach($user->id);
            $message = 'Ahora estás siguiendo a este usuario.';
        }
        
        return back()->with('success', $message);
    }
    
    public function followers(User $user)
    {
        $seguidores = $user->seguidores()->paginate(20);
        return view('users.followers', compact('user', 'seguidores'));
    }
    
    public function following(User $user)
    {
        $siguiendo = $user->siguiendo()->paginate(20);
        return view('users.following', compact('user', 'siguiendo'));
    }
}