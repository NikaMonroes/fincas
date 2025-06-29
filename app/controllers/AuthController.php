<?php
class AuthController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Iniciar sesión
    public function login(string $correo, string $password): void
    {
        $sql = "SELECT * FROM usuarios WHERE correo = :correo LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['correo' => $correo]);

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($password, $usuario['password'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_rol'] = $usuario['rol'];

            // Redirigir al panel correspondiente
            switch ($usuario['rol']) {
                case 'admin':
                    header("Location: ?accion=admin");
                    break;
                case 'editor':
                    header("Location: ?accion=editor");
                    break;
                default:
                    header("Location: ?accion=login");
            }
            exit;
        } else {
            $_SESSION['error_login'] = 'Correo o contraseña incorrectos';
            header("Location: ?accion=login");
            exit;
        }
    }

    // Cerrar sesión
    public function logout(): void
    {
        session_unset();
        session_destroy();
        header("Location: ?accion=login");
        exit;
    }
}