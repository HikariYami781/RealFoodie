<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/*use Laravel\Scout\Searchable;*/

class Categoria extends Model
{
    use HasFactory/*, Searchable*/;

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function recetas()
    {
        return $this->hasMany(Receta::class);
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
        ];
    }
}

