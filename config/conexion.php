<?php
// config/conexion.php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "tienda_db";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    // En producción podrías loguearlo en vez de mostrarlo:
    die("Error de conexión con MySQL");
}
$conn->set_charset("utf8mb4");
