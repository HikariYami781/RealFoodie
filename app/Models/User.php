<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
/*use Laravel\Scout\Searchable;*/

class User extends Authenticatable
{
  use HasFactory, Notifiable,  Authorizable/*, Searchable*/;

    protected $fillable = [
        'nombre',         
        'email',
        'password',
        'foto_perfil',
        'descripcion'    
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function recetas()
    {
        return $this->hasMany(Receta::class);
    }

    public function colecciones()
    {
        return $this->hasMany(Coleccion::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class);
    }

    public function recetasFavoritas()
    {
        return $this->belongsToMany(Receta::class, 'favoritos')->withTimestamps();
    }

    public function seguidores()
    {
        return $this->belongsToMany(User::class, 'seguidores', 'seguido_id', 'seguidor_id')->withTimestamps();
    }

    public function siguiendo()
    {
        return $this->belongsToMany(User::class, 'seguidores', 'seguidor_id', 'seguido_id')->withTimestamps();
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'email' => $this->email,
            'descripcion' => $this->descripcion,
        ];
    }
}

/**Pasarle archivo al Claude y que me diga que está mal */