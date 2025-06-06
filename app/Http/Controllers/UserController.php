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
        $user->load(['recetas.categoria', 'recetas.valoraciones', 'recetas.user']);
        $user->load(['recetasFavoritas.categoria', 'recetasFavoritas.valoraciones', 'recetasFavoritas.user']);
        $user->load('colecciones');
        
        // Filtramos solo las recetas públicas del usuario para mostrar
        $recetas = $user->recetas()->where('publica', true)->paginate(9);
        $favoritas = $user->recetasFavoritas()->paginate(9);
        $user->profile_image_url = $this->getProfileImage($user);
        
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
        // Cargamos los seguidores 
        $seguidores = $user->seguidores()
            ->withCount(['recetas', 'seguidores'])
            ->paginate(20);
        
        $seguidores->getCollection()->transform(function ($seguidor) {
            $seguidor->profile_image_url = $this->getProfileImage($seguidor);
            return $seguidor;
        });
        
        $user->loadCount(['seguidores', 'siguiendo']);
        $user->profile_image_url = $this->getProfileImage($user);
        
        return view('seguidores.seguir', compact('user', 'seguidores'));
    }
    
    
    /**
     * Display who a user is following.
     */
    public function following(User $user)
    {

        $siguiendo = $user->siguiendo()
            ->withCount(['recetas', 'seguidores'])
            ->paginate(20);
        
        $siguiendo->getCollection()->transform(function ($seguido) {
            $seguido->profile_image_url = $this->getProfileImage($seguido);
            return $seguido;
        });

        $user->loadCount(['seguidores', 'siguiendo']);
        $user->profile_image_url = $this->getProfileImage($user);
        
        return view('seguidores.siguiendo', compact('user', 'siguiendo'));
    }
    
    
    /**
     * Search users
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
    
	
	/**
     * Helper method para obtener la imagen de perfil o la por defecto
     */
    private function getProfileImage($user)
    {
        if ($user->foto_perfil && file_exists(storage_path('app/public/fotos_perfil/' . $user->foto_perfil))) {
            return asset('storage/fotos_perfil/' . $user->foto_perfil);
        }
        
        // Verifica que la imagen por defecto existe
        $defaultImage = public_path('images/x_defecto.jpg');
        if (file_exists($defaultImage)) {
            return asset('images/x_defecto.jpg');
        }
        
        // Fallback a una imagen en línea si no existe localmente
        return 'https://via.placeholder.com/80x80/cccccc/666666?text=Usuario';
    }
}
