<?php
const DB_HOST = 'localhost'; // Ubicacion DB
const DB_NAME = 'fincas'; // Nombre de la base de datos
const DB_USER = 'root'; // Nombre de usuario
const DB_PASS = ''; // Contraseña

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'"
        ]
    );
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>


