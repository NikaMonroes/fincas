<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="container mt-5" style="max-width: 400px;">
  <h3 class="mb-4 text-center">Iniciar sesión</h3>

  <?php if (!empty($_SESSION['error_login'])): ?>
    <div class="alert alert-danger text-center">
      <?= $_SESSION['error_login']; unset($_SESSION['error_login']); ?>
    </div>
  <?php endif; ?>

  <form method="POST" action="?accion=procesar_login">
    <div class="mb-3">
      <label for="correo" class="form-label">Correo electrónico</label>
      <input type="email" name="correo" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Contraseña</label>
      <input type="password" name="password" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary w-100">Entrar</button>
  </form>
  <p class="text-center mt-3">
  <a href="?accion=recuperar" class="text-decoration-none">¿Olvidaste tu contraseña?</a>
</p>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>