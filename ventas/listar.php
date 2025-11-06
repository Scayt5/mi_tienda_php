<?php
session_start();
if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] ?? '') !== 'admin') {
    header("Location: /mi_tienda_php/usuarios/login.php");
    exit;
}
require_once __DIR__ . "/../config/conexion.php";
include(__DIR__ . "/../includes/header.php");

$ventas = $conn->query("SELECT id, fecha, total FROM ventas ORDER BY id DESC");
?>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>📋 Historial de Ventas</h2>
        <div>
            <a href="/mi_tienda_php/ventas/exportar_excel.php" class="btn btn-success">⬇️ Exportar a Excel</a>
            <a href="/mi_tienda_php/admin/dashboard.php" class="btn btn-secondary">⬅ Volver al Dashboard</a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
            <tr><th>ID Venta</th><th>Fecha</th><th>Total (S/)</th></tr>
            </thead>
            <tbody>
            <?php if ($ventas && $ventas->num_rows>0): while($v = $ventas->fetch_assoc()): ?>
                <tr>
                    <td><?= (int)$v['id'] ?></td>
                    <td><?= htmlspecialchars($v['fecha']) ?></td>
                    <td><?= number_format((float)$v['total'],2) ?></td>
                </tr>
            <?php endwhile; else: ?>
                <tr><td colspan="3" class="text-center">No hay ventas registradas</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include(__DIR__ . "/../includes/footer.php"); ?>
