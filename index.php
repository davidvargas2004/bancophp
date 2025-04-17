<?php
require 'conexion.php';
require 'Cuenta.php';

$conn = (new Conexion())->conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numeroCuenta = $_POST['numero'];
    $nombreCliente = $_POST['nombre'];
    $tipo = $_POST['tipo'];
    $saldo = $_POST['saldo'];
    $interes = $tipo == 'ahorros' ? $_POST['interes'] : null;

    $sql = "INSERT INTO cuentas (numero_cuenta, nombre_cliente, tipo_cuenta, saldo, interes_mensual)
            VALUES ('$numeroCuenta', '$nombreCliente', '$tipo', '$saldo', ".($interes ? "'$interes'" : "NULL").")";
    $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Banco HBC</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container p-4">
    <h2 class="mb-4">Crear Cuenta</h2>
    <form method="post" class="mb-4">
        <input type="number" name="numero" class="form-control mb-2" placeholder="Número de cuenta" required>
        <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre cliente" required>
        <select name="tipo" class="form-control mb-2" required>
            <option value="">Tipo de cuenta</option>
            <option value="ahorros">Ahorros</option>
            <option value="corriente">Corriente</option>
        </select>
        <input type="number" step="0.01" name="saldo" class="form-control mb-2" placeholder="Saldo inicial" required>
        <input type="number" step="0.01" name="interes" class="form-control mb-2" placeholder="Interés mensual (solo para ahorros)">
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
</body>
</html>
