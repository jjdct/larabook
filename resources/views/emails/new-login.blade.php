<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Alerta de inicio de sesión</title>
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
                        <td style="padding: 25px 20px; color: #1d2129; font-size: 14px; line-height: 20px;">
                            <p style="margin: 0 0 15px;">Hola, {{ $user->first_name }}:</p>
                            
                            <p style="margin: 0 0 15px;">
                                Se accedió a tu cuenta de Larabook desde un navegador o dispositivo nuevo. Revisa la información e infórmanos si reconoces este inicio de sesión.
                            </p>

                            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 20px; border-left: 3px solid #3b5998; padding-left: 12px;">
                                <tr>
                                    <td style="color: #90949c; font-size: 11px; font-weight: bold; text-transform: uppercase; padding-bottom: 2px;">Dispositivo</td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom: 10px; font-weight: bold; font-size: 14px;">{{ $browser ?? 'Chrome en Windows' }}</td>
                                </tr>

                                <tr>
                                    <td style="color: #90949c; font-size: 11px; font-weight: bold; text-transform: uppercase; padding-bottom: 2px;">Ubicación</td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom: 10px; font-size: 14px;">{{ $location ?? 'Ciudad de México, MX' }} (aprox.)</td>
                                </tr>

                                <tr>
                                    <td style="color: #90949c; font-size: 11px; font-weight: bold; text-transform: uppercase; padding-bottom: 2px;">Hora</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 14px;">{{ date('d F Y \a \l\a\s H:i') }}</td>
                                </tr>
                            </table>

                            <p style="margin: 0 0 15px;">
                                Si fuiste tú, puedes ignorar este correo electrónico.
                            </p>
                            
                            <div style="padding: 5px 0;">
                                <a href="#" style="display: inline-block; padding: 8px 12px; border: 1px solid #ced0d4; background-color: #f6f7f9; color: #4b4f56; font-weight: bold; text-decoration: none; font-size: 12px; border-radius: 2px;">
                                    Informar al respecto
                                </a>
                            </div>
                            
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