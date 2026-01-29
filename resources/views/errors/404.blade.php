<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Página no encontrada | Larabook</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { 
            background-color: #e9ebee; 
            font-family: 'lucida grande', tahoma, verdana, arial, sans-serif;
            font-size: 13px;
            color: #141823;
            margin: 0;
        }
        .fb-header { background-color: #3b5998; height: 42px; border-bottom: 1px solid #133783; display: flex; align-items: center; padding: 0 20px; box-shadow: 0 2px 2px -2px rgba(0, 0, 0, .52); }
        .logo { font-size: 20px; font-weight: bold; color: white; text-decoration: none; letter-spacing: -0.5px; }
        
        .error-container {
            width: 700px;
            margin: 40px auto;
            display: flex;
            gap: 20px;
        }

        .error-icon {
            width: 100px;
            text-align: center;
            font-size: 60px;
            color: #3b5998;
        }

        .error-content h2 {
            font-size: 16px;
            font-weight: bold;
            color: #3b5998;
            margin: 0 0 10px 0;
        }

        .error-content p {
            line-height: 1.5;
            margin-bottom: 15px;
            color: #333;
        }

        .back-link {
            font-weight: bold;
            color: #3b5998;
            text-decoration: none;
            font-size: 13px;
        }
        .back-link:hover { text-decoration: underline; }

        .search-box {
            margin-top: 20px;
            background: #fff;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
    </style>
</head>
<body>

    <div class="fb-header">
        <a href="{{ url('/') }}" class="logo">larabook</a>
    </div>

    <div class="error-container">
        
        <div class="error-icon">
            ⚠️
        </div>

        <div class="error-content">
            <h2>Esta página no está disponible</h2>
            <p>
                Es posible que el enlace que has seguido esté roto o que se haya eliminado la página.
            </p>

            <ul class="list-disc pl-5 mb-4 text-[#3b5998] cursor-pointer">
                <li><a href="{{ url('/') }}" class="back-link">Ir a la sección de noticias</a></li>
                <li><a href="javascript:history.back()" class="back-link">Volver a la página anterior</a></li>
                <li><a href="#" class="back-link">Visitar el Servicio de ayuda</a></li>
            </ul>

        </div>
    </div>

    <div class="text-center text-[11px] text-[#9197a3] mt-20">
        Larabook © 2026
    </div>

</body>
</html>