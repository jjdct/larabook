<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            
            // EL DUEÑO (Admin Supremo)
            // Si el usuario se borra, se borran sus páginas (cascade)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // IDENTIDAD DE LA PÁGINA
            $table->string('name'); // Ej: Larabook Team
            $table->string('username')->unique(); // Ej: larabook_official
            $table->string('category')->nullable(); // Ej: Empresa de Software, Blog Personal

            // APARIENCIA (Igual que Users)
            $table->string('profile_photo')->nullable();
            $table->string('cover_photo')->nullable();
            
            // DETALLES
            $table->text('description')->nullable(); // La sección "Información"
            $table->string('website')->nullable();
            $table->string('location')->nullable(); // Ej: Menlo Park, CA
            
            // ESTADO
            $table->boolean('is_verified')->default(false); // Check azul
            $table->boolean('is_published')->default(true); // Para ocultarla si está en borrador

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};