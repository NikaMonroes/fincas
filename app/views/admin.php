<?php
require_once __DIR__ . '/partials/header.php';

// Protección básica
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: ?accion=login');
    exit;
}
?>

<div class="container mt-5 text-center">
  <h2>Bienvenido, <?= $_SESSION['usuario_nombre'] ?? 'admin' ?> 👋</h2>
  <p class="lead">Estás en el panel de <strong>administrador</strong>.</p><br><br>
  <div class="mt-4">
  <a href="?accion=usuarios" class="btn btn-outline-primary">👥 Gestionar usuarios</a>
  <a href="?accion=fincas" class="btn btn-outline-success">🏡 Gestionar Fincas</a>
  <a href="?accion=reservas" class="btn btn-outline-warning">📋 Gestionar Reservas</a>
  </div><br>
  <a href="?accion=logout" class="btn btn-outline-danger mt-3">Cerrar sesión</a>
</div><br><br>


<?php require_once __DIR__ . '/partials/footer.php'; ?>