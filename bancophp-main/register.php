<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: inicio.php");
    exit;
}

require 'conexion.php';
require 'auth.php';

$conn = (new Conexion())->conectar();
$auth = new Auth($conn);

$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nombre = $_POST['nombre'];
    $rol = $_POST['rol'];
    
    if ($auth->registrar($username, $password, $nombre, $rol)) {
        $mensaje = "Usuario registrado exitosamente";
    } else {
        $mensaje = "Error al registrar usuario";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Registrar Usuario | Banco HBC</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container p-4">
    <h2>Registrar Nuevo Usuario</h2>
    <a href="index.php" class="btn btn-secondary mb-4">Volver al Dashboard</a>
    
    <?php if ($mensaje): ?>
        <div class="alert alert-info"><?php echo $mensaje; ?></div>
    <?php endif; ?>
    
    <form method="post" class="mb-4" style="max-width: 500px;">
        <div class="mb-3">
            <label class="form-label">Nombre Completo</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nombre de Usuario</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Rol</label>
            <select name="rol" class="form-control" required>
                <option value="empleado">Empleado</option>
                <option value="admin">Administrador</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Registrar Usuario</button>
    </form>
</body>
</html>