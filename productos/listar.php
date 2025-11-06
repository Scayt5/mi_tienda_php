<?php
session_start();
if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] ?? '') !== 'admin') {
    header("Location: /mi_tienda_php/usuarios/login.php");
    exit;
}
require_once __DIR__ . "/../config/conexion.php";
include(__DIR__ . "/../includes/header.php");

$res = $conn->query("SELECT id, nombre, descripcion, precio, stock, fecha_creacion FROM productos ORDER BY id DESC");
?>
<div class="container mt-5">
    <div class="d-flex justify-content-between mb-3">
        <h2>📦 Lista de Productos</h2>
        <a href="/mi_tienda_php/productos/agregar.php" class="btn btn-success">➕ Agregar Producto</a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
            <tr>
                <th>ID</th><th>Nombre</th><th>Descripción</th><th>Precio (S/)</th><th>Stock</th><th>Fecha</th><th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($res && $res->num_rows>0): while($row = $res->fetch_assoc()): ?>
                <tr>
                    <td><?= (int)$row['id'] ?></td>
                    <td><?= htmlspecialchars($row['nombre']) ?></td>
                    <td><?= htmlspecialchars($row['descripcion']) ?></td>
                    <td><?= number_format((float)$row['precio'], 2) ?></td>
                    <td><?= (int)$row['stock'] ?></td>
                    <td><?= htmlspecialchars($row['fecha_creacion']) ?></td>
                    <td>
                        <a href="/mi_tienda_php/productos/editar.php?id=<?= (int)$row['id'] ?>" class="btn btn-warning btn-sm">✏️ Editar</a>
                        <a href="/mi_tienda_php/productos/eliminar.php?id=<?= (int)$row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este producto?')">🗑️ Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; else: ?>
                <tr><td colspan="7" class="text-center">No hay productos.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include(__DIR__ . "/../includes/footer.php"); ?>
