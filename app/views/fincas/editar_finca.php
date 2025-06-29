<?php
require_once __DIR__ . '/../partials/header.php';

if (
    !isset($_SESSION['usuario_rol']) ||
    !in_array($_SESSION['usuario_rol'], ['admin', 'editor'])
) {
    header('Location: ?accion=login');
    exit;
}

$ref = $_GET['ref'] ?? null;

require_once __DIR__ . '/../../controllers/fincasControl/FincaController.php';
$controller = new FincaController($pdo);
$finca = $controller->mostrar($ref);

if (!$finca) {
    echo "<div class='alert alert-danger'>Finca no encontrada.</div>";
    require_once __DIR__ . '/../partials/footer.php';
    exit;
}
?>

<div class="container">
    <h2 class="mt-4 mb-3">✏️ Editar finca <?= htmlspecialchars($finca['nombre']) ?></h2>

    <form action="?accion=editar_finca&ref=<?= urlencode($ref) ?>" method="POST" enctype="multipart/form-data">
        <div class="row mb-3">
            <div class="col-md-4">
                <label>Referencia</label>
                <input type="text" name="ref" value="<?= htmlspecialchars($finca['ref']) ?>" class="form-control" readonly>
            </div>
            <div class="col-md-4">
                <label>Nombre</label>
                <input type="text" name="nombre" value="<?= htmlspecialchars($finca['nombre']) ?>" class="form-control" required>
            </div>
            <div class="col-md-4">
    <label>Zona</label>
    <select name="zona" class="form-select">
        <?php
        $zonas = [
            'ALTIPLANO CUNDIBOYACENSE',
            'COSTA ATLANTICA',
            'LLANOS ORIENTALES',
            'LA MESA – ANAPOIMA – TOCAIMA',
            'SILVANIA – MELGAR – GIRARDOT',
            'LA VEGA – VILLETA – HONDA',
            'ZONA CAFETERA',
            'OTRAS ZONAS'
        ];
        foreach ($zonas as $z) {
            $selected = ($finca['zona'] === $z) ? 'selected' : '';
            echo "<option value=\"$z\" $selected>$z</option>";
        }
        ?>
    </select>
</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
            <label>Destino</label>
            <select name="destino" class="form-select">
                <option value="">Selecciona destino</option>
                <option value="MESA DE YEGUAS">MESA DE YEGUAS</option>
                <option value="PEÑALISA">PEÑALISA</option>
                <option value="ELPEÑON">ELPEÑON</option>
                <option value="GIRARDOT">GIRARDOT</option>
                <option value="MELGAR">MELGAR</option>
                <option value="APICALA">APICALA</option>
                <option value="ANAPOIMA">ANAPOIMA</option>
                <option value="APULO">APULO</option>
                <option value="PAYANDE">PAYANDE</option>
                <option value="GUADUAS">GUADUAS</option>
                <option value="HONDA">HONDA</option>
                <option value="MARIQUITA">MARIQUITA</option>
                <option value="PANACA">PANACA</option>
                <option value="SANTAMARTA">SANTAMARTA</option>
                <option value="CARTAGENA">CARTAGENA</option>
                <option value="TABIO">TABIO</option>
                <option value="TENJO">TENJO</option>
                <option value="SUBACHOQUE">SUBACHOQUE</option>
                <option value="UBATE">UBATE</option>
                <option value="VILLA DE LEYVA">VILLA DE LEYVA</option>
            </select>
        </div>
            <div class="col-md-4">
                <label>Capacidad</label>
                <input type="number" name="capacidad" value="<?= htmlspecialchars($finca['capacidad']) ?>" class="form-control">
            </div>
            <div class="col-md-4">
                <label>Estrellas</label>
                <select name="estrellas" class="form-select">
                    <option <?= $finca['estrellas'] === '*' ? 'selected' : '' ?>>*</option>
                    <option <?= $finca['estrellas'] === '**' ? 'selected' : '' ?>>**</option>
                    <option <?= $finca['estrellas'] === '***' ? 'selected' : '' ?>>***</option>
                </select>
            </div>
        </div>
  
        <div class="row mb-3">
            <div class="col-md-4">
                <label>Distancia</label>
                <input type="text" name="distancia" value="<?= htmlspecialchars($finca['distancia']) ?>" class="form-control">
            </div>
            <div class="col-md-4">
                <label>Clima</label>
                <input type="text" name="clima" value="<?= htmlspecialchars($finca['clima']) ?>" class="form-control">
            </div>
            <div class="col-md-4">
                <label>Ubicación</label>
                <input type="text" name="ubicacion" value="<?= htmlspecialchars($finca['ubicacion']) ?>" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label>Precio Alta</label>
                <input type="number" name="p_temporada_alta" value="<?= htmlspecialchars($finca['p_temporada_alta']) ?>" class="form-control" step="0.01">
            </div>
            <div class="col-md-4">
                <label>Precio Baja</label>
                <input type="number" name="p_temporada_baja" value="<?= htmlspecialchars($finca['p_temporada_baja']) ?>" class="form-control" step="0.01">
            </div>
                  <div class="col-md-4">
                    <label>Servicios</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="servicios[]" value="📶 Wi-Fi" id="wifi">
                        <label class="form-check-label" for="wifi">📶 Wi-Fi</label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="servicios[]" value="🏊 Piscina" id="piscina">
                        <label class="form-check-label" for="piscina">🏊 Piscina</label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="servicios[]" value="🍖 BBQ" id="bbq">
                        <label class="form-check-label" for="bbq">🍖 BBQ</label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="servicios[]" value="🐶 Pet Friendly" id="mascotas">
                        <label class="form-check-label" for="mascotas">🐶 Pet Friendly</label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="servicios[]" value="🚗 Parqueadero" id="parqueadero">
                        <label class="form-check-label" for="parqueadero">🚗 Parqueadero</label>
                        </div>
                 </div>

            <div class="col-md-4">
                <label>Imagen actual</label><br>
                <?php if ($finca['imagen']): ?>
                    <img src="img/<?= htmlspecialchars($finca['imagen']) ?>" alt="Imagen actual" style="max-width: 80px;">
                <?php else: ?>
                    <em>Sin imagen</em>
                <?php endif; ?>
                <input type="file" name="imagen" class="form-control mt-2">
                <input type="hidden" name="imagen_actual" value="<?= htmlspecialchars($finca['imagen']) ?>">
            </div>
        </div>

        <div class="mb-3">
            <label>Observaciones</label>
            <textarea name="observaciones" class="form-control" rows="3"><?= htmlspecialchars($finca['observaciones']) ?></textarea>
        </div>
        
        <button type="submit" class="btn btn-success">Actualizar finca ✅</button>
        <a href="?accion=fincas" class="btn btn-secondary ms-2">Cancelar</a>
    </form>

<br><br>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>