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
        Schema::create('friendships', function (Blueprint $table) {
            $table->id();
            // Quién envía la solicitud
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            // Quién la recibe
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
        
            // Estado: 'pending' (enviada), 'accepted' (amigos), 'blocked' (bloqueado)
            $table->enum('status', ['pending', 'accepted', 'blocked'])->default('pending');
        
            $table->timestamps();

            // Evitar duplicados: No puedes enviar 2 solicitudes a la misma persona
            $table->unique(['sender_id', 'receiver_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friendships');
    }
};
