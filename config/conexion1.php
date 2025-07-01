<?php
const DB_HOST = 'sql207.infinityfree.com';
const DB_NAME = 'if0_39353980_fincas'; // Verifica en tu panel que así se llama la base de datos completa
const DB_USER = 'if0_39353980';
const DB_PASS = 'bUfDD2fMSLy';

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