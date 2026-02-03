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
            
            // --- NUEVOS CAMPOS DE CONTROL ---
            // Por defecto (0/false), nadie es verificado ni admin al registrarse
            $table->boolean('is_verified')->default(false); // El Check Azul
            $table->boolean('is_admin')->default(false);    // Acceso al Dashboard especial
            
            // Lógica de Género completa
            $table->string('gender')->nullable(); 
            $table->string('pronoun')->nullable(); 
            $table->string('custom_gender')->nullable(); 
            
            $table->date('birthday')->nullable();
            
            // Elementos visuales del perfil
            $table->string('profile_photo')->nullable(); 
            $table->string('cover_photo')->nullable();   
            $table->text('bio')->nullable();             
        
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