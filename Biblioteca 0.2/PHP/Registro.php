<?php
include 'Conexion.php';

// Obtener datos del formulario (registro.html está una carpeta atrás, pero eso no afecta el $_POST)
$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];
$rol = "usuario";

// Función para generar un ID de usuario personalizado (máximo 8 caracteres)
function generarIdUsuario($nombre, $telefono, $correo) {
    $letras_nombre = substr(preg_replace('/[^A-Za-z]/', '', $nombre), 0, 2);
    $digitos_telefono = substr(preg_replace('/\D/', '', $telefono), -2);
    $letras_correo = substr(preg_replace('/[^A-Za-z]/', '', $correo), 0, 1);
    $aleatorio = strval(rand(100, 999));

    $id = strtoupper($letras_nombre . $digitos_telefono . $letras_correo . $aleatorio);
    return substr($id, 0, 8);
}

$id_usuario = generarIdUsuario($nombre, $telefono, $correo);

// Preparar sentencia
$stmt = $conexion->prepare("INSERT INTO usuarios (id_usuario, Nombre, Telefono, Correo, Contrasena, Rol) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $id_usuario, $nombre, $telefono, $correo, $contrasena, $rol);

// Ejecutar
if ($stmt->execute()) {
    echo "Usuario registrado correctamente con ID: $id_usuario";
    header("Location: ../index.html");
exit();
} else {
    echo "Error al registrar: " . $stmt->error;
}

// Cerrar conexión
$stmt->close();
$conexion->close();
?>
