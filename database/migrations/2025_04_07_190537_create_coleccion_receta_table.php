<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('coleccion_receta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coleccion_id')->constrained('colecciones')->onDelete('cascade');
            $table->foreignId('receta_id')->constrained('recetas')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['coleccion_id', 'receta_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('coleccion_receta');
    }
}
;