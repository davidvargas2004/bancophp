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
    <link rel="stylesheet" href="css/estilos-inicio.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
</head>
<body class="inicio-page">
    <!-- Efecto de partículas opcional -->
    <div class="particles" id="particles-js"></div>
    
    <div class="login-container">
        <div class="bank-logo">
            <i class="fas fa-university"></i>
            <h1>Banco HBC</h1>
            <p>Tu seguridad financiera es nuestra prioridad</p>
        </div>
        <form method="post">
            <button type="submit" class="login-btn">
                <i class="fas fa-sign-in-alt"></i> Ingresar al Sistema
            </button>
        </form>
    </div>
    
    <script>
        // Inicializar partículas (opcional)
        if(typeof particlesJS !== 'undefined') {
            particlesJS("particles-js", {
                "particles": {
                    "number": {"value": 60, "density": {"enable": true, "value_area": 800}},
                    "color": {"value": "#ffffff"},
                    "shape": {"type": "circle"},
                    "opacity": {"value": 0.5, "random": true},
                    "size": {"value": 3, "random": true},
                    "line_linked": {"enable": true, "distance": 150, "color": "#ffffff", "opacity": 0.3, "width": 1},
                    "move": {"enable": true, "speed": 2, "direction": "none", "random": true, "straight": false, "out_mode": "out"}
                },
                "interactivity": {
                    "detect_on": "canvas",
                    "events": {
                        "onhover": {"enable": true, "mode": "repulse"},
                        "onclick": {"enable": true, "mode": "push"}
                    }
                }
            });
        }
    </script>
</body>
</html>