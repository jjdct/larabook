<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bienvenido a Larabook</title>
</head>
<body style="margin: 0; padding: 0; background-color: #e9ebee; font-family: Helvetica, Arial, sans-serif;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center" style="padding: 20px 0;">
                <table width="580" border="0" cellspacing="0" cellpadding="0" style="background-color: #ffffff; border: 1px solid #dddfe2; border-radius: 3px;">
                    <tr>
                        <td style="background-color: #3b5998; padding: 20px; border-radius: 3px 3px 0 0; text-align: center;">
                            <span style="color: #ffffff; font-size: 30px; font-weight: bold; letter-spacing: -1px;">larabook</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 30px 20px; color: #1d2129; font-size: 16px; line-height: 24px; text-align: center;">
                            <h2 style="margin: 0 0 10px; font-size: 20px; color: #1d2129;">¡Bienvenido a Larabook, {{ $user->first_name }}!</h2>
                            <p style="margin: 0 0 20px; color: #4b4f56;">
                                Nos alegra que estés aquí. Larabook es el lugar perfecto para conectar con amigos, familiares y las cosas que te importan.
                            </p>
                            
                            <div style="font-size: 40px; margin-bottom: 20px; letter-spacing: 15px;">
                                👥 💬 🌎
                            </div>

                            <div style="padding: 10px 0;">
                                <a href="{{ route('dashboard') }}" style="background-color: #42b72a; color: #ffffff; text-decoration: none; padding: 12px 40px; font-weight: bold; border-radius: 4px; display: inline-block; font-size: 16px;">
                                    Empezar ahora
                                </a>
                            </div>
                            
                            <p style="margin: 20px 0 0; font-size: 14px; color: #1877f2;">
                                <a href="#" style="color: #1877f2; text-decoration: none;">Buscar amigos</a> &nbsp;·&nbsp; 
                                <a href="#" style="color: #1877f2; text-decoration: none;">Editar perfil</a>
                            </p>
                        </td>
                    </tr>
                </table>
                <table width="580" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td style="padding: 15px; color: #aeb0b5; font-size: 11px; text-align: center;">
                            Larabook © {{ date('Y') }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>