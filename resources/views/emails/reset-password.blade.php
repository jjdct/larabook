<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Restablece tu contraseña</title>
</head>
<body style="margin: 0; padding: 0; background-color: #e9ebee; font-family: Helvetica, Arial, sans-serif;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center" style="padding: 20px 0;">
                <table width="580" border="0" cellspacing="0" cellpadding="0" style="background-color: #ffffff; border: 1px solid #dddfe2; border-radius: 3px;">
                    
                    <tr>
                        <td style="background-color: #3b5998; padding: 15px 20px; border-radius: 3px 3px 0 0; border-bottom: 1px solid #29487d;">
                            <span style="color: #ffffff; font-size: 24px; font-weight: bold; letter-spacing: -1px; font-family: Helvetica, Arial, sans-serif;">larabook</span>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 30px 20px; color: #1d2129; font-size: 16px; line-height: 24px;">
                            <p style="margin: 0 0 16px;">Hola, {{ $user->first_name }}:</p>
                            
                            <p style="margin: 0 0 16px;">
                                Hemos recibido una solicitud para restablecer tu contraseña de Larabook.
                                Ingresa el siguiente código para cambiar la contraseña:
                            </p>
                            
                            <div style="background-color: #f7f7f7; border: 1px solid #ccc; border-radius: 4px; padding: 15px; text-align: left; margin: 20px 0; width: fit-content; min-width: 150px;">
                                <span style="font-size: 22px; font-weight: bold; color: #1d2129; letter-spacing: 1px;">
                                    {{ rand(100000, 999999) }}
                                </span>
                            </div>

                            <p style="margin: 0 0 20px;">
                                También puedes cambiar la contraseña directamente haciendo clic en el botón:
                            </p>

                            <div style="padding: 0 0 20px;">
                                <a href="{{ $url ?? '#' }}" style="background-color: #1877f2; color: #ffffff; text-decoration: none; padding: 10px 20px; font-weight: bold; border-radius: 4px; display: inline-block; font-size: 15px;">
                                    Cambiar contraseña
                                </a>
                            </div>

                            <p style="margin: 0; font-size: 12px; color: #90949c;">
                                ¿No solicitaste este cambio? <a href="#" style="color: #3b5998; text-decoration: none;">Avísanos</a>.
                            </p>
                        </td>
                    </tr>
                </table>

                <table width="580" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td style="padding: 15px; color: #aeb0b5; font-size: 11px; text-align: center;">
                            Larabook, Inc., Attention: Community Support, 1 Larabook Way, Menlo Park, CA 94025
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>