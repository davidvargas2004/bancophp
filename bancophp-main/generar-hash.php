<?php
$nueva_contraseña = "159753qscAQ."; // Cambia esto por tu nueva contraseña
$hash = password_hash($nueva_contraseña, PASSWORD_DEFAULT);
echo "Hash generado: " . $hash;
?>
