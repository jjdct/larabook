<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Editar {{ $page->name }} | Larabook</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #e9ebee; font-family: 'lucida grande', tahoma, verdana, arial, sans-serif; font-size: 11px; color: #141823; }
        .fb-header { background-color: #3b5998; height: 42px; border-bottom: 1px solid #133783; padding: 0 20px; display: flex; items-center; justify-content: space-between; }
        
        .admin-container { width: 980px; margin: 20px auto; display: flex; gap: 20px; }
        .admin-sidebar { width: 180px; }
        .admin-content { flex: 1; background: white; border: 1px solid #c0c0c0; border-radius: 3px; padding: 20px; min-height: 400px; }
        
        .menu-item { display: block; padding: 8px 10px; color: #333; font-weight: bold; border-radius: 2px; text-decoration: none; font-size: 12px; }
        .menu-item:hover { background-color: #eff2f5; }
        .menu-item.active { background-color: #d8dfea; color: #3b5998; }

        .fb-input { border: 1px solid #bdc7d8; padding: 5px; width: 100%; font-size: 12px; margin-bottom: 10px; }
        .fb-label { font-weight: bold; color: #666; font-size: 12px; margin-bottom: 4px; display: block; }
        
        .btn-save { background-color: #4267b2; color: white; border: 1px solid #29487d; padding: 5px 15px; font-weight: bold; cursor: pointer; }
    </style>
</head>
<body>

    <div class="fb-header text-white font-bold">
        <div class="flex items-center gap-2">
            <a href="{{ route('dashboard') }}" class="text-white text-lg no-underline">Larabook</a>
            <span class="opacity-50">/</span>
            <a href="{{ route('pages.show', $page->slug) }}" class="text-white hover:underline">{{ $page->name }}</a>
            <span class="opacity-50">/</span>
            <span>Configuración</span>
        </div>
        <a href="{{ route('pages.show', $page->slug) }}" class="text-xs bg-white text-[#3b5998] px-2 py-1 rounded">Ver página</a>
    </div>

    <div class="admin-container">
        <div class="admin-sidebar">
            <a href="#" class="menu-item active">Información básica</a>
            <a href="{{ route('pages.inbox', $page->slug) }}" class="menu-item">Mensajes</a>
            <a href="#" class="menu-item">Gestionar permisos</a>
            <a href="#" class="menu-item">Registro de actividad</a>
            <a href="#" class="menu-item text-red-600">Eliminar página</a>
        </div>

        <div class="admin-content">
            <h2 class="text-[16px] font-bold text-[#333] mb-4 border-b border-[#ccc] pb-2">Editar la página</h2>

            <form action="{{ route('pages.update', $page->slug) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="fb-label">Nombre de la página</label>
                    <input type="text" name="name" value="{{ old('name', $page->name) }}" class="fb-input">
                </div>

                <div class="mb-4">
                    <label class="fb-label">Categoría</label>
                    <select name="category" class="fb-input">
                        <option value="Músico/Banda" {{ $page->category == 'Músico/Banda' ? 'selected' : '' }}>Músico/Banda</option>
                        <option value="Negocio Local" {{ $page->category == 'Negocio Local' ? 'selected' : '' }}>Negocio Local</option>
                        <option value="Marca o Producto" {{ $page->category == 'Marca o Producto' ? 'selected' : '' }}>Marca o Producto</option>
                        <option value="Entretenimiento" {{ $page->category == 'Entretenimiento' ? 'selected' : '' }}>Entretenimiento</option>
                        <option value="Comunidad" {{ $page->category == 'Comunidad' ? 'selected' : '' }}>Comunidad</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="fb-label">Descripción breve</label>
                    <textarea name="about" rows="4" class="fb-input resize-none">{{ old('about', $page->about) }}</textarea>
                </div>

                <div class="mt-6 border-t border-[#ccc] pt-4">
                    <button type="submit" class="btn-save">Guardar cambios</button>
                    <a href="{{ route('pages.show', $page->slug) }}" class="text-[#3b5998] text-xs ml-2 hover:underline">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>