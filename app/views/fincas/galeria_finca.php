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
if (!$ref) {
    echo "<div class='alert alert-danger'>Referencia de finca no proporcionada.</div>";
    require_once __DIR__ . '/../partials/footer.php';
    exit;
}

// Trae imágenes actuales
require_once __DIR__ . '/../../controllers/fincasControl/FincaController.php';
$controller = new FincaController($pdo);
$imagenes = $controller->getImagenesPorFinca($ref);
?>

<div class="container">
    <h2 class="mt-4 mb-3">📷 Galería de la Finca <?= htmlspecialchars($ref) ?></h2>

    <form action="?accion=galeria_finca&ref=<?= urlencode($ref) ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Agregar nuevas imágenes (puedes seleccionar varias):</label>
            <input type="file" name="imagenes[]" class="form-control" accept="image/*" multiple required onchange="previewMultiple(event)">
        </div>

        <div class="mb-3" id="preview-container" style="display: flex; gap: 10px; flex-wrap: wrap;"></div>

        <button type="submit" class="btn btn-primary">Subir imágenes</button>
        <a href="?accion=fincas" class="btn btn-secondary ms-2">Volver</a>
    </form>

    <?php if ($imagenes): ?>
    <hr>
    <h5 class="mt-4">🖼️ Imágenes actuales:</h5>
    <div class="row">
        <?php foreach ($imagenes as $img): ?>
            <div class="col-md-3 mb-3">
                <div class="card">
                    <img src="img/<?= htmlspecialchars($img['imagen']) ?>" class="card-img-top" alt="Finca">
                    <form action="?accion=eliminar_imagen&ref=<?= urlencode($ref) ?>&id=<?= $img['id'] ?>" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar esta imagen?');">
                        <button type="submit" class="btn btn-danger btn-sm mt-2 w-100">🗑️ Eliminar</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<script>
function previewMultiple(event) {
    const container = document.getElementById('preview-container');
    container.innerHTML = '';
    Array.from(event.target.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxWidth = '100px';
            img.style.marginRight = '10px';
            container.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
}
</script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>