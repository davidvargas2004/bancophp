<?php
require 'conexion.php';
require 'auth.php';

$conn = (new Conexion())->conectar();
$auth = new Auth($conn);

// Crear usuario admin (ejecutar solo una vez)
if ($auth->registrar('admin', 'admin123', 'Administrador Principal', 'admin')) {
    echo "Usuario admin creado. Usuario: admin, Contraseña: admin123";
} else {
    echo "Error al crear usuario o ya existe";
}
?>

