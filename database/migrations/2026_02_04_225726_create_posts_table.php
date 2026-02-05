<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            
            // 1. EL AUTOR REAL (Auditoría/Seguridad)
            // Siempre debe haber un usuario responsable detrás, incluso si publica como página.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // 2. LA "MÁSCARA" (¿Quién dice el post que es?)
            // author_type: 'App\Models\User' o 'App\Models\Page'
            // author_id: ID del usuario o de la página
            $table->morphs('author');

            // 3. EL DESTINO (¿Dónde se publicó?)
            // wall_type: 'App\Models\User' (Muro perfil), 'App\Models\Page' (Muro página), 'App\Models\Group' (Grupo)
            $table->morphs('wall');

            // 4. CONTENIDO
            $table->text('content')->nullable(); // Texto del post
            
            // Multimedia (JSON para guardar array de fotos/videos: ['img1.jpg', 'video.mp4'])
            $table->json('attachments')->nullable(); 
            
            // Link Preview (Si el post es solo un link)
            $table->string('link_url')->nullable();
            $table->string('link_title')->nullable();
            $table->string('link_description')->nullable();
            $table->string('link_image')->nullable();

            // 5. LÓGICA DE NEGOCIO (Ads y Estado)
            $table->boolean('is_ad')->default(false); // ¿Es publicidad?
            $table->foreignId('target_audience_id')->nullable(); // Para segmentación de anuncios futura
            
            // Status: published (visible), pending (revisión grupo), hidden (oculto/borrado soft)
            $table->enum('status', ['published', 'pending', 'hidden'])->default('published');
            
            // Privacidad (Solo aplica si NO es grupo, los grupos mandan su propia privacidad)
            $table->enum('privacy', ['public', 'friends', 'only_me'])->default('public');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};