<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'preparacion',
        'coccion',
        'dificultad',
        'porciones',
        'categoria_id',
        'user_id',
        'publica',
        'imagen',
    ];

    protected $casts = [
        'fecha_publicacion' => 'date',
        'publica' => 'boolean',
		'preparacion' => 'integer',
		'coccion' => 'integer',
		'porciones' => 'integer',
		'user_id' => 'integer',
		'categoria_id' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function pasos()
    {
        return $this->hasMany(Paso::class);
    }

    public function ingredientes()
    {
        return $this->belongsToMany(Ingrediente::class, 'receta_ingrediente')
                    ->withPivot('cantidad', 'unidad')
                    ->withTimestamps();
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function usuariosQueFavorecen()
    {
        return $this->belongsToMany(User::class, 'favoritos')->withTimestamps();
    }

    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class);
    }

    public function getPuntuacionPromedioAttribute()
    {
        return $this->valoraciones()->avg('puntuacion') ?? 0;
    }

   
    public function getTotalValoracionesAttribute()
    {
        return $this->valoraciones()->count();
    }

    public function colecciones()
    {
        return $this->belongsToMany(Coleccion::class, 'coleccion_receta')->withTimestamps();
    }

    public function toSearchableArray()
    {
        $categoria = $this->categoria;
        $user = $this->user;
        $ingredientes = $this->ingredientes->pluck('nombre')->toArray();

        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'descripcion' => $this->descripcion,
            'preparacion' => $this->preparacion,
            'dificultad' => $this->dificultad,
            'coccion' => $this->coccion,
            'porciones' => $this->porciones,
            'publica' => $this->publica,
            'categoria' => [
                'id' => $categoria->id,
                'nombre' => $categoria->nombre,
            ],
            'user' => [
                'id' => $user->id,
                'nombre' => $user->nombre,
            ],
            'ingredientes' => $ingredientes,
        ];
    }
}

