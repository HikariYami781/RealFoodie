<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a user's public profile.
     */
    public function show(User $user)
    {
        // Cargamos las relaciones básicas
        $user->load(['recetas.categoria', 'recetas.valoraciones', 'recetas.user']);
        
        // Cargamos la relación recetasFavoritas con sus relaciones
        $user->load(['recetasFavoritas.categoria', 'recetasFavoritas.valoraciones', 'recetasFavoritas.user']);
        
        // Cargamos las colecciones
        $user->load('colecciones');
        
        // Filtramos solo las recetas públicas del usuario para mostrar
        $recetas = $user->recetas()->where('publica', true)->paginate(9);
        
        // También podemos paginar las favoritas si hay muchas
        $favoritas = $user->recetasFavoritas()->paginate(9);
        
        return view('profile.show', compact('user', 'recetas', 'favoritas'));
    }
    
    /**
     * Toggle follow/unfollow a user.
     */
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
    
    /**
     * Display a user's followers.
     */
    public function followers(User $user)
    {
        $seguidores = $user->seguidores()->paginate(20);
        return view('users.followers', compact('user', 'seguidores'));
    }
    
    /**
     * Display who a user is following.
     */
    public function following(User $user)
    {
        $siguiendo = $user->siguiendo()->paginate(20);
        return view('users.following', compact('user', 'siguiendo'));
    }
}