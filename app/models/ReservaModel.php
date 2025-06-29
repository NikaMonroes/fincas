<?php
class ReservaModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Verifica si ya existe alguna reserva que cruce con ese rango para la misma finca
    public function hayCruceDeFechas($ref_finca, $inicio, $fin) {
        $sql = "SELECT COUNT(*) FROM reservas 
                WHERE ref_finca = ? 
                AND estado IN ('pendiente', 'confirmada') 
                AND (
                    (fecha_inicio <= ? AND fecha_fin >= ?) OR
                    (fecha_inicio <= ? AND fecha_fin >= ?) OR
                    (fecha_inicio >= ? AND fecha_fin <= ?)
                )";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $ref_finca,
            $inicio, $inicio,
            $fin, $fin,
            $inicio, $fin
        ]);

        return $stmt->fetchColumn() > 0;
    }

    // Crea la reserva
    public function crear($data) {
        $sql = "INSERT INTO reservas 
                (ref_finca, fecha_inicio, fecha_fin, nombre_cliente, email_cliente, telefono_cliente, direccion, ciudad_cliente, observaciones, estado) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pendiente')";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['ref_finca'],
            $data['fecha_inicio'],
            $data['fecha_fin'],
            $data['nombre_cliente'],
            $data['email_cliente'],
            $data['telefono_cliente'],
            $data['direccion'],
            $data['ciudad_cliente'],
            $data['observaciones']
        ]);
    }


    /*public function leerTodas() {
        $stmt = $this->pdo->query("SELECT * FROM reservas ORDER BY creado_en DESC");
        return $stmt->fetchAll();
    }*/

public function leerTodas() {
    $sql = "SELECT r.*, f.nombre AS nombre_finca
            FROM reservas r
            LEFT JOIN fincas f ON r.ref_finca = f.ref
            ORDER BY r.creado_en DESC";
    $stmt = $this->pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



    public function leerPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM reservas WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function actualizarEstado($id, $estado) {
    $sql = "UPDATE reservas SET estado = ? WHERE id = ?";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([$estado, $id]);
}


    public function eliminar($id) {
    $sql = "DELETE FROM reservas WHERE id = ?";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([$id]);
}


    // Acepta o rechaza la reserva
    public function rechazar($id) {
    $sql = "UPDATE reservas SET estado = 'rechazada' WHERE id = ?";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([$id]);
}


}


/*class ReservaModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Verifica si ya existe alguna reserva que cruce con ese rango para la misma finca
    public function hayCruceDeFechas($ref_finca, $inicio, $fin) {
        $sql = "SELECT COUNT(*) FROM reservas 
                WHERE ref_finca = ? 
                AND estado IN ('pendiente', 'confirmada') 
                AND (
                    (fecha_inicio <= ? AND fecha_fin >= ?) OR
                    (fecha_inicio <= ? AND fecha_fin >= ?) OR
                    (fecha_inicio >= ? AND fecha_fin <= ?)
                )";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $ref_finca,
            $inicio, $inicio,
            $fin, $fin,
            $inicio, $fin
        ]);

        return $stmt->fetchColumn() > 0;
    }

    

    //crear solo para pruebas
 public function actualizar($ref, $data) {
    $sql = "UPDATE fincas SET 
        nombre = ?, zona = ?, destino = ?, ubicacion = ?, distancia = ?, clima = ?, 
        capacidad = ?, estrellas = ?, p_temporada_alta = ?, p_temporada_baja = ?, 
        imagen = ?, observaciones = ?, destacada = ?
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
        $data['destacada'] ?? 0,
        $ref
    ]);
}
// fin pruebas

    public function leerTodas() {
        $stmt = $this->pdo->query("SELECT * FROM reservas ORDER BY creado_en DESC");
        return $stmt->fetchAll();
    }

    public function leerPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM reservas WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function actualizarEstado($id, $estado) {
        $stmt = $this->pdo->prepare("UPDATE reservas SET estado = ? WHERE id = ?");
        return $stmt->execute([$estado, $id]);
    }

    public function eliminar($id) {
        $stmt = $this->pdo->prepare("DELETE FROM reservas WHERE id = ?");
        return $stmt->execute([$id]);
    }

    //
}
*/