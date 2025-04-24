<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paso extends Model
{
    use HasFactory;

    protected $fillable = [
        'receta_id',
        'descripcion',
        'orden',
    ];

    public function receta()
    {
        return $this->belongsTo(Receta::class);
    }
}
