<?php
session_start();

// Redirigir si ya está logueado (opcional) UWU
if (isset($_SESSION['acceso'])) {
    header("Location: index.php");
    exit;
}
// este ingresos era sin contraseña manito
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
    <title>Banco HBC - Acceso</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="css/estilos.css" rel="stylesheet">
</head>
<body>
    <div class="contenedor-acceso">
        <div class="tarjeta-acceso">
            <div class="logo-banco">
                <i class="fas fa-university"></i>
                <h1>Banco HBC</h1>
            </div>
            
            <form method="post" class="formulario-acceso">
                <div class="mb-3">
                    <label for="nombreUsuario" class="form-label">Bienvenido</label>
                    <p class="text-muted">Sistema de Gestión de Cuentas Bancarias</p>
                </div>
                
                <button type="submit" class="btn btn-primary btn-acceso">
                    <i class="fas fa-sign-in-alt me-2"></i> Ingresar al Sistema
                </button>
            </form>
            
            <div class="pie-tarjeta">
                <p class="text-muted small">© <?php echo date('Y'); ?> Banco HBC. Todos los derechos reservados.</p>
            </div>
        </div>
    </div>
</body>
</html>