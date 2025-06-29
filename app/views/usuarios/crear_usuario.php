<?php
require_once __DIR__ . '/../../../config/conexion.php';
require_once __DIR__ . '/../../controllers/UsuarioController.php'; // ✅
require_once __DIR__ . '/../partials/header.php';

// Seguridad: solo admin accede
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: ?accion=login');
    exit;
}

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new UsuarioController($pdo);
    $ok = $controller->guardar($_POST);

    if ($ok) {
        header('Location: ?accion=usuarios');
        exit;
    } else {
        $error = 'Hubo un error al guardar el usuario.';
    }
}
?>

<div class="container mt-5" style="max-width: 500px;">
  <h3 class="mb-4">➕ Crear nuevo usuario</h3>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST" action="">
    <div class="mb-3">
      <label class="form-label">Nombre</label>
      <input type="text" name="nombre" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Correo</label>
      <input type="email" name="correo" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Contraseña</label>
      <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Rol</label>
      <select name="rol" class="form-select" required>
        <option value="">-- Selecciona un rol --</option>
        <option value="admin">Administrador</option>
        <option value="editor">Editor</option>
      </select>
    </div>

    <div class="d-grid">
      <button type="submit" class="btn btn-success">Guardar usuario</button><br><br>
    </div>
  </form>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>