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
        // 1. LA TABLA DE GRUPOS
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // El creador original
        
            $table->string('name');
            $table->string('slug')->unique(); // Para la URL: /groups/laravel-fans
            $table->text('description')->nullable();
        
            // Tipos de grupo 2018: Público, Cerrado, Secreto
            $table->enum('privacy', ['public', 'closed', 'secret'])->default('public');
        
            $table->string('cover_photo')->nullable();
            $table->timestamps();
        });

        // 2. LA TABLA PIVOTE (MIEMBROS)
        // Relaciona Usuarios <-> Grupos
        Schema::create('group_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
            // Roles: admin (dueño), moderator, member
            $table->string('role')->default('member');
        
            // Estado: active, pending (si el grupo es cerrado y requiere aprobación), banned
            $table->string('status')->default('active');
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
