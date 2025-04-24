<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('seguidores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seguidor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('seguido_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['seguidor_id', 'seguido_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('seguidores');
    }
};
