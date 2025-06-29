<?php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../app/controllers/UsuarioController.php';

$token = $_GET['token'] ?? '';
$error = '';
$exito = '';
$usuario_id = null;

// Paso 1: Validar token
if ($token) {
    $stmt = $pdo->prepare("SELECT * FROM tokens_recuperacion WHERE token = ? AND expira > NOW()");
    $stmt->execute([$token]);
    $tokenData = $stmt->fetch();

    if ($tokenData) {
        $usuario_id = $tokenData['usuario_id'];

        // Si se envió nueva contraseña
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nueva = $_POST['nueva'] ?? '';
            $repite = $_POST['repite'] ?? '';

            if ($nueva === $repite && strlen($nueva) >= 6) {
                $controller = new UsuarioController($pdo);
                $ok = $controller->actualizarPassword($usuario_id, $nueva);

                if ($ok) {
                    // Borrar token usado
                    $pdo->prepare("DELETE FROM tokens_recuperacion WHERE token = ?")->execute([$token]);
                    $exito = "✅ Tu contraseña ha sido actualizada. Ya puedes iniciar sesión.";
                } else {
                    $error = "Hubo un problema al guardar la nueva contraseña.";
                }
            } else {
                $error = "Las contraseñas no coinciden o son muy cortas.";
            }
        }
    } else {
        $error = "Token inválido o expirado 😕. Solicita una nueva recuperación.";
    }
} else {
    $error = "No se proporcionó ningún token.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Reestablecer contraseña</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 480px;">
  <div class="card shadow-sm p-4">
    <h3 class="mb-3">🔐 Reestablecer contraseña</h3>

    <?php if ($error): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php elseif ($exito): ?>
      <div class="alert alert-success"><?= $exito ?></div>
    <?php elseif ($usuario_id): ?>
      <form method="POST" action="">
        <div class="mb-3">
          <label class="form-label">Nueva contraseña</label>
          <input type="password" name="nueva" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Repite la contraseña</label>
          <input type="password" name="repite" class="form-control" required>
        </div>
        <div class="d-grid">
          <button type="submit" class="btn btn-primary">Guardar contraseña</button>
        </div>
      </form>
    <?php endif; ?>
  </div>
</div>
</body>
</html>