<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: inicio.php");
    exit;
}

require 'conexion.php';
$conn = (new Conexion())->conectar();


$mensaje = "";

// Crear cuenta
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['crear'])) {
    $numeroCuenta = $_POST['numero'];
    $nombreCliente = $_POST['nombre'];
    $tipo = $_POST['tipo'];
    $saldo = $_POST['saldo'];
    $interes = $tipo == 'ahorros' ? $_POST['interes'] : null;

    $sql = "INSERT INTO cuentas (numero_cuenta, nombre_cliente, tipo_cuenta, saldo, interes_mensual)
            VALUES ('$numeroCuenta', '$nombreCliente', '$tipo', '$saldo', ".($interes ? "'$interes'" : "NULL").")";
    if ($conn->query($sql)) {
        $mensaje = "✅ Cuenta creada exitosamente.";
    } else {
        $mensaje = "❌ Error al crear la cuenta.";
    }
}

// Depositar
if (isset($_POST['depositar'])) {
    $cuenta = $_POST['cuenta'];
    $monto = $_POST['monto'];

    $update = $conn->query("UPDATE cuentas SET saldo = saldo + $monto WHERE numero_cuenta = '$cuenta'");
    if ($update && $conn->affected_rows > 0) {
        $mensaje = "✅ Depósito de \$$monto realizado correctamente en la cuenta $cuenta.";
    } else {
        $mensaje = "❌ Cuenta no encontrada para depositar.";
    }
}

// Retirar
if (isset($_POST['retirar'])) {
    $cuenta = $_POST['cuenta'];
    $monto = $_POST['monto'];

    $resultado = $conn->query("SELECT saldo, tipo_cuenta FROM cuentas WHERE numero_cuenta = '$cuenta'");
    $cuentaDatos = $resultado->fetch_assoc();

    if ($cuentaDatos) {
        $saldoActual = $cuentaDatos['saldo'];
        $tipo = $cuentaDatos['tipo_cuenta'];

        if ($tipo == 'corriente') {
            $nuevoSaldo = $saldoActual - $monto - ($monto * 0.004);
            if ($nuevoSaldo >= 300000) {
                $conn->query("UPDATE cuentas SET saldo = $nuevoSaldo WHERE numero_cuenta = '$cuenta'");
                $mensaje = "✅ Retiro de \$$monto realizado en cuenta corriente $cuenta. Nuevo saldo: \$$nuevoSaldo.";
            } else {
                $mensaje = "⚠️ Excede el límite de sobregiro permitido en cuenta corriente.";
            }
        } else {
            if ($monto <= $saldoActual) {
                $nuevoSaldo = $saldoActual - $monto;
                $conn->query("UPDATE cuentas SET saldo = $nuevoSaldo WHERE numero_cuenta = '$cuenta'");
                $mensaje = "✅ Retiro de \$$monto realizado en cuenta de ahorros $cuenta. Nuevo saldo: \$$nuevoSaldo.";
            } else {
                $mensaje = "⚠️ Saldo insuficiente en cuenta de ahorros.";
            }
        }
    } else {
        $mensaje = "❌ Cuenta no encontrada para retiro.";
    }
}

// Consultar saldo
if (isset($_POST['consultar'])) {
    $cuenta = $_POST['cuenta'];
    $resultado = $conn->query("SELECT saldo FROM cuentas WHERE numero_cuenta = '$cuenta'");
    $cuentaDatos = $resultado->fetch_assoc();
    if ($cuentaDatos) {
        $mensaje = "📊 Saldo actual de la cuenta $cuenta: \$".$cuentaDatos['saldo'].".";
    } else {
        $mensaje = "❌ Cuenta no encontrada para consulta.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Banco HBC</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container p-4">
<div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Banco HBC</h1>
        <div>
            <span class="me-3">Bienvenido, <?php echo $_SESSION['nombre']; ?></span>
            <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
        </div>
    </div>

    <?php if ($_SESSION['rol'] === 'admin'): ?>
        <div class="alert alert-warning mb-4">
            <h4>Panel de Administración</h4>
            <!-- agregar funciones solo para admin -->
        </div>
    <?php endif; ?>
    <h2 class="mb-4">Crear Cuenta</h2>
    <form method="post" class="mb-4">
        <input type="hidden" name="crear" value="1">
        <input type="number" name="numero" class="form-control mb-2" placeholder="Número de cuenta" required>
        <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre cliente" required>
        <select name="tipo" class="form-control mb-2" required>
            <option value="">Tipo de cuenta</option>
            <option value="ahorros">Ahorros</option>
            <option value="corriente">Corriente</option>
        </select>
        <input type="number" step="0.01" name="saldo" class="form-control mb-2" placeholder="Saldo inicial" required>
        <input type="number" step="0.01" name="interes" class="form-control mb-2" placeholder="Interés mensual (solo ahorros)">
        <button class="btn btn-primary">Crear</button>
    </form>

    <h4>Cuentas Registradas</h4>
    <table class="table table-bordered">
        <tr><th>N° Cuenta</th><th>Cliente</th><th>Tipo</th><th>Saldo</th><th>Interés</th></tr>
        <?php
        $result = $conn->query("SELECT * FROM cuentas");
        while($row = $result->fetch_assoc()){
            echo "<tr>
                    <td>{$row['numero_cuenta']}</td>
                    <td>{$row['nombre_cliente']}</td>
                    <td>{$row['tipo_cuenta']}</td>
                    <td>\${$row['saldo']}</td>
                    <td>".($row['interes_mensual'] ?? '-')."</td>
                  </tr>";
        }
        ?>
    </table>

    <h4 class="mt-4">Operaciones</h4>
    <form method="post" class="mb-3">
        <input type="text" name="cuenta" class="form-control mb-2" placeholder="Número de cuenta" required>
        <input type="number" step="0.01" name="monto" class="form-control mb-2" placeholder="Monto">
        <button name="depositar" class="btn btn-success">Depositar</button>
        <button name="retirar" class="btn btn-warning">Retirar</button>
        <button name="consultar" class="btn btn-info">Consultar Saldo</button>
    </form>

    <?php if ($mensaje): ?>
        <div class="alert alert-info"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
</body>
</html>