<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
        
            // El humano real (Seguridad/Log)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
            // El Post al que pertenece
            $table->foreignId('post_id')->constrained()->onDelete('cascade');

            // ¿Quién figura públicamente? (User o Page)
            $table->morphs('author'); 

            $table->text('content');
        
            // Opcional: Para respuestas anidadas (Nivel 2)
            $table->unsignedBigInteger('parent_id')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
