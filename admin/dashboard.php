<?php
session_start();
if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] ?? '') !== 'admin') {
    header("Location: /mi_tienda_php/usuarios/login.php");
    exit;
}
require_once __DIR__ . "/../config/conexion.php";

function safeScalar($conn, $sql, $field, $default = 0) {
    try {
        $r = $conn->query($sql);
        if ($r && $row = $r->fetch_assoc()) return $row[$field] ?? $default;
    } catch (Throwable $e) {}
    return $default;
}
function safeRows($conn, $sql) {
    $data=[]; try { $r=$conn->query($sql); if($r){ while($row=$r->fetch_assoc()){ $data[]=$row; } } } catch(Throwable $e){}
    return $data;
}

$totalProductos = safeScalar($conn, "SELECT COUNT(*) AS total FROM productos","total",0);
$totalUsuarios  = safeScalar($conn, "SELECT COUNT(*) AS total FROM usuarios","total",0);
$totalVentas    = safeScalar($conn, "SELECT COUNT(*) AS total FROM ventas","total",0);
$totalIngresos  = (float)safeScalar($conn, "SELECT SUM(total) AS total FROM ventas","total",0);

$ultimosProductos = safeRows($conn,"SELECT * FROM productos ORDER BY id DESC LIMIT 5");

$prodGraf = safeRows($conn,"SELECT nombre, stock, precio FROM productos ORDER BY id ASC");
$labelsProductos = array_column($prodGraf,'nombre');
$stocks = array_map('intval', array_column($prodGraf,'stock'));
$precios = array_map('floatval', array_column($prodGraf,'precio'));

$ventasGraf = safeRows($conn,"
  SELECT DATE(fecha) AS fecha, SUM(total) AS total
  FROM ventas
  GROUP BY DATE(fecha)
  ORDER BY fecha ASC
  LIMIT 7
");
$labelsFechas = array_column($ventasGraf,'fecha');
$totalesDia   = array_map('floatval', array_column($ventasGraf,'total'));

$partGraf = safeRows($conn,"
  SELECT p.nombre, SUM(d.cantidad) AS total_vendido
  FROM detalle_ventas d
  JOIN productos p ON p.id = d.producto_id
  GROUP BY p.nombre
  ORDER BY total_vendido DESC
");
$labelsPart  = array_column($partGraf,'nombre');
$valoresPart = array_map('intval', array_column($partGraf,'total_vendido'));

include(__DIR__ . "/../includes/header.php");
@include(__DIR__ . "/navbar.php");
?>
<div class="container-fluid">
    <div class="row">
        <?php @include(__DIR__ . "/sidebar.php"); ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="header-dashboard fadeInUp">
                <h1>📊 Panel de Administración</h1>
                <p>Bienvenido, <strong><?= htmlspecialchars($_SESSION['usuario']) ?></strong>. Gestiona tu tienda con control y estilo.</p>
            </div>
            <hr/>
            <div class="row g-4 mb-4">
                <div class="col-md-3"><div class="card text-bg-primary shadow text-center"><div class="card-body"><h5>Productos</h5><p class="fs-3"><?= (int)$totalProductos ?></p></div></div></div>
                <div class="col-md-3"><div class="card text-bg-success shadow text-center"><div class="card-body"><h5>Usuarios</h5><p class="fs-3"><?= (int)$totalUsuarios ?></p></div></div></div>
                <div class="col-md-3"><div class="card text-bg-warning shadow text-center"><div class="card-body"><h5>Ventas Totales</h5><p class="fs-3"><?= (int)$totalVentas ?></p></div></div></div>
                <div class="col-md-3"><div class="card text-bg-danger shadow text-center"><div class="card-body"><h5>Ingresos</h5><p class="fs-3">S/ <?= number_format($totalIngresos,2) ?></p></div></div></div>
            </div>

            <h4 class="mt-4">🧾 Últimos productos registrados</h4>
            <div class="card shadow mb-4"><div class="card-body">
                    <?php if ($ultimosProductos): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark"><tr><th>ID</th><th>Nombre</th><th>Precio</th><th>Stock</th><th>Fecha</th></tr></thead>
                                <tbody>
                                <?php foreach ($ultimosProductos as $p): ?>
                                    <tr>
                                        <td><?= (int)$p['id'] ?></td>
                                        <td><?= htmlspecialchars($p['nombre']) ?></td>
                                        <td>S/ <?= number_format((float)$p['precio'],2) ?></td>
                                        <td><?= (int)$p['stock'] ?></td>
                                        <td><?= htmlspecialchars($p['fecha_creacion']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info mb-0">Aún no hay productos.</div>
                    <?php endif; ?>
                </div></div>

            <h4 class="mt-4">📈 Estadísticas visuales</h4>
            <div class="row g-4">
                <div class="col-md-6"><div class="card shadow"><div class="card-body">
                            <h5 class="card-title text-center">Stock por Producto</h5><canvas id="graficoStock"></canvas>
                        </div></div></div>
                <div class="col-md-6"><div class="card shadow"><div class="card-body">
                            <h5 class="card-title text-center">Precio por Producto</h5><canvas id="graficoPrecio"></canvas>
                        </div></div></div>
            </div>

            <h4 class="mt-4">📅 Ventas Diarias (últimos 7)</h4>
            <div class="card shadow p-3 mb-4"><canvas id="graficoVentas"></canvas></div>

            <h4 class="mt-4">🥧 Participación de Productos Vendidos</h4>
            <div class="card shadow p-3 mb-4"><canvas id="graficoProductos"></canvas></div>
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labelsProductos = <?= json_encode($labelsProductos, JSON_UNESCAPED_UNICODE) ?>;
    const stocks          = <?= json_encode($stocks) ?>;
    const precios         = <?= json_encode($precios) ?>;
    const labelsFechas    = <?= json_encode($labelsFechas) ?>;
    const totalesDia      = <?= json_encode($totalesDia) ?>;
    const labelsPart      = <?= json_encode($labelsPart, JSON_UNESCAPED_UNICODE) ?>;
    const valoresPart     = <?= json_encode($valoresPart) ?>;

    new Chart(document.getElementById('graficoStock'), {
        type: 'bar', data: {labels: labelsProductos, datasets:[{label:'Stock', data:stocks}]},
        options: {responsive:true, scales:{y:{beginAtZero:true}}}
    });
    new Chart(document.getElementById('graficoPrecio'), {
        type: 'line', data: {labels: labelsProductos, datasets:[{label:'Precio (S/)', data:precios, fill:true, tension:0.3}]},
        options: {responsive:true, scales:{y:{beginAtZero:true}}}
    });
    new Chart(document.getElementById('graficoVentas'), {
        type: 'bar', data: {labels: labelsFechas, datasets:[{label:'Total (S/)', data:totalesDia}]},
        options: {responsive:true, scales:{y:{beginAtZero:true}}}
    });
    new Chart(document.getElementById('graficoProductos'), {
        type: 'doughnut', data: {labels: labelsPart, datasets:[{data: valoresPart}]},
        options: {responsive:true, plugins:{legend:{position:'bottom'}}}
    });
</script>
<?php include(__DIR__ . "/../includes/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartColors = {
        blue: 'rgba(13,110,253,0.7)',
        green: 'rgba(25,135,84,0.7)',
        red: 'rgba(220,53,69,0.7)',
        yellow: 'rgba(255,193,7,0.7)',
        purple: 'rgba(111,66,193,0.7)'
    };


    new Chart(document.getElementById('graficoStock'), {
        type: 'bar',
        data: {
            labels: labelsProductos,
            datasets: [{
                label: 'Stock',
                data: stocks,
                backgroundColor: chartColors.blue,
                borderRadius: 5
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            responsive: true,
            scales: { y: { beginAtZero: true } }
        }
    });


    new Chart(document.getElementById('graficoPrecio'), {
        type: 'line',
        data: {
            labels: labelsProductos,
            datasets: [{
                label: 'Precio (S/)',
                data: precios,
                borderColor: chartColors.green,
                backgroundColor: 'rgba(25,135,84,0.2)',
                tension: 0.3,
                fill: true,
                pointBackgroundColor: chartColors.green
            }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });

    // === GRÁFICO DE VENTAS ===
    new Chart(document.getElementById('graficoVentas'), {
        type: 'bar',
        data: {
            labels: labelsFechas,
            datasets: [{
                label: 'Total Ventas (S/)',
                data: totalesDia,
                backgroundColor: chartColors.yellow,
                borderRadius: 5
            }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });


    new Chart(document.getElementById('graficoProductos'), {
        type: 'doughnut',
        data: {
            labels: labelsPart,
            datasets: [{
                data: valoresPart,
                backgroundColor: [chartColors.blue, chartColors.green, chartColors.red, chartColors.yellow, chartColors.purple]
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });
</script>
</body>
</html>
