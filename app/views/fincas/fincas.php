<?php
require_once __DIR__ . '/../partials/header.php';

if (
    !isset($_SESSION['usuario_rol']) ||
    !in_array($_SESSION['usuario_rol'], ['admin', 'editor'])
) {
    header('Location: ?accion=login');
    exit;
}

require_once __DIR__ . '/../../controllers/fincasControl/FincaController.php';
$controller = new FincaController($pdo);
$fincas = $controller->index();
?>

<div class="container">
    <h2 class="mt-4 mb-3">🏡 Gestión de Fincas</h2>
    <a href="?accion=crear_finca" class="btn btn-success mb-3">➕ Nueva Finca</a>

    <table class="table table-hover table-bordered align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th>Ref</th>
                <th>Nombre</th>
                <th>Zona</th>
                <th>Destino</th>
                <th>Capacidad</th>
                <th>Estrellas</th>
                <th>Alta</th>
                <th>Baja</th>
                <!-- <th>⭐</th> -->

                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($fincas as $finca): ?>
            <tr>
                <td><?= htmlspecialchars($finca['ref']) ?></td>
                <td><?= htmlspecialchars($finca['nombre']) ?></td>
                <td><?= htmlspecialchars($finca['zona']) ?></td>
                <td><?= htmlspecialchars($finca['destino']) ?></td>
                <td><?= htmlspecialchars($finca['capacidad']) ?></td>
                <td class="text-center"><?= htmlspecialchars($finca['estrellas']) ?></td>
                <td>$<?= number_format($finca['p_temporada_alta'], 0) ?></td>
                <td>$<?= number_format($finca['p_temporada_baja'], 0) ?></td>
                <!--destacada 
                <td class="text-center">
                    <?php if ($finca['destacada']): ?>
                        <a href="?accion=marcar_destacada&ref=<?= urlencode($finca['ref']) ?>&valor=0" class="text-warning" title="Quitar destacado">⭐</a>
                    <?php else: ?>
                        <a href="?accion=marcar_destacada&ref=<?= urlencode($finca['ref']) ?>&valor=1" class="text-muted" title="Marcar como destacada">☆</a>
                    <?php endif; ?>-->
                </td>

            <!-- acciones -->

                <td class="text-center">
                    <a href="?accion=editar_finca&ref=<?= urlencode($finca['ref']) ?>" class="btn btn-sm btn-outline-primary me-1">✏️ Editar</a>
                    <a href="?accion=galeria_finca&ref=<?= urlencode($finca['ref']) ?>" class="btn btn-sm btn-outline-warning me-1">📷 Galería</a>
                    <a href="?accion=eliminar_finca&ref=<?= urlencode($finca['ref']) ?>" class="btn btn-sm btn-outline-danger"
                    onclick="return confirm('¿Seguro que deseas eliminar esta finca?')">🗑️ Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
        
<br>
        <div class="mt-4">
  <a href="?accion=admin" class="btn btn-secondary">⬅️ Volver al Panel</a>
</div>
<br><br>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>