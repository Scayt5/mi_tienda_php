<?php
session_start();
if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] ?? '') !== 'admin') {
    header("Location: /mi_tienda_php/usuarios/login.php");
    exit;
}
require_once __DIR__ . "/../config/conexion.php";
include(__DIR__ . "/../includes/header.php");

$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST['nombre'] ?? "");
    $descripcion = trim($_POST['descripcion'] ?? "");
    $precio = (float)($_POST['precio'] ?? 0);
    $stock  = (int)($_POST['stock'] ?? 0);

    if ($nombre === "" || $precio <= 0 || $stock < 0) {
        $error = "Revisa nombre, precio y stock.";
    } else {
        $stmt = $conn->prepare("INSERT INTO productos (nombre, descripcion, precio, stock) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssdi", $nombre, $descripcion, $precio, $stock);
        if ($stmt->execute()) {
            header("Location: /mi_tienda_php/productos/listar.php");
            exit;
        } else {
            $error = "Error al guardar el producto.";
        }
        $stmt->close();
    }
}
?>
<div class="container mt-5" style="max-width:640px;">
    <h2>➕ Agregar Producto</h2>
    <?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label>Nombre:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Descripción:</label>
            <textarea name="descripcion" class="form-control" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label>Precio (S/):</label>
            <input type="number" name="precio" step="0.01" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Stock:</label>
            <input type="number" name="stock" class="form-control" required>
        </div>
        <button class="btn btn-success">Guardar</button>
        <a href="/mi_tienda_php/productos/listar.php" class="btn btn-secondary">Volver</a>
    </form>
</div>
<?php include(__DIR__ . "/../includes/footer.php"); ?>
