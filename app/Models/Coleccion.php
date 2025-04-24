<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Laravel\Scout\Searchable;

class Coleccion extends Model
{
    use HasFactory/*, Searchable*/;

    protected $table = 'colecciones';

    protected $fillable = [
        'user_id',
        'nombre',
        'descripcion',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recetas()
    {
        return $this->belongsToMany(Receta::class, 'coleccion_receta')->withTimestamps();
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'user_id' => $this->user_id,
        ];
    }
}

