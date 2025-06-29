<?php
require_once __DIR__ . '/../../../config/conexion.php';
require_once __DIR__ . '/../../controllers/UsuarioController.php';
require_once __DIR__ . '/../partials/header.php';

// Seguridad: solo admin accede
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: ?accion=login');
    exit;
}

// Cargar controlador y datos
$controller = new UsuarioController($pdo);
$usuarios = $controller->listar();
?>

<div class="container mt-4">
  <h3 class="mb-4">👥 Gestión de usuarios</h3>

  <a href="?accion=crear_usuario" class="btn btn-success mb-3">➕ Nuevo usuario</a>

  <table class="table table-bordered table-hover">
    <thead class="table-light">
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Correo</th>
        <th>Rol</th>
        <th class="text-center">Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($usuarios as $usuario): ?>
        <tr>
          <td><?= $usuario['id'] ?></td>
          <td><?= $usuario['nombre'] ?></td>
          <td><?= $usuario['correo'] ?></td>
          <td><?= ucfirst($usuario['rol']) ?></td>
          <td class="text-center">
            <a href="?accion=editar_usuario&id=<?= $usuario['id'] ?>" class="btn btn-sm btn-warning">✏️</a>
            <a href="?accion=eliminar_usuario&id=<?= $usuario['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que quieres eliminar este usuario?')">🗑️</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

<div class="mt-4">
  <a href="?accion=admin" class="btn btn-secondary">⬅️ Volver al Panel</a><br><br>
</div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>