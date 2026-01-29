<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Página caducada | Larabook</title>
    <style>
        body { background-color: #e9ebee; font-family: 'lucida grande', tahoma, verdana, arial, sans-serif; font-size: 12px; color: #141823; margin: 0; }
        .header { background-color: #3b5998; height: 42px; border-bottom: 1px solid #133783; padding: 0 20px; display: flex; items-center; }
        .logo { color: white; font-weight: bold; font-size: 20px; text-decoration: none; padding-top: 10px; display: block; }
        .container { width: 600px; margin: 40px auto; background: white; border: 1px solid #ccc; border-radius: 3px; padding: 20px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h2 { font-size: 18px; color: #333; margin-top: 0; }
        p { color: #666; font-size: 14px; line-height: 1.5; }
        .btn { background-color: #42b72a; color: white; border: 1px solid #2c8415; padding: 8px 15px; font-weight: bold; cursor: pointer; text-decoration: none; border-radius: 2px; display: inline-block; margin-top: 10px; }
        .btn:hover { background-color: #36a020; }
    </style>
</head>
<body>
    <div class="header">
        <a href="/" class="logo">Larabook</a>
    </div>
    <div class="container">
        <div style="font-size: 40px; margin-bottom: 10px;">⚠️</div>
        <h2>La página ha caducado</h2>
        <p>Estuviste inactivo por mucho tiempo o intentaste enviar información que ya no es válida.</p>
        <p>Por favor, recarga la página e inténtalo de nuevo.</p>
        
        <a href="{{ url()->previous() }}" class="btn">Volver atrás</a>
        <a href="/" class="btn" style="background-color: #f6f7f9; color: #333; border: 1px solid #ccc;">Ir al inicio</a>
    </div>
</body>
</html>