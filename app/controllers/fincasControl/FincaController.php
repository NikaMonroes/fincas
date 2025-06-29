<?php
require_once __DIR__ . '/../../models/FincaModel.php';


class FincaController {
    private $model;
    private $pdo;

    public function __construct($pdo) {
        $this->model = new FincaModel($pdo);
    }

    public function index() {
        return $this->model->leerTodos();
    }

    public function mostrar($ref) {
        return $this->model->leerPorRef($ref);
    }

    public function crear($data) {
        return $this->model->crear($data);
    }

    public function actualizar($ref, $data) {
        return $this->model->actualizar($ref, $data);
    }

    public function eliminar($ref) {
        return $this->model->eliminar($ref);
    }

    public function eliminarImagen($id) {
    $this->model->eliminarImagen($id);
    }
    // obtener finca por referenciasolo 3 fincas destacadas
    public function mostrarPorRef($ref) {
    return $this->model->leerPorReferencia($ref);
}

    // 🎯 Nuevo: obtener imágenes de galería
    public function getImagenesPorFinca($ref) {
        return $this->model->obtenerImagenes($ref);
    }

    // 📥 Nuevo: subir imágenes de galería
    public function subirImagenes($ref, $imagenes) {
        $nombresSubidos = [];

        foreach ($imagenes['tmp_name'] as $index => $tmpPath) {
            if ($imagenes['error'][$index] === 0) {
                $ext = pathinfo($imagenes['name'][$index], PATHINFO_EXTENSION);
                $nombreImagen = uniqid('gal_', true) . '.' . strtolower($ext);
                $rutaDestino = __DIR__ . '/../../../public/img/' . $nombreImagen;

                if (move_uploaded_file($tmpPath, $rutaDestino)) {
                    $this->model->guardarImagenDeFinca($ref, $nombreImagen);
                    $nombresSubidos[] = $nombreImagen;
                }
            }
        }
    }
}


