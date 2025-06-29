<?php
require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../controllers/RecuperacionController.php';

$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'] ?? '';
    $controller = new RecuperacionController($pdo);
    $exito = $controller->enviarToken($correo);

    $mensaje = $exito
        ? "📧 Si el correo está registrado, recibirás instrucciones para recuperar tu contraseña."
        : "Error al enviar el enlace. Intenta nuevamente.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Recuperar contraseña</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 460px;">
  <div class="card shadow-sm p-4">
    <h3 class="mb-3">🔑 Recuperar contraseña</h3>

    <?php if (!empty($mensaje)): ?>
      <div class="alert alert-info"><?= $mensaje ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="mb-3">
        <label class="form-label">Correo electrónico</label>
        <input type="email" name="correo" class="form-control" required>
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-primary">Enviar enlace</button>
      </div>
    </form>
  </div>
</div>
</body>
</html>