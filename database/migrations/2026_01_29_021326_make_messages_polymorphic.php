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
        Schema::table('messages', function (Blueprint $table) {
            // 1. Eliminamos las claves foráneas antiguas (porque vamos a cambiar el tipo de dato)
            // Nota: Dependiendo de tu DB, a veces hay que borrar la columna entera y recrearla.
            // Haremos el método "add column" para no perder datos, pero idealmente en dev es mejor un fresh.
        
            $table->dropForeign(['sender_id']);
            $table->dropForeign(['recipient_id']);
        
            // 2. Agregamos las columnas para saber "QUÉ TIPO" es el remitente/destinatario
            // Esto crea: sender_type (string)
            // Y mantiene: sender_id (bigint)
            $table->string('sender_type')->default('App\Models\User')->after('id');
            $table->string('recipient_type')->default('App\Models\User')->after('sender_id');
        
            // Indexamos para que sea rápido
            $table->index(['sender_id', 'sender_type']);
            $table->index(['recipient_id', 'recipient_type']);
        });
    }

    public function down(): void
    {
        // Revertir esto es complejo, simplificamos borrando las columnas de tipo
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn(['sender_type', 'recipient_type']);
            // Aquí deberías volver a poner las foreign keys si quisieras hacer rollback real
        });
    }
};
