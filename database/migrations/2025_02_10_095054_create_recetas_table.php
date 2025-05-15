<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('recetas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->string('titulo');
            $table->text('descripcion');
            $table->text('preparacion');
            $table->integer('dificultad');
            $table->integer('coccion');
            $table->date('fecha_publicacion')->nullable();
            $table->integer('porciones');
            $table->boolean('publica')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('recetas');
    }
};