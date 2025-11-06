<?php
session_start();
require_once __DIR__ . "/../config/conexion.php";

$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST['nombre'] ?? "");
    $email  = trim($_POST['email'] ?? "");
    $pass   = $_POST['password'] ?? "";

    if ($nombre === "" || $email === "" || $pass === "") {
        $error = "Todos los campos son obligatorios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Correo inválido.";
    } else {
        // Verificar duplicado
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $dup = $stmt->get_result()->num_rows > 0;
        $stmt->close();

        if ($dup) {
            $error = "El correo ya está registrado.";
        } else {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, 'empleado')");
            $stmt->bind_param("sss", $nombre, $email, $hash);
            if ($stmt->execute()) {
                header("Location: /mi_tienda_php/usuarios/login.php?registro=ok");
                exit;
            } else {
                $error = "Error al registrar usuario.";
            }
            $stmt->close();
        }
    }
}
include(__DIR__ . "/../includes/header.php");
?>
<div class="container mt-5" style="max-width:420px;">
    <h2 class="text-center mb-4">🧍 Registro de Usuario</h2>
    <?php if ($error): ?><div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Correo</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-success w-100">Registrar</button>
        <div class="text-center mt-3">
            <a href="/mi_tienda_php/usuarios/login.php">¿Ya tienes cuenta? Inicia sesión</a>
        </div>
    </form>
</div>
<?php include(__DIR__ . "/../includes/footer.php"); ?>
