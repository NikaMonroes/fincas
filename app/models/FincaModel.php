<?php

class FincaModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function leerTodos() {
        $sql = "SELECT * FROM fincas ORDER BY nombre ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function leerPorRef($ref) {
        $sql = "SELECT * FROM fincas WHERE ref = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$ref]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($data) {
    $sql = "INSERT INTO fincas (
        ref, nombre, zona, destino, ubicacion, distancia, clima,
        capacidad, estrellas, p_temporada_alta, p_temporada_baja,
        imagen, observaciones
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([
        $data['ref'],
        $data['nombre'],
        $data['zona'],
        $data['destino'],
        $data['ubicacion'],
        $data['distancia'],
        $data['clima'],
        $data['capacidad'],
        $data['estrellas'],
        $data['p_temporada_alta'],
        $data['p_temporada_baja'],
        $data['imagen'],
        $data['observaciones']
    ]);
}

    public function actualizar($ref, $data) {
    $sql = "UPDATE fincas SET 
        nombre = ?, zona = ?, destino = ?, ubicacion = ?, distancia = ?, clima = ?, 
        capacidad = ?, estrellas = ?, p_temporada_alta = ?, p_temporada_baja = ?, 
        imagen = ?, observaciones = ?
        WHERE ref = ?";

    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([
        $data['nombre'],
        $data['zona'],
        $data['destino'],
        $data['ubicacion'],
        $data['distancia'],
        $data['clima'],
        $data['capacidad'],
        $data['estrellas'],
        $data['p_temporada_alta'],
        $data['p_temporada_baja'],
        $data['imagen'],
        $data['observaciones'],
        $ref
    ]);
}

    public function eliminar($ref) {
        $sql = "DELETE FROM fincas WHERE ref = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$ref]);
    }

    public function obtenerImagenes($ref) {
        $sql = "SELECT * FROM finca_imagenes WHERE ref_finca = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$ref]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function guardarImagenDeFinca($ref, $nombreImagen) {
    $sql = "INSERT INTO finca_imagenes (ref_finca, imagen) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$ref, $nombreImagen]);
    }

    //eliminar imagen galeria
    public function eliminarImagen($id) {
    // Opcional: recuperar el nombre del archivo y eliminarlo del sistema de archivos
    $stmt = $this->pdo->prepare("SELECT imagen FROM finca_imagenes WHERE id = ?");
    $stmt->execute([$id]);
    $nombre = $stmt->fetchColumn();

    if ($nombre && file_exists(__DIR__ . '/../../public/img/' . $nombre)) {
        unlink(__DIR__ . '/../../public/img/' . $nombre);
    }

    // Eliminar el registro de la base de datos
    $stmt = $this->pdo->prepare("DELETE FROM finca_imagenes WHERE id = ?");
    return $stmt->execute([$id]);
}

    // leer finca por referencia
    public function leerPorReferencia($ref) {
        $stmt = $this->pdo->prepare("SELECT * FROM fincas WHERE ref = ?");
        $stmt->execute([$ref]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // CONSULTA DE FINCAS
    public function filtrarPorZona($zona) {
    $stmt = $this->pdo->prepare("SELECT * FROM fincas WHERE zona = ?");
    $stmt->execute([$zona]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function filtrarPorDestino($destino) {
        $stmt = $this->pdo->prepare("SELECT * FROM fincas WHERE destino = ?");
        $stmt->execute([$destino]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

        public function leerTodas() {
        $stmt = $this->pdo->query("SELECT * FROM reservas ORDER BY creado_en DESC");
        return $stmt->fetchAll();
    }
}
