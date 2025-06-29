<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Asegúrate de tener Composer y haber ejecutado: composer require phpmailer/phpmailer
require_once __DIR__ . '/../vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'monicaromerofreelance@gmail.com';         // 👈 tu correo real
    $mail->Password   = 'wmwb betx fvww cmdz'; // ⚠️ usa un App Password si es Gmail
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Remitente y destinatario
    $mail->setFrom('tucorreo@gmail.com', 'Tu App o Tu Nombre');
    $mail->addAddress('destinatario@dominio.com', 'Usuario de prueba');

    // Contenido del mensaje
    $mail->isHTML(true);
    $mail->Subject = '📧 ¡Correo de prueba exitoso!';
    $mail->Body    = 'Hola, este es un mensaje de prueba enviado desde <b>PHPMailer</b> con ❤️ desde tu app.';

    $mail->send();
    echo '✅ Mensaje enviado correctamente.';
} catch (Exception $e) {
    echo "❌ Error al enviar correo: {$mail->ErrorInfo}";
}