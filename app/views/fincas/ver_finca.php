<?php 
require_once __DIR__ . '/../partials/header.php';




if ($finca): ?>
<section class="container py-5">
  <div class="row">
    <!-- Imagen destacada -->
   <div class="col-md-6 mb-4">
  <div class="card shadow-sm border-0">
    <div class="overflow-hidden" style="border-radius: .5rem .5rem 0 0;">
      <img src="/fincas/public/img/<?= htmlspecialchars($finca['imagen']) ?>"
           class="w-100"
           style="aspect-ratio: 4 / 3; object-fit: cover;"
           alt="<?= htmlspecialchars($finca['nombre']) ?>">
    </div>
    <div class="card-body">
      <h5 class="card-title"><?= htmlspecialchars($finca['nombre']) ?></h5>
      <p class="card-text text-muted"><?= htmlspecialchars($finca['zona']) ?> • <?= htmlspecialchars($finca['clima']) ?></p>
    </div>
  </div>
</div>



    <!-- Datos de la finca -->
    <div class="col-md-6">
      <h2><?= htmlspecialchars($finca['nombre']) ?></h2>
      <p class="text-muted"><?= htmlspecialchars($finca['zona']) ?> • <?= htmlspecialchars($finca['clima']) ?> • <?= htmlspecialchars($finca['distancia']) ?> de distancia</p>
      
      <ul class="list-unstyled mb-3">
        <li>🏡 Capacidad: <strong><?= $finca['capacidad'] ?></strong> personas</li>
        <li>⭐ Clasificación: <strong><?= $finca['estrellas'] ?></strong></li>
        <li>💲 Temporada alta: <strong>$<?= number_format($finca['p_temporada_alta'], 0, ',', '.') ?></strong></li>
        <li>💵 Temporada baja: <strong>$<?= number_format($finca['p_temporada_baja'], 0, ',', '.') ?></strong></li>
      </ul>

      <?php /* if (!empty($finca['observaciones'])): ?>
        <div class="mb-3">
          <p class="fw-bold mb-1">📝 Observaciones</p>
          <p><?= nl2br(htmlspecialchars($finca['observaciones'])) ?></p>
        </div>
      <?php endif;*/ ?>
      
      <?php
      $obs = $finca['observaciones'] ?? '';
      $lineas = explode("\n", $obs);
      $serviciosTexto = '';
      $otrasObs = [];

      foreach ($lineas as $linea) {
          if (str_starts_with($linea, '🛎️ Servicios disponibles:')) {
              $serviciosTexto = trim(str_replace('🛎️ Servicios disponibles:', '', $linea));
          } else {
              $otrasObs[] = $linea;
          }
      }
      $servicios = array_map('trim', explode(',', $serviciosTexto));
      ?>

<?php if ($serviciosTexto): ?>
  <div class="mb-3">
    <p class="fw-bold mb-2">🛎️ Servicios incluidos:</p>
    <div class="d-flex flex-wrap gap-2">
      <?php foreach ($servicios as $item): ?>
        <span class="badge bg-secondary"><?= htmlspecialchars($item) ?></span>
      <?php endforeach; ?>
    </div>
  </div>
<?php endif; ?>

<?php if (!empty($otrasObs)): ?>
  <div class="mb-3 mt-3">
    <p class="fw-bold mb-1">📝 Observaciones adicionales:</p>
    <p><?= nl2br(htmlspecialchars(implode("\n", $otrasObs))) ?></p>
  </div>
<?php endif; ?>

      <a href="?accion=reserva_finca&ref=<?= $finca['ref'] ?>" class="btn btn-success btn-lg">Reservar ahora</a>
    </div>
  </div>

  <!-- Galería -->
  <?php
    $stmt = $pdo->prepare("SELECT imagen FROM finca_imagenes WHERE ref_finca = ?");
    $stmt->execute([$finca['ref']]);
    $galeria = $stmt->fetchAll(PDO::FETCH_ASSOC);
  ?>
  
  <?php if ($galeria): ?>
    <h4 class="mt-5 mb-3">📸 Galería</h4>
    <div class="row g-3">
      <?php foreach ($galeria as $img): ?>
        <div class="col-6 col-md-3">
          <div class="ratio ratio-1x1 rounded overflow-hidden border">
            <img src="/fincas/public/img/<?= htmlspecialchars($img['imagen']) ?>" class="object-fit-cover w-100 h-100" alt="Galería de <?= htmlspecialchars($finca['nombre']) ?>">
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>
<?php else: ?>
<div class="container py-5 mb-5">
  <h2 class="text-danger">Finca no encontrada 😕</h2>
  <a href="?accion=home" class="btn btn-outline-primary mt-3">Volver al inicio</a>
</div>
<?php endif; ?>
<div class="container py-5">
<?php if (isset($_GET['volver'])): ?>
  <div class="text-center mt-5">
    <a href="<?= htmlspecialchars($_GET['volver']) ?>" class="btn btn-outline-secondary">
      ← Volver al listado
    </a>
  </div>
<?php else: ?>
  <div class="text-center mt-5">
    <a href="?accion=home" class="btn btn-outline-secondary">
      ← Volver al inicio
    </a>
  </div>
<?php endif; ?>

<div class="text-center mt-5">
  <a href="?accion=home" class="btn btn-outline-primary">
    ← Volver a la página principal
  </a>
</div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>