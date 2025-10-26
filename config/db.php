<?php
// inc/db.php
declare(strict_types=1);

$DB_HOST = '127.0.0.1';
$DB_NAME = 'terminal';
$DB_USER = 'root';
$DB_PASS = '12345678'; // o la contraseña de tu instalación AppServ

try {
    // Crear conexión
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
} catch (PDOException $e) {
    // En desarrollo muestra el error; en producción loguea y muestra mensaje genérico
    die("Error de conexión a BD: " . $e->getMessage());
}
