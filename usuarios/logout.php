<?php
session_start();
$_SESSION = [];
session_destroy();
header("Location: /mi_tienda_php/usuarios/login.php?logout=1");
exit;
