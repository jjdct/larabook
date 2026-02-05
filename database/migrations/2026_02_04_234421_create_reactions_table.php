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
        Schema::create('reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
            // Polimorfismo: ¿A qué reaccionamos? (Post o Comment)
            $table->morphs('reactable');
        
            // Tipo de reacción: like, love, haha, wow, sad, angry
            $table->string('type'); 

            $table->timestamps();
        
            // Regla: Un usuario solo puede tener 1 reacción por item
            $table->unique(['user_id', 'reactable_id', 'reactable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reactions');
    }
};
