<?php
require_once __DIR__ . '/../../models/ReservaModel.php';

class ReservaController {
    private $model;

    public function __construct($pdo) {
        $this->model = new ReservaModel($pdo);
    }

    public function index() {
        return $this->model->leerTodas();
    }

    public function mostrar($id) {
        return $this->model->leerPorId($id);
    }

    public function crear($data) {
        return $this->model->crear($data);
    }

    public function cambiarEstado($id, $estado) {
        return $this->model->actualizarEstado($id, $estado);
    }

    public function eliminar($id) {
        return $this->model->eliminar($id);
    }
}