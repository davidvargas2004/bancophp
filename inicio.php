<?php
session_start();

if (isset($_SESSION['acceso'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['acceso'] = true;
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso | Banco HBC</title>
    <link href="css/estilos.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <i class="fas fa-university"></i>
            <h1>Banco HBC</h1>
            <p>Sistema de Gestión Bancaria</p>
        </div>
        
        <form method="post" class="login-form">
            <div class="form-group">
                <button type="submit" class="login-button">
                    <i class="fas fa-sign-in-alt"></i> Ingresar al Sistema
                </button>
            </div>
        </form>
        
        <div class="login-footer">
            <p>Versión 1.0 &copy; <?php echo date('Y'); ?></p>
        </div>
    </div>
</body>
</html>