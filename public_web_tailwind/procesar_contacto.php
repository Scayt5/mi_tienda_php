<?php
require_once __DIR__ . "/../config/conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre  = trim($_POST['nombre'] ?? "");
    $email   = trim($_POST['email'] ?? "");
    $mensaje = trim($_POST['mensaje'] ?? "");

    if ($nombre === "" || $email === "" || $mensaje === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: /mi_tienda_php/public_web_tailwind/contact.php?error=1");
        exit;
    }

    $conn->query("CREATE TABLE IF NOT EXISTS mensajes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    email VARCHAR(100),
    mensaje TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  )");

    $stmt = $conn->prepare("INSERT INTO mensajes (nombre, email, mensaje) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $email, $mensaje);
    $ok = $stmt->execute();
    $stmt->close();

    header("Location: /mi_tienda_php/public_web_tailwind/contact.php?" . ($ok ? "success=1" : "error=1"));
    exit;
}
header("Location: /mi_tienda_php/public_web_tailwind/contact.php");
exit;
