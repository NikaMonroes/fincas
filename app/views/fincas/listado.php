<?php 
require_once __DIR__ . '/../partials/header.php';
?>



<section class="container py-5">
  <h2 class="text-center mb-4"><?= htmlspecialchars($titulo) ?></h2>

  <?php if ($fincas): ?>
    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-light text-center">
          <tr>
            <th>Vista</th>
            <th>Finca</th>
            <th>Destino</th>
            <th>Capacidad</th>
            <th>Desde</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($fincas as $f): ?>
            <tr>
              <!-- Imagen mini -->
             <td class="text-center">
                <?php if (!empty($f['imagen'])): ?>
                    <img src="/fincas/public/img/<?= htmlspecialchars($f['imagen']) ?>" 
                        alt="Imagen de <?= htmlspecialchars($f['nombre']) ?>" 
                        style="width: 60px; height: auto; border-radius: 5px;">
                <?php else: ?>
                    <span class="text-muted small">Sin imagen</span>
                <?php endif; ?>
                </td>

              <!-- Nombre + zona combinados -->
              <td>
                <strong><?= htmlspecialchars($f['nombre']) ?></strong><br>
                <small class="text-muted"><?= htmlspecialchars($f['zona']) ?></small>
              </td>

              <!-- Otros datos relevantes -->
              <td><?= htmlspecialchars($f['destino']) ?></td>
              <td class="text-center"><?= htmlspecialchars($f['capacidad']) ?> personas</td>
              <td class="text-end">$<?= number_format($f['p_temporada_baja'], 0, ',', '.') ?></td>

              <!-- Botón acción -->
              <td class="text-center">
                <a href="?accion=ver_finca&ref=<?= $f['ref'] ?>&volver=<?= urlencode($_SERVER['REQUEST_URI']) ?>" class="btn btn-sm btn-outline-primary">Ver</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-warning text-center">No hay fincas en esta categoría.</div>
  <?php endif; ?>

  <div class="text-center mt-5">
    <a href="?accion=home" class="btn btn-outline-primary">
      ← Volver a la página principal
    </a>
  </div>
</section>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>