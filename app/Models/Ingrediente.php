<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Laravel\Scout\Searchable;

class Ingrediente extends Model
{
    use HasFactory/*, Searchable*/;

    protected $fillable = [
        'nombre',
        'unidad_medida',
    ];

    public function recetas()
    {
        return $this->belongsToMany(Receta::class, 'receta_ingrediente')
                    ->withPivot('cantidad', 'unidad')
                    ->withTimestamps();
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'unidad_medida' => $this->unidad_medida,
        ];
    }
}

