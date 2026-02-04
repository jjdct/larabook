@extends('layouts.app')

@section('title', 'Crear una página | Larabook')

@push('styles')
<style>
    /* Fondo limpio para el wizard de creación */
    .create-page-container {
        padding: 40px 0;
        text-align: center;
    }

    .create-page-title {
        font-size: 24px;
        font-weight: bold;
        color: #1c1e21;
        margin-bottom: 10px;
    }
    
    .create-page-subtitle {
        font-size: 15px;
        color: #606770;
        margin-bottom: 40px;
    }

    /* Las dos grandes opciones */
    .option-card {
        background: white;
        border: 1px solid #dddfe2;
        border-radius: 4px;
        padding: 20px;
        text-align: left;
        width: 300px;
        height: 380px; /* Altura fija para alineación */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: box-shadow 0.2s;
    }
    .option-card:hover { box-shadow: 0 5px 15px rgba(0,0,0,0.1); }

    .option-icon { font-size: 40px; margin-bottom: 15px; color: #4b4f56; }
    .option-title { font-size: 18px; font-weight: bold; color: #1c1e21; margin-bottom: 5px; }
    .option-desc { font-size: 13px; color: #606770; line-height: 1.4; }

    /* Botón "Empezar" */
    .btn-get-started {
        background-color: #f5f6f7; /* Gris desactivado visualmente hasta hover */
        color: #4b4f56;
        font-weight: bold;
        padding: 8px 15px;
        border-radius: 4px;
        border: 1px solid #ccd0d5;
        width: fit-content;
        margin-top: 20px;
        cursor: pointer;
    }
    .btn-get-started:hover { background-color: #e9ebee; }

    /* FORMULARIO OCULTO (Se muestra al elegir opción) */
    .setup-form-container {
        display: none; /* Oculto por defecto */
        max-width: 500px;
        margin: 0 auto;
        background: white;
        padding: 20px;
        border-radius: 8px;
        border: 1px solid #dddfe2;
        text-align: left;
    }
    
    .form-label { font-size: 12px; font-weight: bold; color: #1c1e21; margin-bottom: 4px; display: block; }
    .form-input { 
        width: 100%; 
        padding: 8px; 
        border: 1px solid #ccd0d5; 
        border-radius: 4px; 
        font-size: 14px; 
        margin-bottom: 15px;
    }
    .form-input:focus { border-color: #1877f2; outline: none; box-shadow: 0 0 0 2px #e7f3ff; }
    
    .btn-create-submit {
        background-color: #4267b2;
        color: white;
        font-weight: bold;
        padding: 8px 20px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        width: 100%;
    }
    .btn-create-submit:hover { background-color: #365899; }
</style>
@endpush

@section('content')

<div class="create-page-container">
    
    <h1 class="create-page-title">Crear una página</h1>
    <div class="create-page-subtitle">Conéctate con tu comunidad de fans en Larabook.</div>

    <div id="step-selection" class="flex justify-center gap-6">
        
        <div class="option-card">
            <div>
                <div class="option-icon">🏢</div>
                <div class="option-title">Negocio o marca</div>
                <div class="option-desc">Muestra tus productos y servicios, destaca tu marca y llega a más clientes potenciales.</div>
            </div>
            <button class="btn-get-started" onclick="showForm('Negocio')">Empezar</button>
        </div>

        <div class="option-card">
            <div>
                <div class="option-icon">👥</div>
                <div class="option-title">Comunidad o figura pública</div>
                <div class="option-desc">Conéctate con personas de tu comunidad, organización, equipo, grupo o club y comparte contenido.</div>
            </div>
            <button class="btn-get-started" onclick="showForm('Comunidad')">Empezar</button>
        </div>

    </div>

    <div id="step-form" class="setup-form-container">
        <div class="flex justify-between items-center mb-4 border-b border-gray-200 pb-2">
            <h2 class="text-xl font-bold text-[#1c1e21]">Información de la página</h2>
            <button onclick="hideForm()" class="text-sm text-blue-600 hover:underline">Cambiar tipo</button>
        </div>

        <form action="{{ route('pages.store') }}" method="POST">
            @csrf
            
            <label class="form-label">Nombre de la página</label>
            <input type="text" name="name" class="form-input" placeholder="Asigna un nombre a tu página" required>
            
            <label class="form-label">Categoría</label>
            <input type="text" name="category" id="category-input" class="form-input" placeholder="Añade una categoría..." required>
            
            <label class="form-label">Descripción (Opcional)</label>
            <textarea name="description" class="form-input" rows="3" placeholder="Cuéntanos de qué trata..."></textarea>
            
            <div class="text-xs text-gray-500 mb-4">
                Al hacer clic en "Crear página", aceptas las Condiciones de las páginas de Larabook.
            </div>

            <button type="submit" class="btn-create-submit">Crear página</button>
        </form>
    </div>

</div>

@endsection

@push('scripts')
<script>
    function showForm(type) {
        // Ocultar selección y mostrar formulario
        document.getElementById('step-selection').style.display = 'none';
        document.getElementById('step-form').style.display = 'block';
        
        // Prellenar categoría o dar foco (simulación)
        const catInput = document.getElementById('category-input');
        if(type === 'Negocio') {
            catInput.placeholder = "Ej: Sitio web de computadoras, Tienda de ropa...";
        } else {
            catInput.placeholder = "Ej: Blog personal, Creador de videojuegos...";
        }
    }

    function hideForm() {
        // Volver atrás
        document.getElementById('step-form').style.display = 'none';
        document.getElementById('step-selection').style.display = 'flex';
    }
</script>
@endpush