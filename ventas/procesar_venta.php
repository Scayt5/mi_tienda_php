<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: /mi_tienda_php/usuarios/login.php");
    exit;
}

require_once __DIR__ . "/../config/conexion.php";

if (empty($_SESSION['carrito'])) {
    header("Location: /mi_tienda_php/ventas/carrito.php");
    exit;
}

// ======================================================
// 1️⃣ Calcular total general
// ======================================================
$total = 0;
foreach ($_SESSION['carrito'] as $item) {
    $total += $item['precio'] * $item['cantidad'];
}

// ======================================================
// 2️⃣ Insertar en tabla `ventas`
// ======================================================
$stmtVenta = $conn->prepare("INSERT INTO ventas (usuario_id, total) VALUES (?, ?)");
$idUsuario = 1; // ⚠️ Puedes obtener el ID real del usuario logueado si lo guardas en sesión
$stmtVenta->bind_param("id", $idUsuario, $total);

if (!$stmtVenta->execute()) {
    die("Error al registrar la venta: " . $conn->error);
}

$idVenta = $stmtVenta->insert_id;
$stmtVenta->close();

// ======================================================
// 3️⃣ Insertar detalles y actualizar stock
// ======================================================
$stmtDetalle = $conn->prepare("INSERT INTO detalle_ventas (venta_id, producto_id, cantidad, precio_unitario) VALUES (?, ?, ?, ?)");
$stmtStock   = $conn->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?");

foreach ($_SESSION['carrito'] as $producto_id => $item) {
    $cantidad = $item['cantidad'];
    $precio = $item['precio'];

    // Insertar detalle
    $stmtDetalle->bind_param("iiid", $idVenta, $producto_id, $cantidad, $precio);
    $stmtDetalle->execute();

    // Actualizar stock
    $stmtStock->bind_param("ii", $cantidad, $producto_id);
    $stmtStock->execute();
}

$stmtDetalle->close();
$stmtStock->close();

// ======================================================
// 4️⃣ Limpiar carrito
// ======================================================
unset($_SESSION['carrito']);

// ======================================================
// 5️⃣ Redirigir al listado de ventas con mensaje
// ======================================================
$_SESSION['mensaje'] = "✅ Venta registrada correctamente.";
header("Location: /mi_tienda_php/ventas/listar.php");
exit;
