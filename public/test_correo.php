<?php
require_once __DIR__ . '/../app/services/CorreoService.php';
$correo = new CorreoService();

$correo->notificarAlAdmin('RF102', 'Juana', 'juana@email.com', '2025-07-10', '2025-07-13');
echo "Correo enviado (si no hay errores)";