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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
        
            // Identidad
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username')->unique();
        
            // Datos básicos
            $table->string('email')->unique();
            
            // Lógica de Género completa
            $table->string('gender')->nullable(); // 'male', 'female', 'custom'
            $table->string('pronoun')->nullable(); // 'he', 'she', 'they' (para custom)
            $table->string('custom_gender')->nullable(); // Texto libre (para custom)
            
            $table->date('birthday')->nullable();
            
            // Elementos visuales del perfil
            $table->string('profile_photo')->nullable(); // Ruta de la foto
            $table->string('cover_photo')->nullable();   // Ruta de la portada
            $table->text('bio')->nullable();             // Presentación corta
        
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
        
            // Tokens y auditoría
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};