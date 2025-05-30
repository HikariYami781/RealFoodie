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
            return back()->with('error', 'No puedes seguirte a ti mismo.');
        }
        
        $loggedUser = Auth::user();
        
        if ($loggedUser->siguiendo()->where('seguido_id', $user->id)->exists()) {
            $loggedUser->siguiendo()->detach($user->id);
            $message = 'Has dejado de seguir a ' . $user->nombre . '.';
        } else {
            $loggedUser->siguiendo()->attach($user->id);
            $message = 'Ahora estás siguiendo a ' . $user->nombre . '.';
        }
        
        return back()->with('success', $message);
    }
    
    /**
     * Display a user's followers.
     */
    public function followers(User $user)
    {
        // Cargamos los seguidores con sus relaciones necesarias para mostrar estadísticas
        $seguidores = $user->seguidores()
            ->withCount(['recetas', 'seguidores'])
            ->paginate(20);
        
        // Cargamos las relaciones del usuario principal
        $user->loadCount(['seguidores', 'siguiendo']);
        
        return view('seguidores.seguir', compact('user', 'seguidores'));
    }
    
    /**
     * Display who a user is following.
     */
    public function following(User $user)
    {
        // Cargamos a quién sigue con sus relaciones necesarias para mostrar estadísticas
        $siguiendo = $user->siguiendo()
            ->withCount(['recetas', 'seguidores'])
            ->paginate(20);
        
        // Cargamos las relaciones del usuario principal
        $user->loadCount(['seguidores', 'siguiendo']);
        
        return view('seguidores.siguiendo', compact('user', 'siguiendo'));
    }
    
    /**
     * Search users (opcional - para descubrir nuevos usuarios)
     */
    public function index(Request $request)
    {
        $query = User::query();
        
        if ($request->filled('search')) {
            $query->where('nombre', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }
        
        $usuarios = $query->withCount(['recetas', 'seguidores'])
            ->paginate(12);
        
        return view('users.index', compact('usuarios'));
    }
}