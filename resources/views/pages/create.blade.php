<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Crear una página | Larabook</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #e9ebee; font-family: 'lucida grande', tahoma, verdana, arial, sans-serif; font-size: 11px; color: #141823; }
        .fb-header { background-color: #3b5998; height: 82px; border-bottom: 1px solid #133783; }
        .fb-logo { color: white; font-weight: bold; font-size: 30px; text-decoration: none; display: block; padding-top: 25px; padding-left: 20px; }
        .content { width: 980px; margin: 20px auto; display: flex; gap: 20px; }
        .create-box { background: white; border: 1px solid #ccc; border-radius: 3px; padding: 20px; flex: 1; }
        h2 { font-size: 20px; color: #333; margin-bottom: 10px; border-bottom: 1px solid #e9eaed; padding-bottom: 10px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; font-size: 13px; color: #666; mb-1; }
        input, select, textarea { width: 100%; border: 1px solid #bdc7d8; padding: 5px; font-size: 13px; }
        .btn-submit { background-color: #42b72a; color: white; border: 1px solid #2c8415; padding: 8px 15px; font-weight: bold; cursor: pointer; font-size: 13px; }
    </style>
</head>
<body>

    <div class="fb-header">
        <div style="width: 980px; margin: 0 auto;">
            <a href="{{ route('dashboard') }}" class="fb-logo">Larabook</a>
        </div>
    </div>

    <div class="content">
        <div class="create-box">
            <h2>Crear una página</h2>
            <p style="font-size: 13px; margin-bottom: 20px;">Conecta con tus fans, clientes o comunidad en Larabook.</p>

            <form action="{{ route('pages.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label>Nombre de la página</label>
                    <input type="text" name="name" placeholder="Ej. Tacos El Tío, Banda de Rock, etc." required>
                </div>

                <div class="form-group">
                    <label>Categoría</label>
                    <select name="category">
                        <option value="Lugar o Negocio Local">Lugar o Negocio Local</option>
                        <option value="Empresa, Organización o Institución">Empresa, Organización o Institución</option>
                        <option value="Marca o Producto">Marca o Producto</option>
                        <option value="Artista, Grupo de música o Personaje público">Artista, Grupo de música o Personaje público</option>
                        <option value="Entretenimiento">Entretenimiento</option>
                        <option value="Causa o Comunidad">Causa o Comunidad</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Información (Opcional)</label>
                    <textarea name="about" rows="3" placeholder="Describe brevemente de qué trata tu página..."></textarea>
                </div>

                <div style="text-align: right; margin-top: 20px;">
                    <a href="{{ route('dashboard') }}" style="margin-right: 10px; color: #3b5998; text-decoration: none; font-size: 13px;">Cancelar</a>
                    <button type="submit" class="btn-submit">Comenzar</button>
                </div>
            </form>
        </div>

        <div style="width: 300px;">
            <div style="background: white; border: 1px solid #ccc; padding: 10px;">
                <h3 style="font-weight: bold; color: #3b5998; font-size: 13px; margin-bottom: 5px;">¿Por qué crear una página?</h3>
                <ul style="list-style: disc; padding-left: 20px; font-size: 12px; color: #666; line-height: 1.5;">
                    <li>Es gratis y siempre lo será.</li>
                    <li>Tus posts aparecerán en el muro de tus fans.</li>
                    <li>Puedes enviar mensajes como página.</li>
                </ul>
            </div>
        </div>
    </div>

</body>
</html>