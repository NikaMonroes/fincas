<?php
require_once __DIR__ . '/partials/header.php';

if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin, editor') {
    header('Location: ?accion=login');
    exit;
}
?>

<div class="container mt-5 text-center">
  <h2>¡Hola, <?= $_SESSION['usuario_nombre'] ?? 'editor' ?> 🌿!</h2>
  <p class="lead">Este es tu panel exclusivo como <strong>editor</strong>.</p>

  <a href="?accion=logout" class="btn btn-outline-danger mt-3">Cerrar sesión</a>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>