<?php
require_once __DIR__ . '/../partials/header.php';

if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: ?accion=login');
    exit;
}

require_once __DIR__ . '/../../models/ReservaModel.php';
$model = new ReservaModel($pdo);
$reservas = $model->leerTodas();
?>

<div class="container mt-5">
    <h2 class="mb-4">📋 Gestión de Reservas</h2>

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Finca</th>
                <th>Cliente</th>
                <th>Fechas</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($reservas as $r): ?>
            <tr>
                <td><?= $r['id'] ?></td>
                <td><?= htmlspecialchars($r['ref_finca']) ?></td>
                
                <td>
    <strong><?= htmlspecialchars($r['nombre_cliente']) ?></strong><br>
    <small>
        📧 <?= htmlspecialchars($r['email_cliente']) ?><br>
        📞 <?= htmlspecialchars($r['telefono_cliente']) ?><br>
        🏙️ <?= htmlspecialchars($r['ciudad_cliente']) ?><br>
        🌄 <?= htmlspecialchars($r['nombre_finca']) ?> (<?= htmlspecialchars($r['ref_finca']) ?>)
    </small>
    <?php if (!empty($r['observaciones'])): ?>
        <div class="mt-1 text-muted" style="font-size: 0.85em;">
            📝 <?= nl2br(htmlspecialchars($r['observaciones'])) ?>
        </div>
    <?php endif; ?>
</td>
                <td>
                    <?= date('d M Y', strtotime($r['fecha_inicio'])) ?> → 
                    <?= date('d M Y', strtotime($r['fecha_fin'])) ?>
                </td>
                <td>
                    <span class="badge bg-<?= 
                        $r['estado'] === 'pendiente' ? 'warning' : 
                        ($r['estado'] === 'confirmada' ? 'success' : 'secondary') ?>">
                        <?= ucfirst($r['estado']) ?>
                    </span>
                </td>
                <td>
                <?php if ($r['estado'] === 'pendiente'): ?>
                <a href="?accion=confirmar_reserva&id=<?= $r['id'] ?>" class="btn btn-success btn-sm">✅ Confirmar</a>
                <a href="?accion=rechazar_reserva&id=<?= $r['id'] ?>" class="btn btn-warning btn-sm">❌ Rechazar</a>

                <a href="?accion=eliminar_reserva&id=<?= $r['id'] ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Eliminar esta reserva?');">🗑 Eliminar</a>

                    <?php if (!empty($r['telefono_cliente'])): 
                        $numero = '57' . preg_replace('/[^0-9]/', '', $r['telefono_cliente']);
                        $mensaje = urlencode(
    "Hola {$r['nombre_cliente']}, te escribimos respecto a tu solicitud de reserva para la finca \"{$r['nombre_finca']}\" ({$r['ref_finca']}). ¿Podemos continuar con la confirmación?"
);
                        $wa = "https://wa.me/$numero?text=$mensaje";
                    ?>
                        <a href="<?= $wa ?>" class="btn btn-outline-success btn-sm mt-1" target="_blank">💬 WhatsApp</a>
                    <?php endif; ?>

                <?php else: ?>
                    <em>Sin acciones</em>
                <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="mt-4">
  <a href="?accion=admin" class="btn btn-secondary">⬅️ Volver al Panel</a>
</div><br><br>
</div>


<?php require_once __DIR__ . '/../partials/footer.php'; ?>