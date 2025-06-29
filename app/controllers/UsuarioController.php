<?php
class UsuarioController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // 🔍 Obtener todos los usuarios
    public function listar(): array
    {
        $sql = "SELECT * FROM usuarios ORDER BY id ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 💾 Crear nuevo usuario
    public function guardar(array $data): bool
    {
        $sql = "INSERT INTO usuarios (nombre, correo, password, rol)
                VALUES (:nombre, :correo, :password, :rol)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'nombre' => $data['nombre'],
            'correo' => $data['correo'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'rol' => $data['rol']
        ]);
    }

    // 🔍 Buscar usuario por ID
    public function obtenerPorId(int $id): ?array
    {
        $sql = "SELECT * FROM usuarios WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    // ✏️ Actualizar usuario
    public function actualizar(array $data): bool
    {
        $sql = "UPDATE usuarios SET nombre = :nombre, correo = :correo, rol = :rol WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'nombre' => $data['nombre'],
            'correo' => $data['correo'],
            'rol' => $data['rol'],
            'id' => $data['id']
        ]);
    }

    // 🗑 Eliminar usuario
    public function eliminar(int $id): bool
    {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
// Actualizar la contraseña
    public function actualizarPassword($id, $nueva)
    {
        $sql = "UPDATE usuarios SET password = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([password_hash($nueva, PASSWORD_DEFAULT), $id]);
    }
}