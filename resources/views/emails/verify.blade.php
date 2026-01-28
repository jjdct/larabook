<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Lucida Grande', Tahoma, Verdana, sans-serif; margin: 0; padding: 0; background-color: #e9ebee; }
        .wrapper { width: 100%; background-color: #e9ebee; padding: 20px 0; }
        .container { width: 580px; margin: 0 auto; background-color: #ffffff; border: 1px solid #d3d6db; border-radius: 3px; }
        .header { background-color: #3b5998; padding: 10px 15px; border-bottom: 1px solid #29487d; border-radius: 3px 3px 0 0; }
        .logo { color: #ffffff; font-size: 20px; font-weight: bold; text-decoration: none; font-family: Tahoma, sans-serif; }
        .content { padding: 20px; color: #141823; font-size: 14px; line-height: 1.5; }
        .button { display: inline-block; background-color: #42b72a; border: 1px solid #2c8415; color: #ffffff; font-weight: bold; text-decoration: none; padding: 10px 20px; border-radius: 2px; margin-top: 15px; font-size: 14px; }
        .footer { padding: 15px; color: #9197a3; font-size: 11px; text-align: center; border-top: 1px solid #e9eaed; }
        .footer a { color: #3b5998; text-decoration: none; }
    </style>
</head>
<body>
    <div class="wrapper">
        <table class="container" cellpadding="0" cellspacing="0">
            <tr>
                <td class="header">
                    <a href="{{ url('/') }}" class="logo">larabook</a>
                </td>
            </tr>
            
            <tr>
                <td class="content">
                    <p style="font-weight: bold; font-size: 16px; margin-top: 0;">¡Hola, {{ $userName }}!</p>
                    
                    <p>Gracias por registrarte en Larabook.</p>
                    <p>Necesitamos confirmar que esta dirección de correo electrónico te pertenece para completar la configuración de tu cuenta.</p>
                    
                    <p>Haz clic en el botón verde para confirmar:</p>
                    
                    <a href="{{ $url }}" class="button">Confirmar tu cuenta</a>
                    
                    <p style="margin-top: 20px; color: #999; font-size: 12px;">
                        Larabook te ayuda a comunicarte y compartir con las personas que forman parte de tu vida.
                    </p>
                </td>
            </tr>

            <tr>
                <td class="footer">
                    Este mensaje fue enviado a <a href="#">{{ $userEmail }}</a>.<br>
                    Larabook Inc., Menlo Park, California.
                </td>
            </tr>
        </table>
    </div>
</body>
</html>