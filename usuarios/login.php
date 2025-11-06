<?php
session_start();
include("../config/conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = md5($_POST['password']); // cifrado básico MD5

    $sql = "SELECT * FROM usuarios WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $_SESSION['usuario'] = $user['nombre'];
        $_SESSION['rol'] = $user['rol'];

        // 🔐 Redirección según el rol
        if ($user['rol'] === 'admin') {
            header("Location: ../admin/dashboard.php");
        } else {
            header("Location: ../productos/listar.php");
        }
        exit;
    } else {
        $error = "Correo o contraseña incorrectos";
    }
}
?>

<?php include("../includes/header.php"); ?>
<div class="container mt-5" style="max-width:400px;">
    <h2 class="text-center mb-4">🔐 Iniciar Sesión</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger text-center"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Correo electrónico</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Ingresar</button>
    </form>

    <div class="text-center mt-3">
        <a href="registro.php">¿No tienes cuenta? Regístrate</a>
    </div>
</div>
<?php include("../includes/footer.php"); ?>
