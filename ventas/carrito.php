<?php
include("../config/conexion.php");

if (!isset($_SESSION['usuario'])) {
    header("Location: ../usuarios/login.php");
    exit;
}


if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

if (isset($_POST['producto_id'])) {
    $id = $_POST['producto_id'];
    $cantidad = $_POST['cantidad'] ?? 1;

    $res = $conn->query("SELECT * FROM productos WHERE id = $id");
    $producto = $res->fetch_assoc();

    if ($producto) {
        $_SESSION['carrito'][$id] = [
            'nombre' => $producto['nombre'],
            'precio' => $producto['precio'],
            'cantidad' => $cantidad
        ];
    }
}


if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    unset($_SESSION['carrito'][$id]);
}
?>

<?php include("../includes/header.php"); ?>
<div class="container mt-5">
    <h2>🛒 Carrito de Ventas</h2>
    <a href="../productos/listar.php" class="btn btn-secondary mb-3">⬅ Volver a Productos</a>

    <form method="POST" action="procesar_venta.php">
        <table class="table table-striped">
            <thead class="table-dark">
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario (S/)</th>
                <th>Subtotal (S/)</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $total = 0;
            foreach ($_SESSION['carrito'] as $id => $item):
                $subtotal = $item['precio'] * $item['cantidad'];
                $total += $subtotal;
                ?>
                <tr>
                    <td><?= htmlspecialchars($item['nombre']) ?></td>
                    <td><?= $item['cantidad'] ?></td>
                    <td><?= number_format($item['precio'], 2) ?></td>
                    <td><?= number_format($subtotal, 2) ?></td>
                    <td><a href="?eliminar=<?= $id ?>" class="btn btn-danger btn-sm">🗑️</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <div class="text-end">
            <h4>Total: S/ <?= number_format($total, 2) ?></h4>
            <button type="submit" class="btn btn-success">💾 Registrar Venta</button>
        </div>
    </form>
</div>
<?php include("../includes/footer.php"); ?>

