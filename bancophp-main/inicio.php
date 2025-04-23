<?php
session_start();
require 'conexion.php';
require 'auth.php';

$conn = (new Conexion())->conectar();
$auth = new Auth($conn);

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $user = $auth->login($username, $password);
    
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['nombre'] = $user['nombre_completo'];
        $_SESSION['rol'] = $user['rol'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso | Banco HBC</title>
    <link rel="stylesheet" href="estilos-inicio.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="inicio-page">
    <div class="login-container">
        <div class="bank-logo">
            <i class="fas fa-university"></i>
            <h1>Banco HBC</h1>
            <p>Tu seguridad financiera es nuestra prioridad</p>
        </div>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="post">
            <div class="form-group mb-3">
                <input type="text" name="username" class="form-control" placeholder="Usuario" required>
            </div>
            <div class="form-group mb-4">
                <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
            </div>
            <button type="submit" name="login" class="login-btn">
                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
            </button>
        </form>
    </div>
</body>
</html>