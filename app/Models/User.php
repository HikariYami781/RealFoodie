<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Authorizable;
    
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
        return $this->belongsToMany(
            Receta::class,     // Modelo relacionado
            'favoritos',       // Tabla pivote
            'user_id',         // Clave foránea del usuario en la tabla pivote
            'receta_id'        // Clave foránea de la receta en la tabla pivote
        )->withTimestamps();
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
