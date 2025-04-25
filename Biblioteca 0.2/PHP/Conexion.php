<?php
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$basededatos = "biblioteca";

$conexion = new mysqli($servidor, $usuario, $contrasena, $basededatos);

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
} else {
    echo "Conexión exitosa a la base de datos 'biblioteca'";
}
?>
