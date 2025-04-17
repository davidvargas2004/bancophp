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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="background"></div>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="bank-icon">
                    <i class="fas fa-university"></i>
                </div>
                <h1>Banco HBC</h1>
                <p class="subtitle">Sistema de Gestión Bancaria</p>
            </div>
            
            <form method="post" class="login-form">
                <div class="form-group">
                    <label for="username">Usuario</label>
                    <input type="text" id="username" placeholder="Ingrese su usuario">
                </div>
                
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" placeholder="Ingrese su contraseña">
                    <i class="fas fa-eye toggle-password"></i>
                </div>
                
                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox"> Recordar usuario
                    </label>
                    <a href="#" class="forgot-password">¿Olvidó su contraseña?</a>
                </div>
                
                <button type="submit" class="login-button">
                    <i class="fas fa-sign-in-alt"></i> Ingresar al Sistema
                </button>
            </form>
            
            <div class="login-footer">
                <p>Versión 1.0 &copy; <?php echo date('Y'); ?> Banco HBC. Todos los derechos reservados.</p>
                <div class="security-info">
                    <i class="fas fa-lock"></i>
                    <span>Sistema seguro</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>