<?php
session_start();
if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] ?? '') !== 'admin') {
    header("Location: /mi_tienda_php/usuarios/login.php");
    exit;
}
require_once __DIR__ . "/../config/conexion.php";
require_once __DIR__ . "/../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$sql = "
SELECT v.id AS id_venta, v.fecha, p.nombre AS producto, 
       d.cantidad, d.precio_unitario, (d.cantidad * d.precio_unitario) AS subtotal
FROM detalle_ventas d
JOIN ventas v ON v.id = d.venta_id
JOIN productos p ON p.id = d.producto_id
ORDER BY v.fecha DESC
";
$result = $conn->query($sql);
if (!$result || $result->num_rows === 0) {
    die("No hay datos para exportar.");
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Reporte de Ventas');

$sheet->setCellValue('A1','ID Venta');
$sheet->setCellValue('B1','Fecha');
$sheet->setCellValue('C1','Producto');
$sheet->setCellValue('D1','Cantidad');
$sheet->setCellValue('E1','Precio Unitario (S/.)');
$sheet->setCellValue('F1','Subtotal (S/.)');

$sheet->getStyle('A1:F1')->getFont()->setBold(true);

$fila = 2;
$totalGeneral = 0;
while ($row = $result->fetch_assoc()) {
    $sheet->setCellValue("A{$fila}", $row['id_venta']);
    $sheet->setCellValue("B{$fila}", $row['fecha']);
    $sheet->setCellValue("C{$fila}", $row['producto']);
    $sheet->setCellValue("D{$fila}", $row['cantidad']);
    $sheet->setCellValue("E{$fila}", $row['precio_unitario']);
    $sheet->setCellValue("F{$fila}", $row['subtotal']);
    $totalGeneral += (float)$row['subtotal'];
    $fila++;
}

$sheet->setCellValue("E{$fila}", "Total general:");
$sheet->setCellValue("F{$fila}", $totalGeneral);
$sheet->getStyle("E{$fila}:F{$fila}")->getFont()->setBold(true);

foreach (range('A','F') as $col) { $sheet->getColumnDimension($col)->setAutoSize(true); }

$filename = "reporte_ventas_" . date("Ymd_His") . ".xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"{$filename}\"");
$writer = new Xlsx($spreadsheet);
$writer->save("php://output");
exit;
