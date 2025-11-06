<?php
session_start();
if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] ?? '') !== 'admin') {
    header("Location: /mi_tienda_php/usuarios/login.php");
    exit;
}
require_once __DIR__ . "/../config/conexion.php";
include(__DIR__ . "/../includes/header.php");

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { header("Location: /mi_tienda_php/productos/listar.php"); exit; }

$stmt = $conn->prepare("SELECT id, nombre, descripcion, precio, stock FROM productos WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$producto = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$producto) { header("Location: /mi_tienda_php/productos/listar.php"); exit; }

$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST['nombre'] ?? "");
    $descripcion = trim($_POST['descripcion'] ?? "");
    $precio = (float)($_POST['precio'] ?? 0);
    $stock  = (int)($_POST['stock'] ?? 0);

    if ($nombre === "" || $precio <= 0 || $stock < 0) {
        $error = "Revisa nombre, precio y stock.";
    } else {
        $up = $conn->prepare("UPDATE productos SET nombre=?, descripcion=?, precio=?, stock=? WHERE id=?");
        $up->bind_param("ssdii", $nombre, $descripcion, $precio, $stock, $id);
        if ($up->execute()) {
            header("Location: /mi_tienda_php/productos/listar.php");
            exit;
        } else {
            $error = "Error al actualizar el producto.";
        }
        $up->close();
    }
}
?>
<div class="container mt-5" style="max-width:640px;">
    <h2>✏️ Editar Producto</h2>
    <?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label>Nombre:</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($producto['nombre']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Descripción:</label>
            <textarea name="descripcion" class="form-control" rows="3"><?= htmlspecialchars($producto['descripcion']) ?></textarea>
        </div>
        <div class="mb-3">
            <label>Precio (S/):</label>
            <input type="number" name="precio" step="0.01" class="form-control" value="<?= number_format((float)$producto['precio'],2,'.','') ?>" required>
        </div>
        <div class="mb-3">
            <label>Stock:</label>
            <input type="number" name="stock" class="form-control" value="<?= (int)$producto['stock'] ?>" required>
        </div>
        <button class="btn btn-primary">Actualizar</button>
        <a href="/mi_tienda_php/productos/listar.php" class="btn btn-secondary">Volver</a>
    </form>
</div>
<?php include(__DIR__ . "/../includes/footer.php"); ?>
