<?php
class ServicioModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function crear($nombre, $icono) {
        $stmt = $this->pdo->prepare("INSERT INTO servicios (nombre, icono) VALUES (?, ?)");
        return $stmt->execute([$nombre, $icono]);
    }

    public function leerTodos() {
        return $this->pdo->query("SELECT * FROM servicios")->fetchAll();
    }

    public function actualizar($id, $nombre, $icono) {
        $stmt = $this->pdo->prepare("UPDATE servicios SET nombre = ?, icono = ? WHERE id = ?");
        return $stmt->execute([$nombre, $icono, $id]);
    }

    public function eliminar($id) {
        $stmt = $this->pdo->prepare("DELETE FROM servicios WHERE id = ?");
        return $stmt->execute([$id]);
    }
}