<?php require_once __DIR__ . '/partials/header.php'; 
require_once __DIR__ . '/../controllers/fincasControl/FincaController.php';
$controller = new FincaController($pdo);
//$fincas = $controller->destacadas(); // nuevo método que solo trae las destacadas
//$fincas = $controller->index(); // trae todas las fincas
$fincas = [
    $controller->mostrarPorRef('AFB09'),
    $controller->mostrarPorRef('AFB03'),
    $controller->mostrarPorRef('AFB14')
];
    if (!empty($_SESSION['exito'])): ?>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script>
        Swal.fire("¡Hecho!", "<?= $_SESSION['exito'] ?>", "success");
      </script>
      <?php unset($_SESSION['exito']); ?>
<?php endif; ?>

<div class="container mt-5">
  <div class="text-center">
<section id="fincas" class="mt-5">
  <h2 class="text-center mb-4">🌄 Fincas destacadas</h2>
  <div class="row">
    <?php foreach ($fincas as $finca): ?>
      <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
          <img src="/fincas/public/img/<?= htmlspecialchars($finca['imagen']) ?>" class="card-img-top" alt="<?= htmlspecialchars($finca['nombre']) ?>">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?= htmlspecialchars($finca['nombre']) ?></h5>
            <p class="card-text"><?= htmlspecialchars($finca['zona']) ?> | Capacidad: <?= htmlspecialchars($finca['capacidad']) ?> personas</p>
            <p class="mb-1">⭐ <?= $finca['estrellas'] ?> | Desde <strong>$<?= number_format($finca['p_temporada_baja'], 0, ',', '.') ?></strong>/noche</p>
            <a href="?accion=reserva_finca&ref=<?= $finca['ref'] ?>" class="btn btn-success mt-auto">Reservar</a><br>
            <a href="?accion=ver_finca&ref=<?= $finca['ref'] ?>" class="btn btn-outline-secondary flex-fill">Ver detalles</a>

          </div>
        </div>
      </div> 
  

    <?php endforeach; ?>
  </div>
</section>
<section class="mt-5">
  <h2 class="text-center mb-3">🔍 Consulta de fincas por zona</h2>
  <div class="d-flex flex-wrap justify-content-center gap-2">
    <?php
    $zonas = [
      'Altiplano Cundiboyacense', 'Costa Atlántica', 'Llanos Orientales',
      'La Mesa – Anapoima – Tocaima', 'Silvania – Melgar – Girardot',
      'La Vega – Villeta – Honda', 'Zona Cafetera', 'Otras Zonas'
    ];
    foreach ($zonas as $zona): ?>
      <a href="?accion=consulta_fincas&zona=<?= urlencode($zona) ?>" class="btn btn-outline-primary"><?= $zona ?></a>
    <?php endforeach; ?>
  </div>
</section>

<section class="mt-5 mb-5">
  <h2 class="text-center mb-3">🗺️ Consulta por destino</h2>
  <div class="d-flex flex-wrap justify-content-center gap-2">
    <?php
    $destinos = [
      'Mesa de Yeguas', 'Peñalisa', 'El Peñón', 'Girardot', 'Melgar',
      'Apicalá', 'Anapoima', 'Apulo', 'Payandé', 'Guaduas', 'Honda',
      'Mariquita', 'Panaca', 'Santa Marta', 'Cartagena',
      'Tabio', 'Tenjo', 'Subachoque', 'Ubaté', 'Villa de Leyva'
    ];
    foreach ($destinos as $destino): ?>
      <a href="?accion=consulta_fincas&destino=<?= urlencode($destino) ?>" class="btn btn-outline-secondary"><?= $destino ?></a>
    <?php endforeach; ?>
  </div>
</section>

    <br><br>
</div>
</div>
<?php require_once __DIR__ . '/partials/footer.php'; ?>