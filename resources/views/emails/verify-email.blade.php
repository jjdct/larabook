<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Confirma tu cuenta</title>
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
                                Te registraste recientemente en Larabook. Para completar tu registro, confirma tu cuenta haciendo clic en el siguiente botón:
                            </p>
                            
                            <div style="padding: 10px 0 20px 0;">
                                <a href="{{ $url }}" style="background-color: #3b5998; color: #ffffff; text-decoration: none; padding: 12px 24px; font-weight: bold; border-radius: 3px; display: inline-block; font-size: 15px; border: 1px solid #29487d;">
                                    Confirmar tu cuenta
                                </a>
                            </div>

                            <p style="margin: 0 0 16px; color: #90949c; font-size: 14px;">
                                Es posible que te pidamos que ingreses este código de confirmación:
                            </p>

                            <div style="background-color: #f7f7f7; border: 1px solid #ccc; border-radius: 4px; padding: 10px 15px; width: fit-content; margin-bottom: 20px;">
                                <span style="font-size: 18px; font-weight: bold; color: #1d2129; letter-spacing: 1px;">
                                    {{ rand(10000, 99999) }}
                                </span>
                            </div>

                            <p style="margin: 20px 0 0; font-size: 12px; color: #90949c;">
                                Larabook te ayuda a comunicarte y compartir con las personas que forman parte de tu vida.
                            </p>
                        </td>
                    </tr>
                </table>

                <table width="580" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td style="padding: 15px; color: #aeb0b5; font-size: 11px; text-align: center;">
                            Este mensaje se envió a <span style="color: #3b5998;">{{ $user->email }}</span> a petición tuya.<br>
                            Larabook, Inc., Attention: Community Support, 1 Larabook Way, Menlo Park, CA 94025
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>