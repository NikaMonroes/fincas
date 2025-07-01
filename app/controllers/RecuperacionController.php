<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/conexion.php';

class RecuperacionController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function enviarToken($correo)
    {
        // Validar correo existente
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE correo = ?");
        $stmt->execute([$correo]);
        $usuario = $stmt->fetch();

        if (!$usuario) return false;

        // Generar token y fecha
        $token = bin2hex(random_bytes(32));
        $expira = date('Y-m-d H:i:s', strtotime('+15 minutes'));

        // Guardar token
        $this->pdo->prepare("INSERT INTO tokens_recuperacion (usuario_id, token, expira) VALUES (?, ?, ?)")
                  ->execute([$usuario['id'], $token, $expira]);

        // Enviar correo con PHPMailer
        $mail = new PHPMailer(true);
/* Debug errors
        $mail->SMTPDebug = 2;  // para ver salida detallada (solo en pruebas)
        $mail->Debugoutput = 'html';
*/


        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'monicaromerofreelance@gmail.com';
            $mail->Password   = 'gxsw uukl senc ghle'; // Clave generada para apps
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;


            
            $mail->setFrom('monicaromerofreelance@gmail.com', 'Booking Fincas');
            $mail->addAddress($correo, $usuario['nombre']);

            $link = "http://localhost/fincas/public/reestablecer.php?token=$token";
            //$link = "https:/fincas.ct.ws/fincas/usuarios/reset.php?token=$token";

            $mail->isHTML(true);
            $mail->Subject = '🔐 Recupera tu contraseña';
            $mail->Body    = "Hola <b>{$usuario['nombre']}</b>,<br><br>
                              Recibimos una solicitud para recuperar tu contraseña. 
                              Da clic en el siguiente enlace para continuar:<br><br>
                              <a href='$link'>$link</a><br><br>
                              Este enlace expira en 15 minutos.<br><br>
                              Si no solicitaste esto, ignora este mensaje.";

            $mail->send();
            return true;

        } catch (Exception $e) {
            return false;
        }
       /* print error info
        }catch (Exception $e) {
            echo "❌ Error al enviar: " . $mail->ErrorInfo;
            return false;
        }
    */
    }
}