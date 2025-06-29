<?php
require_once __DIR__ . '/../partials/header.php';

if (
    !isset($_SESSION['usuario_rol']) ||
    !in_array($_SESSION['usuario_rol'], ['admin', 'editor'])
) {
    header('Location: ?accion=login');
    exit;
}



?>

<div class="container">
    <h2 class="mt-4 mb-3">➕ Registrar nueva finca</h2>

    <form action="?accion=crear_finca" method="POST" enctype="multipart/form-data">
        <div class="row mb-3">
            <div class="col-md-4">
                <label>Referencia</label>
                <input type="text" name="ref" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label>Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="col-md-4">
            <label>Zona</label>
            <select name="zona" class="form-select">
                <option value="">Selecciona zona</option>
                <option value="ALTIPLANO CUNDIBOYACENSE">ALTIPLANO CUNDIBOYACENSE</option>
                <option value="COSTA ATLANTICA">COSTA ATLANTICA</option>
                <option value="LLANOS ORIENTALES">LLANOS ORIENTALES</option>
                <option value="LA MESA – ANAPOIMA – TOCAIMA">LA MESA – ANAPOIMA – TOCAIMA</option>
                <option value="SILVANIA – MELGAR – GIRARDOT">SILVANIA – MELGAR – GIRARDOT</option>
                <option value="LA VEGA – VILLETA – HONDA">LA VEGA – VILLETA – HONDA</option>
                <option value="ZONA CAFETERA">ZONA CAFETERA</option>
                <option value="OTRAS ZONAS">OTRAS ZONAS</option>
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
                <input type="number" name="capacidad" class="form-control">
            </div>
            <div class="col-md-4">
                <label>Estrellas</label>
                <select name="estrellas" class="form-select">
                    <option value="*">⭐</option>
                    <option value="**">⭐⭐</option>
                    <option value="***">⭐⭐⭐</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label>Distancia</label>
                <input type="text" name="distancia" class="form-control">
            </div>
            <div class="col-md-4">
                <label>Clima</label>
                <input type="text" name="clima" class="form-control">
            </div>
            <div class="col-md-4">
                <label>Ubicación</label>
                <input type="text" name="ubicacion" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label>Precio Alta</label>
                <input type="number" name="p_temporada_alta" class="form-control" step="0.01">
            </div>
            <div class="col-md-4">
                <label>Precio Baja</label>
                <input type="number" name="p_temporada_baja" class="form-control" step="0.01">
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
        </div>

        <div class="mb-3">
            <label>Imagen principal</label>
            <input type="file" name="imagen" accept="image/*" class="form-control" onchange="previewImage(event)">
            <div class="mt-2">
                <img id="preview" src="#" alt="Vista previa" style="max-width: 150px; display: none;">
            </div>
        </div>

        <div class="mb-3">
            <label>Observaciones</label>
            <textarea name="observaciones" class="form-control" rows="3"></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Guardar finca ✅</button>
        <a href="?accion=fincas" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
        <br><br>
</div>

<script>
function previewImage(event) {
    const preview = document.getElementById('preview');
    preview.src = URL.createObjectURL(event.target.files[0]);
    preview.style.display = 'block';
}

</script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>