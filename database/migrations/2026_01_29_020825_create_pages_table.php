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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique(); // Para la URL: larabook.com/pages/metallica
            $table->text('about')->nullable();
            $table->string('category')->nullable(); // "Músico/Banda", "Negocio Local"
        
            // El dueño/admin de la página
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
            $table->timestamps();
        });
    
        // Tabla pivote para los "Likes" (Seguidores de la página)
        Schema::create('page_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('page_id')->constrained()->onDelete('cascade');
            $table->timestamps(); // Para saber cuándo le dio like
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
