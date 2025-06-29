<?php
require_once __DIR__ . '/../partials/header.php';

$ref = $_GET['ref'] ?? null;
if (!$ref) {
    echo "<script>Swal.fire('Oops', 'Finca no especificada', 'error')</script>";
    require_once __DIR__ . '/../partials/footer.php';
    exit;
}

require_once __DIR__ . '/../../controllers/fincasControl/FincaController.php';
$controller = new FincaController($pdo);
$finca = $controller->mostrar($ref);

if (!$finca) {
    echo "<script>Swal.fire('Oops', 'Finca no encontrada', 'error')</script>";
    require_once __DIR__ . '/../partials/footer.php';
    exit;
}
?>

<div class="container">
    <h2 class="mt-4 mb-3">📅 Reservar: <?= htmlspecialchars($finca['nombre']) ?></h2>

    <form id="formReserva" action="?accion=crear_reserva" method="POST">
        <input type="hidden" name="ref_finca" value="<?= htmlspecialchars($finca['ref']) ?>">

        <div class="row mb-3">
            <div class="col-md-6">
                <label>Fecha de entrada</label>
                <input type="date" name="fecha_inicio" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Fecha de salida</label>
                <input type="date" name="fecha_fin" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label>Nombre completo</label>
                <input type="text" name="nombre_cliente" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Correo electrónico</label>
                <input type="email" name="email_cliente" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label>Teléfono</label>
                <input type="text" name="telefono_cliente" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Ciudad</label>
                <input type="text" name="ciudad_cliente" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label>Dirección</label>
            <input type="text" name="direccion" class="form-control">
        </div>

        <div class="mb-3">
            <label>Observaciones adicionales</label>
            <textarea name="observaciones" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Enviar solicitud de reserva ✅</button>
        <a href="?accion=index" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
    <br><br>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('formReserva').addEventListener('submit', function (e) {
    e.preventDefault();

    const inicio = new Date(this.fecha_inicio.value);
    const fin = new Date(this.fecha_fin.value);

    const diff = Math.ceil((fin - inicio) / (1000 * 60 * 60 * 24));
    const hoy = new Date();

    if (isNaN(inicio.getTime()) || isNaN(fin.getTime())) {
        Swal.fire('Fechas inválidas', 'Por favor selecciona fechas válidas.', 'warning');
        return;
    }

    if (inicio < hoy) {
        Swal.fire('Fecha inválida', 'La fecha de entrada no puede ser en el pasado.', 'warning');
        return;
    }

    if (fin <= inicio) {
        Swal.fire('Rango de fechas incorrecto', 'La fecha de salida debe ser posterior a la de entrada.', 'warning');
        return;
    }

    if (diff < 2) {
        Swal.fire('Mínimo de noches', 'La estadía debe ser al menos de 2 noches.', 'info');
        return;
    }

    // ✅ Si todo está bien, enviar
    this.submit();
});
</script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>