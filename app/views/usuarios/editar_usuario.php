<?php
require_once __DIR__ . '/../../../config/conexion.php';
require_once __DIR__ . '/../../controllers/UsuarioController.php';
require_once __DIR__ . '/../partials/header.php';

// Seguridad: solo admin accede
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: ?accion=login');
    exit;
}

$controller = new UsuarioController($pdo);

// Obtener el ID por GET
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$usuario = $controller->obtenerPorId($id);

if (!$usuario) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Usuario no encontrado.</div></div>";
    require_once __DIR__ . '/../partials/footer.php';
    exit;
}

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario['nombre'] = $_POST['nombre'];
    $usuario['correo'] = $_POST['correo'];
    $usuario['rol'] = $_POST['rol'];

    $ok = $controller->actualizar($usuario);

    if ($ok) {
        header('Location: ?accion=usuarios');
        exit;
    } else {
        $error = 'No se pudo actualizar el usuario.';
    }
}
?>

<div class="container mt-5" style="max-width: 500px;">
  <h3 class="mb-4">✏️ Editar usuario</h3>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST" action="">
    <div class="mb-3">
      <label class="form-label">Nombre</label>
      <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Correo</label>
      <input type="email" name="correo" class="form-control" value="<?= htmlspecialchars($usuario['correo']) ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Rol</label>
      <select name="rol" class="form-select" required>
        <option value="admin" <?= $usuario['rol'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
        <option value="editor" <?= $usuario['rol'] === 'editor' ? 'selected' : '' ?>>Editor</option>
      </select>
    </div>

    <div class="d-grid">
      <button type="submit" class="btn btn-primary">Guardar cambios</button>
    </div>
  </form>
  <div class="mt-4">
  <a href="?accion=admin" class="btn btn-secondary">⬅️ Volver al Panel</a><br><br>
</div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>