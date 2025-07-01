<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php'; // Ajusta si tu path es distinto

class CorreoService {
    private $remitente = 'monicaromerofreelance@gmail.com'; // <- Cámbialo por tu correo real
    private $nombreRemitente = 'Booking Fincas';

    public function enviarACliente($destinatario, $nombre, $ref, $inicio, $fin) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $this->remitente;
            $mail->Password = 'XXXX XXXX XXXX XXXX'; // Clave generada para apps
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom($this->remitente, $this->nombreRemitente);
            $mail->addAddress($destinatario, $nombre);

            $mail->isHTML(true);
            $mail->Subject = 'Tu solicitud de reserva ha sido recibida';
            $mail->Body = "
                <p>Hola <strong>$nombre</strong>,</p>
                <p>Recibimos tu solicitud para reservar la finca <strong>$ref</strong> entre el <strong>$inicio</strong> y el <strong>$fin</strong>.</p>
                <p>Tu solicitud está en revisión y nos pondremos en contacto contigo pronto.</p>
                <p>Gracias por confiar en nosotros.</p>
                <hr>
                <small>Este es un mensaje automático, no respondas a este correo.</small>
            ";

            $mail->send();
        } catch (Exception $e) {
            error_log("Error al enviar correo a cliente: {$mail->ErrorInfo}");
        }
    }

    public function notificarAlAdmin($ref, $nombre, $email, $inicio, $fin) {
        $admin = 'monicaromerofreelance@gmail.com'; // Cámbialo por el correo de quien gestione
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $this->remitente;
            $mail->Password = 'XXXX XXXX XXXX XXXX'; //clave generada para apps
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom($this->remitente, $this->nombreRemitente);
            $mail->addAddress($admin, 'Administrador');

            $mail->isHTML(true);
            $mail->Subject = 'Nueva solicitud de reserva';
            $mail->Body = "
                <p>Se ha recibido una nueva reserva:</p>
                <ul>
                    <li>Finca: <strong>$ref</strong></li>
                    <li>Cliente: <strong>$nombre</strong> ($email)</li>
                    <li>Fechas: <strong>$inicio</strong> a <strong>$fin</strong></li>
                </ul>
                <p>Revísala desde el panel y contacta al cliente para continuar el proceso.</p>
            ";

            $mail->send();
        } catch (Exception $e) {
            error_log("Error al notificar al admin: {$mail->ErrorInfo}");
        }
    }
    public function enviarRechazo($destinatario, $nombre, $ref) {
    $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $this->remitente;
            $mail->Password = 'gxsw uukl senc ghle';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom($this->remitente, $this->nombreRemitente);
            $mail->addAddress($destinatario, $nombre);

            $mail->isHTML(true);
            $mail->Subject = 'Tu reserva no fue aprobada';
            $mail->Body = "
                <p>Hola <strong>$nombre</strong>,</p>
                <p>Gracias por tu interés en reservar la finca <strong>$ref</strong>.</p>
                <p>Lamentamos informarte que tu solicitud no fue aprobada en esta ocasión. Puedes intentar con otras fechas u opciones disponibles.</p>
                <p>Estamos aquí para ayudarte cuando quieras 😊</p>
            ";

            $mail->send();
        } catch (Exception $e) {
            error_log("Error al enviar correo de rechazo: {$mail->ErrorInfo}");
        }
    }
}